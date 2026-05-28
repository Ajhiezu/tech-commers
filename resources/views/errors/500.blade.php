@extends('layouts.marketplace')

@section('title', 'Terjadi Kesalahan')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
    <div class="text-9xl mb-6">🛠️</div>
    <h1 class="text-4xl font-bold text-gray-900 mb-4">500 - Kesalahan Sistem</h1>
    <p class="text-gray-500 mb-8 max-w-md">Maaf, terjadi kesalahan pada server kami. Tim teknis kami sedang berusaha memperbaikinya.</p>
    <a href="{{ route('home') }}" class="bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-orange-600 transition shadow-lg shadow-orange-200">
        Kembali ke Beranda
    </a>
</div>
@endsection
