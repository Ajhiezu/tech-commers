@extends('layouts.seller')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 text-center relative overflow-hidden">
        <!-- Decorative background circle -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-yellow-50 rounded-full opacity-50"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>

        <div class="relative z-10 flex flex-col items-center">
            <div class="h-24 w-24 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-6">
                <svg class="h-12 w-12 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Registration Under Review</h2>
            <p class="text-gray-500 mb-8 max-w-md">
                Thank you for applying to become a seller! Our team is currently reviewing your documents. This process usually takes 1-2 business days.
            </p>

            <div class="bg-gray-50 rounded-xl p-6 w-full text-left max-w-md mb-8 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Application Status</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <p class="text-sm text-gray-600">Documents Submitted</p>
                    </div>
                    <div class="w-0.5 h-6 bg-gray-200 ml-4 -my-2"></div>
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mr-3 relative">
                            <span class="absolute inset-0 rounded-full border-2 border-yellow-400 animate-ping opacity-25"></span>
                            <span class="w-2.5 h-2.5 bg-yellow-500 rounded-full"></span>
                        </div>
                        <p class="text-sm font-medium text-gray-900">Admin Verification</p>
                    </div>
                    <div class="w-0.5 h-6 bg-gray-200 ml-4 -my-2"></div>
                    <div class="flex items-center opacity-50">
                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mr-3">
                            <span class="w-2.5 h-2.5 bg-gray-400 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600">Store Active</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('dashboard') }}" class="inline-flex justify-center py-2.5 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Return to Homepage
            </a>
        </div>
    </div>
</div>
@endsection
