<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="inline-block bg-neu-red text-white text-xs font-black uppercase tracking-widest px-3 py-1 mb-3 border-2 border-neu-black">
            KEAMANAN AKUN
        </div>
        <h2 class="text-3xl font-black text-neu-black uppercase">Konfirmasi Password</h2>
        <p class="text-sm font-semibold text-gray-500 mt-1">
            Masukkan password Anda untuk melanjutkan ke halaman ini.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="input-neu w-full" placeholder="Masukkan password Anda">
            @error('password')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-neu-primary w-full py-3.5 text-base">
            KONFIRMASI & LANJUTKAN
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </button>
    </form>
</x-guest-layout>
