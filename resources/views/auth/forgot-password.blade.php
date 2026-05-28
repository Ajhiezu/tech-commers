<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="inline-block bg-neu-yellow text-neu-black text-xs font-black uppercase tracking-widest px-3 py-1 mb-3 border-2 border-neu-black">
            RESET PASSWORD
        </div>
        <h2 class="text-3xl font-black text-neu-black uppercase">Lupa Password?</h2>
        <p class="text-sm font-semibold text-gray-500 mt-1">
            Masukkan email Anda dan kami akan kirimkan link reset password.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert-success mb-6">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm">{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="input-neu w-full" placeholder="contoh@email.com">
            @error('email')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-neu w-full py-3.5 text-base">
            KIRIM LINK RESET
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </button>

        <div class="text-center mt-2">
            <a href="{{ route('login') }}" class="text-sm font-black text-neu-black uppercase underline underline-offset-2 hover:text-neu-blue">
                ← Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>
