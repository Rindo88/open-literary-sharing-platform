@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-24 w-24 text-gray-400">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Halaman Tidak Ditemukan
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Maaf, halaman yang Anda cari tidak dapat ditemukan.
            </p>
        </div>
        
        <div class="mt-8 space-y-4">
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Error 404: Not Found
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>URL yang Anda masukkan tidak valid atau halaman telah dipindahkan.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('dashboard') }}" 
                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md text-center">
                    Kembali ke Dashboard
                </a>
                <a href="{{ route('books.index') }}" 
                   class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md text-center">
                    Lihat Buku
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
