<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-white tracking-tight">Selamat Datang Kembali</h2>
        <p class="text-xs text-slate-400 mt-1">Masuk ke akun StudyFlow untuk melanjutkan progres belajarmu.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="nama@email.com"
                class="w-full bg-slate-950/60 border border-slate-800 text-white placeholder-slate-500 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-300">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-[11px] text-indigo-400 hover:text-indigo-300 transition" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••"
                class="w-full bg-slate-950/60 border border-slate-800 text-white placeholder-slate-500 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="rounded bg-slate-950/80 border-slate-800 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-slate-900 w-3.5 h-3.5">
                <span class="ms-2 text-xs text-slate-400">Ingat saya di perangkat ini</span>
            </label>
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <button type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs py-2.5 px-4 rounded-xl transition shadow-lg shadow-indigo-600/30 flex items-center justify-center space-x-2">
                <span>Masuk Sekarang</span>
                <i class="fa-solid fa-arrow-right text-[11px]"></i>
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-3 border-t border-slate-800/80">
            <p class="text-xs text-slate-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold ms-1 transition">
                    Daftar akun baru
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>