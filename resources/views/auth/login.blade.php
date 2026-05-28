<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="inline-block bg-neu-blue text-white text-xs font-black uppercase tracking-widest px-3 py-1 mb-3 border-2 border-neu-black">
            MASUK AKUN
        </div>
        <h2 class="text-3xl font-black text-neu-black uppercase">Welcome Back!</h2>
        <p class="text-sm font-semibold text-gray-500 mt-1">Masuk untuk melanjutkan belanja Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                Email Address
            </label>
            <input
                id="email" type="email" name="email"
                value="{{ old('email') }}" required autofocus autocomplete="username"
                class="input-neu w-full"
                placeholder="contoh@email.com"
            >
            @error('email')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">
                Password
            </label>
            <input
                id="password" type="password" name="password"
                required autocomplete="current-password"
                class="input-neu w-full"
                placeholder="••••••••"
            >
            @error('password')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 border-2 border-neu-black accent-neu-blue">
                <span class="text-sm font-bold text-neu-black">Ingat Saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-xs font-black uppercase tracking-wider text-neu-blue hover:underline">
                    Lupa Password?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-neu-primary w-full py-3.5 text-base">
            MASUK SEKARANG
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </button>

        <!-- Divider -->
        <div class="flex items-center gap-3">
            <div class="flex-1 border-t-3 border-neu-black"></div>
            <span class="text-xs font-black text-gray-400 uppercase">Atau</span>
            <div class="flex-1 border-t-3 border-neu-black"></div>
        </div>

        <!-- Register link -->
        <div class="text-center">
            <span class="text-sm font-semibold text-gray-600">Belum punya akun?</span>
            <a href="{{ route('register') }}"
               class="ml-2 text-sm font-black text-neu-black uppercase underline underline-offset-2 hover:text-neu-blue">
                Daftar Gratis
            </a>
        </div>
    </form>
</x-guest-layout>
