<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StudyFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .ambient-glow {
                background: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.22) 0%, rgba(168, 85, 247, 0.1) 35%, transparent 70%);
            }
            .grid-bg {
                background-size: 36px 36px;
                background-image: 
                    linear-gradient(to right, rgba(148, 163, 184, 0.07) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(148, 163, 184, 0.07) 1px, transparent 1px);
            }
        </style>
    </head>
    <body class="bg-[#0B0F19] text-slate-100 antialiased selection:bg-indigo-500 selection:text-white relative min-h-screen flex flex-col justify-center items-center px-4 py-8 overflow-x-hidden">
        
        <!-- Ambient Glow & Pattern -->
        <div class="fixed inset-0 ambient-glow pointer-events-none -z-10"></div>
        <div class="fixed inset-0 grid-bg [mask-image:radial-gradient(ellipse_70%_50%_at_50%_0%,#000_60%,transparent_100%)] pointer-events-none -z-10"></div>

        <!-- Logo -->
        <div class="mb-6">
            <a href="/" class="flex items-center space-x-2.5 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition">
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                </div>
                <span class="font-extrabold tracking-tight text-white text-xl">Study<span class="text-indigo-400">Flow</span></span>
            </a>
        </div>

        <!-- Auth Card Container -->
        <div class="w-full sm:max-w-md bg-slate-900/80 border border-slate-800/90 backdrop-blur-xl px-8 py-7 rounded-2xl shadow-2xl shadow-black/60 relative">
            {{ $slot }}
        </div>

        <!-- Footer Back Link -->
        <div class="mt-6 text-center">
            <a href="/" class="text-xs text-slate-400 hover:text-slate-200 transition inline-flex items-center space-x-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Halaman Utama</span>
            </a>
        </div>
    </body>
</html>