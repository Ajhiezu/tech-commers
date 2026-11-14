<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.image-fallback')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Seller Center — {{ setting('platform_name', 'TechCommers') }}</title>

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

    <!-- Header -->
    <header class="bg-neu-blue border-b-3 border-neu-black sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3">
                <span class="bg-neu-yellow text-neu-black font-black text-sm px-2 py-1 border-2 border-neu-black uppercase tracking-wider"
                      style="box-shadow: 2px 2px 0 #0D0D0D">
                    SELLER
                </span>
                <span class="text-white font-black text-xl uppercase tracking-tight">CENTER</span>
            </a>

            <!-- Right Nav -->
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}"
                   class="text-white font-bold text-sm border-3 border-white px-4 py-2 hover:bg-white hover:text-neu-blue transition-colors"
                   style="box-shadow: 2px 2px 0 rgba(0,0,0,0.3)">
                    ← Marketplace
                </a>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-4 py-2 bg-white border-3 border-neu-black font-bold text-neu-black hover:bg-neu-yellow transition-colors"
                        style="box-shadow: 3px 3px 0 #0D0D0D">
                        <img data-image-type="store" src="{{ auth()->user()->store->logo_url ?? auth()->user()->avatar_url }}"
                             alt="Avatar" class="w-6 h-6 rounded-full border-2 border-neu-black">
                        <span class="text-sm max-w-[120px] truncate">{{ auth()->user()->store->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-cloak @click.away="open = false"
                         class="absolute right-0 mt-2 w-52 bg-white border-3 border-neu-black z-50"
                         style="box-shadow: 5px 5px 0 #0D0D0D">
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2 px-4 py-3 font-bold hover:bg-neu-yellow border-b-3 border-neu-black text-sm">
                            ⚙️ Pengaturan Toko
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 w-full px-4 py-3 font-bold text-neu-red hover:bg-neu-red hover:text-white text-sm transition-colors">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Body -->
    <div class="flex min-h-[calc(100vh-65px)]">

        <!-- Sidebar -->
        <aside class="w-64 shrink-0 bg-neu-black border-r-3 border-neu-black">
            <nav class="p-4 space-y-1 sticky top-[65px]">
                <!-- Dashboard -->
                <a href="{{ route('seller.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <div class="section-label mt-4 !text-gray-500">Pesanan</div>

                <a href="{{ route('seller.orders.index') }}"
                   class="sidebar-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Pesanan Masuk
                </a>

                <div class="section-label mt-4 !text-gray-500">Produk</div>

                <a href="{{ route('seller.products.index') }}"
                   class="sidebar-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Daftar Produk
                </a>

                <div class="section-label mt-4 !text-gray-500">Keuangan</div>

                <a href="{{ route('seller.wallet.index') }}"
                   class="sidebar-link {{ request()->routeIs('seller.wallet.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Saldo Penjual
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

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
