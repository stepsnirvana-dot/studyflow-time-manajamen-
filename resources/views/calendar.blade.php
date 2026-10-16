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
        <div class="p-4 border-t border-slate-100 flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-xs">MK</div>
            <div class="leading-tight">
                <p class="font-semibold text-xs text-slate-900">Maya Kim</p>
                <p class="text-[11px] text-slate-400">Weekly Timetable</p>
            </div>
        </div>
    </aside>

    <!-- Calendar View -->
    <main class="flex-1 flex flex-col min-w-0 bg-white overflow-y-auto">
        <header class="h-16 border-b border-slate-200 px-8 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-slate-900">Academic Schedule & Deadlines</h1>
                <p class="text-xs text-slate-400">October 2026 · Class schedules mapped with task due dates</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs px-3.5 py-2 rounded-xl flex items-center space-x-1.5 shadow-sm transition">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Back to Tasks</span>
            </a>
        </header>

        <div class="p-8 space-y-6">
            <!-- Weekly Columns -->
            <div class="grid grid-cols-5 gap-4">
                @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                @endphp
                @foreach($days as $day)
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 min-h-[550px] space-y-3">
                    <div class="border-b border-slate-200/80 pb-2">
                        <span class="font-bold text-xs text-slate-700 block">{{ $day }}</span>
                        <span class="text-[10px] text-slate-400">Lecture & Deadlines</span>
                    </div>

                    <!-- Filtered schedule items -->
                    @if($day == 'Monday')
                        <div class="bg-purple-50 border-l-4 border-purple-500 p-2.5 rounded-lg text-xs space-y-1">
                            <span class="font-bold text-purple-900">10:00 - 11:30</span>
                            <p class="font-semibold text-slate-800">HCI 302 Lecture</p>
                            <p class="text-[10px] text-slate-500">Design Lab 204</p>
                        </div>
                        <div class="bg-sky-50 border-l-4 border-sky-500 p-2.5 rounded-lg text-xs space-y-1">
                            <span class="font-bold text-sky-900">13:00 - 14:30</span>
                            <p class="font-semibold text-slate-800">MATH 221 Lecture</p>
                            <p class="text-[10px] text-slate-500">Science Hall 305</p>
                        </div>
                    @elseif($day == 'Tuesday')
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-2.5 rounded-lg text-xs space-y-1">
                            <span class="font-bold text-blue-900">09:00 - 10:30</span>
                            <p class="font-semibold text-slate-800">CS 241 Lecture</p>
                            <p class="text-[10px] text-slate-500">Engineering 112</p>
                        </div>
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-2.5 rounded-lg text-xs space-y-1">
                            <span class="font-bold text-emerald-900">14:00 - 15:30</span>
                            <p class="font-semibold text-slate-800">BIOL 214 Lab</p>
                            <p class="text-[10px] text-slate-500">Biology Lab 108</p>
                        </div>
                    @elseif($day == 'Wednesday')
                        <div class="bg-purple-50 border-l-4 border-purple-500 p-2.5 rounded-lg text-xs space-y-1">
                            <span class="font-bold text-purple-900">10:00 - 11:30</span>
                            <p class="font-semibold text-slate-800">HCI 302 Workshop</p>
                            <p class="text-[10px] text-slate-500">Design Lab 204</p>
                        </div>
                        <div class="bg-rose-50 border border-rose-200 p-2.5 rounded-lg text-xs space-y-1 mt-4">
                            <span class="text-[10px] font-bold text-rose-600 uppercase">🔥 Deadline Today</span>
                            <p class="font-bold text-slate-800">Submit HCI Research Plan</p>
                            <span class="text-[10px] text-slate-400">17:00 WIB</span>
                        </div>
                    @elseif($day == 'Thursday')
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-2.5 rounded-lg text-xs space-y-1">
                            <span class="font-bold text-blue-900">09:00 - 10:30</span>
                            <p class="font-semibold text-slate-800">CS 241 Discussion</p>
                            <p class="text-[10px] text-slate-500">Engineering 112</p>
                        </div>
                    @elseif($day == 'Friday')
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-2.5 rounded-lg text-xs space-y-1">
                            <span class="font-bold text-emerald-900">14:00 - 15:30</span>
                            <p class="font-semibold text-slate-800">BIOL 214 Seminar</p>
                            <p class="text-[10px] text-slate-500">Biology Lab 108</p>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>