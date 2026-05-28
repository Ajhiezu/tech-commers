<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="inline-block bg-neu-yellow text-neu-black text-xs font-black uppercase tracking-widest px-3 py-1 mb-3 border-2 border-neu-black">
            VERIFIKASI EMAIL
        </div>
        <h2 class="text-3xl font-black text-neu-black uppercase">Cek Email Kamu!</h2>
        <p class="text-sm font-semibold text-gray-500 mt-2 leading-relaxed">
            Kami telah mengirimkan link verifikasi ke email Anda. Klik link tersebut untuk mengaktifkan akun.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert-success mb-6">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-bold">Link verifikasi baru telah dikirim!</span>
        </div>
    @endif

    <div class="flex flex-col gap-3 mt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-neu w-full py-3.5 text-base">
                KIRIM ULANG EMAIL VERIFIKASI
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-neu-outline w-full py-3">
                Logout
            </button>
        </form>
    </div>
</x-guest-layout>
