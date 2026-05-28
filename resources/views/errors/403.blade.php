@extends('layouts.marketplace')

@section('title', 'Akses Ditolak')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
    <div class="text-9xl mb-6">⛔</div>
    <h1 class="text-4xl font-bold text-gray-900 mb-4">403 - Akses Ditolak</h1>
    <p class="text-gray-500 mb-8 max-w-md">Maaf, Anda tidak memiliki izin untuk mengakses halaman atau aksi ini.</p>
    <div class="flex gap-4">
        <a href="{{ url()->previous() }}" class="bg-white border border-gray-300 text-gray-700 font-bold py-3 px-8 rounded-lg hover:bg-gray-50 transition">
            Kembali
        </a>
        <a href="{{ route('home') }}" class="bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-orange-600 transition shadow-lg shadow-orange-200">
            Ke Beranda
        </a>
    </div>
</div>
@endsection
