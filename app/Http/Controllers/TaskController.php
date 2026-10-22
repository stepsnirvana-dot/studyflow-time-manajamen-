<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    /**
     * Tampilkan Kanban Board hanya untuk tugas milik user yang sedang login.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Ambil task HANYA milik user yang sedang login
        $tasks = $user->tasks()->with('course')->get();

        // Filter task berdasarkan status
        $todoTasks = $tasks->where('status', 'todo');
        $inProgressTasks = $tasks->where('status', 'in_progress');
        $doneTasks = $tasks->where('status', 'done');

        // PERBAIKAN: Ambil HANYA matkul milik user aktif agar tidak bocor
        $courses = Course::where('user_id', $user->id)->get();

        return view('dashboard', compact('tasks', 'todoTasks', 'inProgressTasks', 'doneTasks', 'courses'));
    }

    /**
     * Simpan task baru ke akun user yang sedang login.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'course_id'   => 'required|exists:courses,id',
            'due_date'    => 'required|date',
            'priority'    => 'nullable|in:low,medium,high',
            'description' => 'nullable|string',
        ]);

        // Otomatis terhubung dengan user_id lewat relasi tasks()
        $request->user()->tasks()->create([
            'title'       => $validated['title'],
            'course_id'   => $validated['course_id'],
            'due_date'    => $validated['due_date'],
            'priority'    => $validated['priority'] ?? 'medium',
            'description' => $validated['description'] ?? null,
            'status'      => 'todo',
        ]);

        return redirect()->route('dashboard')->with('success', 'Task berhasil dibuat!');
    }

    /**
     * Perbarui status task dengan proteksi keamanan (IDOR).
     */
    public function updateStatus(Request $request, Task $task)
    {
        // Tolak jika task ini bukan milik user yang login
        abort_unless($task->user_id === $request->user()->id, 403, 'Akses tidak diizinkan.');

        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Status task berhasil diperbarui!');
    }

    /**
     * Endpoint AI Study Assistant dengan integrasi Google Gemini API.
     */
    public function aiChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = $request->user();
        $apiKey = env('GEMINI_API_KEY') ?: config('services.gemini.key');

        if (!$apiKey) {
            return response()->json([
                'status' => 'error',
                'reply' => 'Gemini API Key belum terdeteksi. Pastikan sudah ditulis di .env!',
                'time' => now()->format('H:i')
            ]);
        }

        // Ambil konteks data tugas & courses milik user aktif
        $todoTasks = $user->tasks()->where('status', 'todo')->with('course')->get();
        $inProgressTasks = $user->tasks()->where('status', 'in_progress')->with('course')->get();
        $doneTasks = $user->tasks()->where('status', 'done')->get();
        $courses = Course::where('user_id', $user->id)->get();

        $taskSummary = "Daftar Tugas To Do:\n";
        foreach ($todoTasks as $t) {
            $taskSummary .= "- {$t->title} (MK: " . ($t->course->course_name ?? '-') . ", Deadline: {$t->due_date})\n";
        }
        $taskSummary .= "Daftar Tugas In Progress:\n";
        foreach ($inProgressTasks as $t) {
            $taskSummary .= "- {$t->title} (MK: " . ($t->course->course_name ?? '-') . ")\n";
        }
        $taskSummary .= "Tugas Selesai: " . $doneTasks->count() . " tugas.\n";

        $courseSummary = "Mata Kuliah Terdaftar:\n";
        foreach ($courses as $c) {
            $courseSummary .= "- {$c->course_code} {$c->course_name} ({$c->schedule_time}, Ruang: {$c->room})\n";
        }

        $systemInstruction = "Kamu adalah Study Assistant cerdas di aplikasi StudyFlow untuk mahasiswa bernama {$user->name}. "
            . "Tugasmu membantu merencanakan waktu belajar (Pomodoro), memberikan prioritas tugas, dan menjawab pertanyaan jadwal kuliah. "
            . "Gunakan bahasa Indonesia yang santun, suportif, dan ringkas.\n\n"
            . "Data akademik terkini {$user->name}:\n"
            . "{$courseSummary}\n"
            . "{$taskSummary}\n";

        try {
            // Gunakan withoutVerifying() untuk menghindari SSL certificate issue pada localhost Windows
            $response = Http::withoutVerifying()
    ->withHeaders([
        'Content-Type' => 'application/json'
    ])
    ->timeout(20)
    ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash-lite:generateContent?key={$apiKey}", [
        'contents' => [
            [
                'role' => 'user',
                'parts' => [
                    ['text' => $systemInstruction . "\n\nPertanyaan mahasiswa: " . $request->message]
                ]
            ]
        ]
    ]);

            if ($response->successful()) {
                $result = $response->json();
                $replyText = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, belum ada tanggapan.';
                $formattedReply = nl2br(e($replyText));
                
                return response()->json([
                    'status' => 'success',
                    'reply' => $formattedReply,
                    'time' => now()->format('H:i')
                ]);
            } else {
                $err = $response->json();
                $errMsg = $err['error']['message'] ?? ('HTTP ' . $response->status());
                return response()->json([
                    'status' => 'error',
                    'reply' => 'Respon Gemini API: ' . $errMsg,
                    'time' => now()->format('H:i')
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'reply' => 'Kendala Server: ' . $e->getMessage(),
                'time' => now()->format('H:i')
            ]);
        }
    }
}