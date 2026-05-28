<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="inline-block bg-neu-blue text-white text-xs font-black uppercase tracking-widest px-3 py-1 mb-3 border-2 border-neu-black">
            PASSWORD BARU
        </div>
        <h2 class="text-3xl font-black text-neu-black uppercase">Reset Password</h2>
        <p class="text-sm font-semibold text-gray-500 mt-1">Buat password baru yang kuat untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autocomplete="username"
                   class="input-neu w-full">
            @error('email')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Password Baru</label>
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
                   class="input-neu w-full" placeholder="Ulangi password baru">
            @error('password_confirmation')
                <p class="mt-2 text-xs font-bold text-neu-red">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-neu-primary w-full py-3.5 text-base">
            SIMPAN PASSWORD BARU
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </button>
    </form>
</x-guest-layout>
