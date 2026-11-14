<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.image-fallback')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', setting('platform_name', 'TechCommers')) — Marketplace</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="font-sans bg-neu-bg text-neu-black">

    <!-- Top Bar -->
    <div class="bg-neu-black text-white text-xs py-2 border-b-3 border-neu-black">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex gap-6">
                <a href="#" class="hover:text-neu-yellow font-semibold transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Download App
                </a>
                <a href="#" class="hover:text-neu-yellow font-semibold transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Mulai Jualan
                </a>
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-neu-yellow font-semibold transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notifikasi
                </a>
                <a href="#" class="hover:text-neu-yellow font-semibold transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Bantuan
                </a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-neu-yellow border-b-3 border-neu-black sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between gap-6">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-2xl font-black text-neu-black tracking-tight shrink-0 uppercase hover:opacity-80 transition-opacity">
                TECH<span class="bg-neu-black text-neu-yellow px-1 ml-0.5">COMMERS</span>
            </a>

            <!-- Search -->
            <div class="flex-1 max-w-2xl">
                <form action="{{ route('products.index') }}" method="GET" class="flex">
                    <input
                        type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari produk, merek, atau toko..."
                        class="flex-1 px-4 py-2.5 border-3 border-r-0 border-neu-black bg-white font-semibold text-neu-black placeholder-gray-400 focus:outline-none focus:border-neu-blue"
                        style="border-radius:0"
                    >
                    <button type="submit"
                        class="px-5 py-2.5 bg-neu-black text-neu-yellow font-black border-3 border-neu-black hover:bg-neu-blue hover:text-white transition-colors"
                        style="border-radius:0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Nav Actions -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 px-4 py-2.5 bg-white border-3 border-neu-black font-bold text-neu-black hover:bg-neu-blue hover:text-white transition-colors group"
                   style="box-shadow: 3px 3px 0 #0D0D0D">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="font-black" id="cart-badge">
                        {{ \App\Models\Cart::where('user_id', auth()->id())->first()?->item_count ?? 0 }}
                    </span>
                </a>

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center gap-2 px-4 py-2.5 bg-neu-black text-white border-3 border-neu-black font-bold hover:bg-neu-blue transition-colors"
                            style="box-shadow: 3px 3px 0 #FFE600">
                            <img data-image-type="avatar" src="{{ auth()->user()->avatar_url }}" alt="" class="w-6 h-6 rounded-full border-2 border-white">
                            <span class="max-w-[100px] truncate text-sm">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-cloak @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-56 bg-white border-3 border-neu-black z-50"
                             style="box-shadow: 5px 5px 0 #0D0D0D">
                            <a href="{{ route('buyer.dashboard') }}" class="flex items-center gap-2 px-4 py-3 font-bold hover:bg-neu-yellow border-b-3 border-neu-black text-sm">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Pesanan Saya
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-3 font-bold hover:bg-neu-yellow border-b-3 border-neu-black text-sm">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pengaturan Akun
                            </a>
                            @if(auth()->user()->isSeller())
                            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2 px-4 py-3 font-bold text-neu-blue hover:bg-neu-yellow border-b-3 border-neu-black text-sm">
                                <svg class="w-4 h-4 text-neu-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Toko Saya
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-3 font-bold text-neu-red hover:bg-neu-red hover:text-white text-sm transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2.5 bg-white border-3 border-neu-black font-bold text-sm hover:bg-neu-yellow transition-colors"
                       style="box-shadow: 3px 3px 0 #0D0D0D">
                        MASUK
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2.5 bg-neu-black text-neu-yellow border-3 border-neu-black font-bold text-sm hover:bg-neu-blue hover:text-white transition-colors"
                       style="box-shadow: 3px 3px 0 #FFE600">
                        DAFTAR
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-neu-black text-white border-t-3 border-neu-black mt-16">
        <div class="container mx-auto px-4 pt-12 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <div>
                    <div class="text-2xl font-black uppercase mb-4">
                        TECH<span class="bg-neu-yellow text-neu-black px-1">COMMERS</span>
                    </div>
                    <p class="text-gray-400 text-sm font-medium leading-relaxed">
                        Marketplace terpercaya untuk belanja online yang aman, cepat, dan menyenangkan.
                    </p>
                </div>
                <div>
                    <h3 class="font-black text-neu-yellow uppercase tracking-wider text-sm mb-4 border-b-3 border-neu-yellow pb-2">Layanan Pelanggan</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-neu-yellow font-semibold transition-colors">Bantuan</a></li>
                        <li><a href="#" class="hover:text-neu-yellow font-semibold transition-colors">Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-neu-yellow font-semibold transition-colors">Pengembalian Dana & Barang</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-black text-neu-yellow uppercase tracking-wider text-sm mb-4 border-b-3 border-neu-yellow pb-2">Jelajahi</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-neu-yellow font-semibold transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-neu-yellow font-semibold transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-neu-yellow font-semibold transition-colors">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-black text-neu-yellow uppercase tracking-wider text-sm mb-4 border-b-3 border-neu-yellow pb-2">Ikuti Kami</h3>
                    <div class="flex gap-3">
                        <a href="#" class="p-3 border-3 border-gray-700 text-gray-400 hover:border-neu-yellow hover:text-neu-yellow transition-colors" style="box-shadow: 2px 2px 0 #333">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="p-3 border-3 border-gray-700 text-gray-400 hover:border-neu-yellow hover:text-neu-yellow transition-colors" style="box-shadow: 2px 2px 0 #333">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center text-sm text-gray-500 font-semibold border-t-3 border-gray-800 pt-6">
                {{ setting('footer_text', '© 2025 TechCommers. All rights reserved.') }}
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'BERHASIL!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            background: '#FAFAFA',
            color: '#0D0D0D',
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'OOPS!',
            text: "{{ session('error') }}",
            background: '#FAFAFA',
            color: '#0D0D0D',
        });
    </script>
    @endif
</body>
</html>
