<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-white tracking-tight">Mulai dengan StudyFlow</h2>
        <p class="text-xs text-slate-400 mt-1">Buat workspace mandiri untuk mengelola kuliah dan tugas harianmu.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-300 mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="misal: Boni Ardiansyah"
                class="w-full bg-slate-950/60 border border-slate-800 text-white placeholder-slate-500 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                placeholder="nama@email.com"
                class="w-full bg-slate-950/60 border border-slate-800 text-white placeholder-slate-500 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-300 mb-1.5">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                class="w-full bg-slate-950/60 border border-slate-800 text-white placeholder-slate-500 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 mb-1.5">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi kata sandi"
                class="w-full bg-slate-950/60 border border-slate-800 text-white placeholder-slate-500 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <button type="submit" 
                class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold text-xs py-2.5 px-4 rounded-xl transition shadow-lg shadow-indigo-600/30 flex items-center justify-center space-x-2">
                <span>Daftar Sekarang</span>
                <i class="fa-solid fa-arrow-right text-[11px]"></i>
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-3 border-t border-slate-800/80">
            <p class="text-xs text-slate-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold ms-1 transition">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>