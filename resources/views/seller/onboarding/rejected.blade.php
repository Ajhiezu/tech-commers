@extends('layouts.seller')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-white p-10 rounded-2xl shadow-sm border border-red-100 text-center relative overflow-hidden">
        
        <div class="relative z-10 flex flex-col items-center">
            <div class="h-24 w-24 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-6">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Registration Rejected</h2>
            <p class="text-gray-500 mb-6 max-w-md">
                Unfortunately, your application to become a seller has been declined.
            </p>

            @if(request()->user()->store->rejected_reason)
            <div class="bg-red-50 text-red-700 rounded-xl p-4 w-full text-left max-w-md mb-8 border border-red-200">
                <h3 class="text-sm font-bold uppercase tracking-wider mb-2">Reason provided:</h3>
                <p class="text-sm">{{ request()->user()->store->rejected_reason }}</p>
            </div>
            @endif

            <a href="{{ route('dashboard') }}" class="inline-flex justify-center py-2.5 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
                Return to Homepage
            </a>
        </div>
    </div>
</div>
@endsection
