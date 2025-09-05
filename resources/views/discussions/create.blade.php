@extends('layouts.app')

@section('title', 'Buat Diskusi Baru - ' . $book->title)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('discussions.show', $book) }}" class="text-blue-700 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Buat Diskusi Baru</h1>
            </div>
        </div>

        <!-- Book Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-start space-x-4">
                @if($book->cover_image)
                    <img src="{{ Storage::url($book->cover_image) }}" 
                         alt="{{ $book->title }}"
                         class="w-20 h-28 object-cover rounded-lg shadow-sm">
                @else
                    <div class="w-20 h-28 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                @endif
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $book->title }}</h2>
                    <p class="text-lg text-gray-600 mb-2">{{ $book->author }}</p>
                    <p class="text-gray-500 text-sm mb-3">{{ $book->description ? Str::limit($book->description, 150) : 'Deskripsi tidak tersedia' }}</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $book->discussions->count() }} diskusi
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            {{ $book->discussions->sum('participants_count') }} total peserta
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discussion Creation Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Buat Diskusi Baru</h3>
            
            <form action="{{ route('discussions.store', $book) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Diskusi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('title') border-red-500 @enderror"
                               placeholder="Contoh: Analisis Karakter Utama dalam Novel Ini"
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            Buat judul yang menarik dan spesifik untuk memulai diskusi yang produktif.
                        </p>
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Diskusi
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan topik yang ingin didiskusikan, pertanyaan yang ingin diajukan, atau aspek buku yang ingin dianalisis bersama...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            Deskripsi yang jelas akan membantu peserta lain memahami fokus diskusi.
                        </p>
                    </div>

                    <!-- Settings Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        

                        <!-- Max Participants -->
                        <div>
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">
                                Maksimal Peserta
                            </label>
                            <input type="number" 
                                   id="max_participants" 
                                   name="max_participants" 
                                   value="{{ old('max_participants') }}"
                                   min="2" 
                                   max="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500">
                                Kosongkan untuk tidak ada batasan.
                            </p>
                        </div>

                        <!-- Privacy Setting -->
                        <div>
                            <!-- <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_private" 
                                       value="1" 
                                       {{ old('is_private') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Diskusi Privat</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">
                                Diskusi privat hanya bisa diakses oleh peserta yang diundang.
                            </p> -->
                        </div>
                    </div>

                    <!-- Discussion Guidelines -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-blue-900 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Panduan Membuat Diskusi yang Baik
                        </h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Pilih topik yang spesifik dan menarik untuk didiskusikan</li>
                            <li>• Ajukan pertanyaan yang memicu pemikiran dan analisis</li>
                            <li>• Berikan konteks yang jelas tentang bagian buku yang dibahas</li>
                            <li>• Bersikap terbuka terhadap berbagai sudut pandang</li>
                            <li>• Hormati pendapat peserta lain dalam diskusi</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <a href="{{ route('discussions.show', $book) }}" 
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-200">
                                Batal
                            </a>
                            <a href="{{ route('books.read', $book->slug) }}" 
                               class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Baca Buku</span>
                            </a>
                        </div>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Buat Diskusi</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
