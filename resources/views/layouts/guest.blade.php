<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.image-fallback')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechCommers') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-neu-bg text-neu-black">
    <div class="min-h-screen flex">

        <!-- Left Side — Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-neu-yellow flex-col justify-between p-12 border-r-3 border-neu-black relative overflow-hidden">
            <!-- Decorative grid pattern -->
            <div class="absolute inset-0 opacity-10"
                 style="background-image: repeating-linear-gradient(0deg, #0D0D0D 0px, #0D0D0D 1px, transparent 1px, transparent 40px), repeating-linear-gradient(90deg, #0D0D0D 0px, #0D0D0D 1px, transparent 1px, transparent 40px);">
            </div>

            <!-- Big decorative shapes -->
            <div class="absolute -bottom-16 -right-16 w-72 h-72 bg-neu-black opacity-10 rotate-12"></div>
            <div class="absolute top-24 -left-8 w-40 h-40 bg-primary opacity-20 -rotate-6 border-3 border-neu-black"></div>

            <!-- Top logo -->
            <div class="z-10">
                <a href="/" class="inline-block">
                    <div class="text-3xl font-black text-neu-black uppercase tracking-tight">
                        TECH<span class="bg-neu-black text-neu-yellow px-2">COMMERS</span>
                    </div>
                </a>
            </div>

            <!-- Center copy -->
            <div class="z-10">
                <div class="inline-block bg-neu-black text-neu-yellow text-xs font-black uppercase tracking-[0.2em] px-3 py-1 mb-6 border-2 border-neu-black">
                    MARKETPLACE #1 INDONESIA
                </div>
                <h1 class="text-5xl font-black text-neu-black leading-tight mb-6 uppercase">
                    Jual & Beli<br>Tanpa<br>Ribet.
                </h1>
                <p class="text-lg font-bold text-neu-black/70 max-w-sm leading-relaxed">
                    Bergabunglah dengan jutaan pembeli dan penjual di platform marketplace paling terpercaya.
                </p>

                <!-- Stats row -->
                <div class="flex gap-6 mt-10">
                    <div class="border-3 border-neu-black bg-white px-4 py-3" style="box-shadow: 4px 4px 0 #0D0D0D">
                        <div class="text-2xl font-black text-neu-black">2M+</div>
                        <div class="text-xs font-bold text-gray-600 uppercase">Produk</div>
                    </div>
                    <div class="border-3 border-neu-black bg-neu-blue text-white px-4 py-3" style="box-shadow: 4px 4px 0 #0D0D0D">
                        <div class="text-2xl font-black">500K+</div>
                        <div class="text-xs font-bold opacity-80 uppercase">Penjual</div>
                    </div>
                    <div class="border-3 border-neu-black bg-primary text-white px-4 py-3" style="box-shadow: 4px 4px 0 #0D0D0D">
                        <div class="text-2xl font-black">99%</div>
                        <div class="text-xs font-bold opacity-80 uppercase">Puas</div>
                    </div>
                </div>
            </div>

            <!-- Bottom text -->
            <div class="z-10 text-xs font-bold text-neu-black/50 uppercase tracking-widest">
                © 2025 TechCommers · All Rights Reserved
            </div>
        </div>

        <!-- Right Side — Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-neu-bg">

            <!-- Mobile Logo -->
            <div class="lg:hidden mb-10 text-center">
                <a href="/" class="text-3xl font-black text-neu-black uppercase tracking-tight">
                    TECH<span class="bg-neu-black text-neu-yellow px-1">COMMERS</span>
                </a>
            </div>

            <!-- Form Card -->
            <div class="w-full sm:max-w-md">
                <div class="bg-white border-3 border-neu-black p-8" style="box-shadow: 6px 6px 0 #0D0D0D">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
