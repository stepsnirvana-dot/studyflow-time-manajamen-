<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Course;
use Illuminate\Http\Request;

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

        // Daftar matkul untuk pilihan di dropdown modal
        $courses = Course::all();

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
}