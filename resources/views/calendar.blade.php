<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyFlow - Academic Calendar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased flex h-screen overflow-hidden text-sm">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between flex-shrink-0 z-20">
        <div class="p-5 space-y-6">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-base shadow-sm">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-lg font-bold text-slate-900 tracking-tight">StudyFlow</span>
            </div>
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                    <i class="fa-regular fa-rectangle-list w-4 text-center"></i>
                    <span>My tasks</span>
                </a>
                <a href="{{ route('calendar.index') }}" class="flex items-center space-x-3 px-3 py-2 font-semibold text-indigo-600 bg-indigo-50/80 rounded-xl">
                    <i class="fa-regular fa-calendar w-4 text-center"></i>
                    <span>Calendar</span>
                </a>
                <a href="{{ route('courses.index') }}" class="flex items-center space-x-3 px-3 py-2 font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                    <i class="fa-solid fa-book-open w-4 text-center"></i>
                    <span>Courses</span>
                </a>
                <a href="{{ route('focus.index') }}" class="flex items-center space-x-3 px-3 py-2 font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                    <i class="fa-regular fa-clock w-4 text-center"></i>
                    <span>Focus</span>
                </a>
            </nav>
        </div>

        <!-- Profil Dinamis -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between px-4">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="leading-tight truncate">
                    <p class="font-semibold text-xs text-slate-900 truncate">{{ Auth::user()->name ?? 'Student' }}</p>
                    <p class="text-[11px] text-slate-400">Student Account</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" title="Logout" class="text-slate-400 hover:text-rose-600 p-1.5 transition">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Calendar View -->
    <main class="flex-1 flex flex-col min-w-0 bg-white overflow-y-auto">
        <header class="h-16 border-b border-slate-200 px-8 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-slate-900">Academic Schedule & Deadlines</h1>
                <p class="text-xs text-slate-400">{{ now()->format('F Y') }} · Class schedules mapped with task due dates</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('courses.index') }}" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-semibold text-xs px-3.5 py-2 rounded-xl transition">
                    Manage Courses
                </a>
                <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs px-3.5 py-2 rounded-xl flex items-center space-x-1.5 shadow-sm transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Back to Tasks</span>
                </a>
            </div>
        </header>

        <div class="p-8 space-y-6">
            <!-- Weekly Columns -->
            <div class="grid grid-cols-5 gap-4">
                @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                @endphp
                @foreach($days as $day)
                    @php
                        // Filter matkul yang mengandung nama hari pada kolom schedule_time (misal: "Monday · 09:00 - 10:30")
                        $dayCourses = $courses->filter(function($c) use ($day) {
                            return str_contains($c->schedule_time ?? '', $day);
                        });

                        // Filter deadline tugas yang jatuh pada hari tersebut
                        $dayTasks = $tasks->filter(function($t) use ($day) {
                            return $t->due_date ? date('l', strtotime($t->due_date)) === $day : false;
                        });
                    @endphp
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 min-h-[550px] space-y-3">
                        <div class="border-b border-slate-200/80 pb-2">
                            <span class="font-bold text-xs text-slate-700 block">{{ $day }}</span>
                            <span class="text-[10px] text-slate-400">Lecture & Deadlines</span>
                        </div>

                        <!-- Daftar Kelas / Mata Kuliah Dinamis -->
                        @foreach($dayCourses as $course)
                            <div class="p-2.5 rounded-xl text-xs space-y-1 border-l-4 shadow-2xs bg-white" style="border-color: {{ $course->color_hex }}">
                                <span class="font-bold block" style="color: {{ $course->color_hex }}">
                                    {{ trim(explode('·', $course->schedule_time)[1] ?? $course->schedule_time) }}
                                </span>
                                <p class="font-semibold text-slate-800">{{ $course->course_code }} {{ $course->course_name }}</p>
                                <p class="text-[10px] text-slate-500">{{ $course->room ?? 'Online / Lab' }}</p>
                            </div>
                        @endforeach

                        <!-- Deadline Tugas Dinamis -->
                        @foreach($dayTasks as $task)
                            <div class="bg-rose-50 border border-rose-200 p-2.5 rounded-xl text-xs space-y-1">
                                <span class="text-[10px] font-bold text-rose-600 uppercase flex items-center space-x-1">
                                    <span>🔥 Deadline</span>
                                </span>
                                <p class="font-bold text-slate-800">{{ $task->title }}</p>
                                <span class="text-[10px] text-slate-500">{{ $task->due_time ?? '23:59 WIB' }}</span>
                            </div>
                        @endforeach

                        <!-- Empty State Jika Hari Ini Kosong -->
                        @if($dayCourses->isEmpty() && $dayTasks->isEmpty())
                            <div class="flex flex-col items-center justify-center h-48 text-center text-slate-300">
                                <i class="fa-regular fa-calendar-check text-xl mb-1.5 opacity-60"></i>
                                <p class="text-xs text-slate-400">No schedule</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>