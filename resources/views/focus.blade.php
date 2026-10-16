<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyFlow - Focus Timer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#0F172A] text-slate-100 antialiased flex h-screen overflow-hidden text-sm">

    <!-- Sidebar Dark -->
    <aside class="w-64 bg-[#1E293B] border-r border-slate-800 flex flex-col justify-between flex-shrink-0 z-20">
        <div class="p-5 space-y-6">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-base shadow-sm">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-lg font-bold text-white tracking-tight">StudyFlow</span>
            </div>
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 font-medium text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition">
                    <i class="fa-regular fa-rectangle-list w-4 text-center"></i>
                    <span>My tasks</span>
                </a>
                <a href="{{ route('calendar.index') }}" class="flex items-center space-x-3 px-3 py-2 font-medium text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition">
                    <i class="fa-regular fa-calendar w-4 text-center"></i>
                    <span>Calendar</span>
                </a>
                <a href="{{ route('courses.index') }}" class="flex items-center space-x-3 px-3 py-2 font-medium text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition">
                    <i class="fa-solid fa-book-open w-4 text-center"></i>
                    <span>Courses</span>
                </a>
                <a href="{{ route('focus.index') }}" class="flex items-center space-x-3 px-3 py-2 font-semibold text-indigo-400 bg-indigo-950/60 rounded-xl">
                    <i class="fa-regular fa-clock w-4 text-center"></i>
                    <span>Focus</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-800 flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-amber-500/20 text-amber-300 font-bold flex items-center justify-center text-xs">MK</div>
            <div class="leading-tight">
                <p class="font-semibold text-xs text-white">Maya Kim</p>
                <p class="text-[11px] text-slate-400">Deep Work Mode</p>
            </div>
        </div>
    </aside>

    <!-- Timer Workspace -->
    <main class="flex-1 flex flex-col items-center justify-center p-8 relative">
        <a href="{{ route('dashboard') }}" class="absolute top-8 left-8 text-xs font-semibold text-slate-400 hover:text-white flex items-center space-x-1.5 transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Exit Focus</span>
        </a>

        <!-- Timer Circle Card -->
        <div class="max-w-md w-full bg-[#1E293B] border border-slate-800 rounded-3xl p-8 flex flex-col items-center text-center shadow-2xl space-y-6">
            <div class="inline-flex items-center space-x-2 bg-indigo-950/80 border border-indigo-800/60 px-3.5 py-1.5 rounded-full text-xs text-indigo-300 font-medium">
                <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                <span id="sessionType">Pomodoro Focus Session</span>
            </div>

            <!-- Task Selector -->
            <div class="w-full">
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5 uppercase tracking-wider text-left">Link to active task</label>
                <select id="taskSelect" class="w-full bg-slate-900 border border-slate-700 text-slate-200 text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-indigo-500">
                    <option value="">-- General Study / No Task Linked --</option>
                    @if(isset($tasks))
                        @foreach($tasks as $t)
                            <option value="{{ $t->id }}">{{ $t->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Big Countdown Display -->
            <div class="py-4">
                <div id="timerDisplay" class="text-7xl font-extrabold tracking-tight text-white font-mono drop-shadow-md">
                    25:00
                </div>
            </div>

            <!-- Timer Controls -->
            <div class="flex items-center space-x-3 w-full justify-center">
                <button id="startBtn" onclick="toggleTimer()" class="w-36 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-2xl shadow-lg shadow-indigo-600/30 transition text-sm">
                    Start Focus
                </button>
                <button onclick="resetTimer()" class="px-5 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold rounded-2xl border border-slate-700 transition text-sm">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
            </div>

            <!-- Interval Modes -->
            <div class="flex items-center space-x-2 pt-2 text-xs">
                <button onclick="setMode(25, 'Pomodoro Focus Session')" class="px-3 py-1 rounded-lg bg-indigo-600/20 text-indigo-300 font-medium">25m Work</button>
                <button onclick="setMode(5, 'Short Coffee Break')" class="px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 font-medium">5m Break</button>
                <button onclick="setMode(15, 'Long Recovery Break')" class="px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 font-medium">15m Break</button>
            </div>
        </div>
    </main>

    <script>
        let totalSeconds = 25 * 60;
        let isRunning = false;
        let timerInterval = null;

        function updateDisplay() {
            let minutes = Math.floor(totalSeconds / 60);
            let seconds = totalSeconds % 60;
            document.getElementById('timerDisplay').innerText = 
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function toggleTimer() {
            const btn = document.getElementById('startBtn');
            if (!isRunning) {
                isRunning = true;
                btn.innerText = "Pause";
                btn.classList.replace('bg-indigo-600', 'bg-amber-600');
                btn.classList.replace('hover:bg-indigo-500', 'hover:bg-amber-500');

                timerInterval = setInterval(() => {
                    if (totalSeconds > 0) {
                        totalSeconds--;
                        updateDisplay();
                    } else {
                        clearInterval(timerInterval);
                        alert("🎉 Sesi fokus selesai! Istirahat sebentar yuk.");
                        resetTimer();
                    }
                }, 1000);
            } else {
                isRunning = false;
                btn.innerText = "Resume";
                btn.classList.replace('bg-amber-600', 'bg-indigo-600');
                btn.classList.replace('hover:bg-amber-500', 'hover:bg-indigo-500');
                clearInterval(timerInterval);
            }
        }

        function resetTimer() {
            clearInterval(timerInterval);
            isRunning = false;
            totalSeconds = 25 * 60;
            updateDisplay();
            const btn = document.getElementById('startBtn');
            btn.innerText = "Start Focus";
            btn.className = "w-36 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-2xl shadow-lg shadow-indigo-600/30 transition text-sm";
        }

        function setMode(mins, label) {
            clearInterval(timerInterval);
            isRunning = false;
            totalSeconds = mins * 60;
            document.getElementById('sessionType').innerText = label;
            updateDisplay();
            const btn = document.getElementById('startBtn');
            btn.innerText = "Start Focus";
            btn.className = "w-36 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-2xl shadow-lg shadow-indigo-600/30 transition text-sm";
        }
    </script>
</body>
</html>