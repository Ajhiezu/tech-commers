<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="inline-block bg-neu-green text-neu-black text-xs font-black uppercase tracking-widest px-3 py-1 mb-3 border-2 border-neu-black">
            BUAT AKUN
        </div>
        <h2 class="text-3xl font-black text-neu-black uppercase">Daftar Gratis!</h2>
        <p class="text-sm font-semibold text-gray-500 mt-1">Bergabunglah dan mulai belanja atau berjualan.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="input-neu w-full" placeholder="John Doe">
            @error('name')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="input-neu w-full" placeholder="contoh@email.com">
            @error('email')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="input-neu w-full" placeholder="Min. 8 karakter">
            @error('password')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="input-neu w-full" placeholder="Ulangi password">
            @error('password_confirmation')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-neu-success w-full py-3.5 text-base">
            BUAT AKUN SEKARANG
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

        <!-- Login link -->
        <div class="text-center">
            <span class="text-sm font-semibold text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="ml-2 text-sm font-black text-neu-black uppercase underline underline-offset-2 hover:text-neu-blue">
                Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
