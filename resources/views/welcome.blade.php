<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyFlow — The Focused Academic Workspace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .ambient-glow {
            background: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.18) 0%, rgba(168, 85, 247, 0.08) 35%, transparent 70%);
        }
        .grid-bg {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(148, 163, 184, 0.08) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-[#0B0F19] text-slate-100 antialiased selection:bg-indigo-500 selection:text-white relative overflow-x-hidden min-h-screen">

    <!-- Ambient Lighting Effect & Grid -->
    <div class="absolute inset-0 ambient-glow pointer-events-none -z-10"></div>
    <div class="absolute inset-0 grid-bg [mask-image:radial-gradient(ellipse_70%_50%_at_50%_0%,#000_60%,transparent_100%)] pointer-events-none -z-10"></div>

    <!-- Floating Navbar -->
    <header class="sticky top-4 z-40 px-4 max-w-5xl mx-auto">
        <div class="bg-slate-900/70 border border-slate-800/80 backdrop-blur-xl rounded-2xl px-5 h-14 flex items-center justify-between shadow-2xl shadow-black/40">
            <a href="/" class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-md shadow-indigo-500/30">
                    <i class="fa-solid fa-graduation-cap text-xs"></i>
                </div>
                <span class="font-extrabold tracking-tight text-white text-sm">Study<span class="text-indigo-400">Flow</span></span>
            </a>

            <div class="flex items-center space-x-2.5">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center space-x-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold px-3.5 py-1.5 rounded-xl transition shadow-lg shadow-indigo-600/30">
                        <span>Workspace</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-medium text-slate-300 hover:text-white px-3 py-1.5 transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="text-xs font-semibold bg-white hover:bg-slate-100 text-slate-950 px-3.5 py-1.5 rounded-xl transition shadow-sm">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Content -->
    <main class="max-w-5xl mx-auto px-6 pt-16 pb-12 text-center">
        <!-- Floating Pill Tag -->
        <div class="inline-flex items-center space-x-2 bg-indigo-500/10 border border-indigo-500/20 px-3 py-1 rounded-full text-xs text-indigo-300 font-medium mb-8 backdrop-blur-xs">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-ping"></span>
            <span>Minimalist Work and study </span>
        </div>

        <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-white leading-[1.08] max-w-4xl mx-auto">
            Manajemen waktu untuk lebih produktif, <br class="hidden sm:block">
            <span class="bg-gradient-to-r from-indigo-300 via-violet-300 to-indigo-400 bg-clip-text text-transparent">Combine your work and study.</span>
        </h1>

        <p class="mt-6 text-sm sm:text-base text-slate-400 max-w-xl mx-auto leading-relaxed">
            Papan kerja akademik serba dinamis. Kelola mata kuliah, jadwalkan tugas ke kalender, dan pantau progres belajarmu tanpa distraksi.
        </p>

        <!-- CTA Action Buttons -->
        <div class="mt-8 flex items-center justify-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs px-6 py-3 rounded-xl shadow-xl shadow-indigo-600/30 transition flex items-center space-x-2">
                    <span>Masuk ke Dashboard Saya</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold text-xs px-6 py-3 rounded-xl shadow-xl shadow-indigo-600/25 transition flex items-center space-x-2">
                    <span>Mulai Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
                <a href="{{ route('login') }}" class="bg-slate-900/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 text-xs font-semibold px-5 py-3 rounded-xl transition">
                    Sudah Punya Akun
                </a>
            @endauth
        </div>
    </main>

    <!-- Interactive Glowing Product Window -->
    <section class="max-w-5xl mx-auto px-6 pb-24">
        <div class="relative group">
            <!-- Neon Border Gradient Outer -->
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/30 via-purple-500/20 to-indigo-500/30 rounded-3xl blur-md opacity-70 group-hover:opacity-100 transition duration-700"></div>

            <div class="relative bg-slate-950/90 border border-slate-800/90 rounded-2xl shadow-2xl overflow-hidden backdrop-blur-2xl">
                

                

        <!-- 3 Feature Highlights (Minimal Bento Style) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
            <div class="bg-slate-900/40 border border-slate-800/80 p-5 rounded-2xl hover:border-slate-700 transition">
                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-xs font-bold mb-3 border border-indigo-500/20">01</div>
                <h4 class="text-xs font-bold text-slate-200">Atur Waktumu dengan bijak</h4>
                <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Website ini membantu kamu mengelola waktu kuliah dengan lebih efektif.</p>
            </div>

            <div class="bg-slate-900/40 border border-slate-800/80 p-5 rounded-2xl hover:border-slate-700 transition">
                <div class="w-8 h-8 rounded-lg bg-violet-500/10 text-violet-400 flex items-center justify-center text-xs font-bold mb-3 border border-violet-500/20">02</div>
                <h4 class="text-xs font-bold text-slate-200">Dynamic Academic Calendar</h4>
                <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Tambah mata kuliah mandiri, atur ruangan & dosen, dan sinkronkan jadwal kuliah mingguan otomatis.</p>
            </div>

            <div class="bg-slate-900/40 border border-slate-800/80 p-5 rounded-2xl hover:border-slate-700 transition">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xs font-bold mb-3 border border-emerald-500/20">03</div>
                <h4 class="text-xs font-bold text-slate-200">Real-Time Kanban Tracking</h4>
                <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Pantau status To Do, In Progress, hingga selesai. dengan integrasi AI dan automated reminders.</p>
            </div>
        </div>
    </section>

    <!-- Subtle Minimal Footer -->
    <footer class="border-t border-slate-900 py-6 text-center text-slate-500 text-xs">
        <p>StudyFlow &copy; {{ date('Y') }} — Management Academic</p>
    </footer>

</body>
</html>