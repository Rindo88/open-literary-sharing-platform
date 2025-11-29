@extends('layouts.app')

@section('title', 'Dashboard - Perpustakaan Digital')

@section('content')
<style>
    .book-cover {
        aspect-ratio: 5/7;
        min-height: 112px;
        max-height: 140px;
    }
    
    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .book-cover-placeholder {
        background: linear-gradient(135deg, #e0e7ff 0%, #f3e8ff 100%);
        border: 2px dashed #c7d2fe;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .book-cover-placeholder:hover {
        background: linear-gradient(135deg, #c7d2fe 0%, #e9d5ff 100%);
        transform: scale(1.02);
    }

    /* Focus animations */
        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
        }
        
        /* Ensure animations work properly */
        .floating-animation {
            animation: float 3s ease-in-out infinite !important;
        }
        
        .book-flip {
            animation: bookFlip 2s ease-in-out infinite !important;
            transform-origin: left center;
        }
        
        .glasses-glint {
            animation: glint 4s ease-in-out infinite !important;
        }
        
        .wave-hand {
            animation: wave 0.5s ease-in-out !important;
        }
        
        .sparkle {
            animation: sparkle 2s ease-in-out infinite !important;
        }
        
        /* Librarian Character Animations */
        .librarian-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 50;
            transform: translateY(0);
            opacity: 1;
            animation: slideUp 1s ease-out 0.5s forwards;
        }
        
        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .librarian-character {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .librarian-character:hover {
            transform: scale(1.1);
        }
        
        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .book-flip {
            animation: bookFlip 2s ease-in-out infinite;
            transform-origin: left center;
        }
        
        @keyframes bookFlip {
            0%, 90%, 100% { transform: rotateY(0deg); }
            45% { transform: rotateY(15deg); }
        }
        
        .glasses-glint {
            animation: glint 4s ease-in-out infinite;
        }
        
        @keyframes glint {
            0%, 95%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }
        
        .speech-bubble {
            position: absolute;
            bottom: 100%;
            right: 0;
            background: white;
            border-radius: 20px 20px 5px 20px;
            padding: 12px 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            opacity: 0;
            transform: translateY(10px) scale(0.8);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            white-space: nowrap;
            font-size: 14px;
            color: #374151;
            margin-bottom: 10px;
            z-index: 10;
            pointer-events: none;
        }
        
        .speech-bubble::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 20px;
            width: 16px;
            height: 16px;
            background: white;
            transform: rotate(45deg);
            box-shadow: 3px 3px 5px rgba(0,0,0,0.1);
        }
        
        .speech-bubble.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        
        .wave-hand {
            animation: wave 0.5s ease-in-out;
        }
        
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(20deg); }
            75% { transform: rotate(-10deg); }
        }
        
        .sparkles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #fbbf24;
            border-radius: 50%;
            animation: sparkle 2s ease-in-out infinite;
        }
        
        @keyframes sparkle {
            0%, 100% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1); }
        }
    
    @media (max-width: 640px) {
        .book-cover {
            min-height: 96px;
            max-height: 120px;
        }
    }
</style>

<div class="max-w-7xl mx-auto py-4 sm:py-6 px-3 sm:px-4 md:px-6 lg:px-8">
    <!-- Welcome Header -->
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 text-center sm:text-left">
            Selamat Datang, {{ Auth::user()->name }}! 👋
        </h1>
        <p class="mt-2 text-sm sm:text-base text-gray-600 text-center sm:text-left">
            Jelajahi perpustakaan digital dan temukan pengetahuan baru
        </p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Buku</p>
                    <p class="text-lg sm:text-xl font-semibold text-gray-900">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Selesai Dibaca</p>
                    <p class="text-lg sm:text-xl font-semibold text-gray-900">{{ $finishedBooks }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Sedang Dibaca</p>
                    <p class="text-lg sm:text-xl font-semibold text-gray-900">{{ $currentlyReading }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Rating Rata-rata</p>
                    <p class="text-lg sm:text-xl font-semibold text-gray-900">{{ $averageRating ?: 'Belum ada rating' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Browse Books Card -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            <div class="p-4 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg sm:text-xl font-semibold text-gray-900">Jelajahi Katalog</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 mb-4">
                    Temukan ribuan buku digital dari berbagai kategori dan genre
                </p>
                <a href="{{ route('books.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                    Lihat Katalog
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- My Books Card -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            <div class="p-4 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg sm:text-xl font-semibold text-gray-900">Buku Saya</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 mb-4">
                    Kelola koleksi buku pribadi dan track progress membaca
                </p>
                <a href="{{ route('books.my-books') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                    Lihat Koleksi
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Diskusi Book -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            <div class="p-4 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg sm:text-xl font-semibold text-gray-900">Ayo Diskusi</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 mb-4">
                    Diskusikan buku-buku yang sedang Anda baca dengan teman-teman
                </p>
                <a href="{{ route('discussions.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                    Lihat Diskusi
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Admin Panel Card (if admin) -->
        @if(Auth::user()->role === 'admin')
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            <div class="p-4 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg sm:text-xl font-semibold text-gray-900">Admin Panel</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-600 mb-4">
                    Kelola perpustakaan, pengguna, dan lihat laporan
                </p>
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                    Buka Panel
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Recent Activity -->
    <div class="mt-8 sm:mt-12">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Aktivitas Terbaru</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 sm:p-6">
                <div class="space-y-4">
                    @forelse($recentActivity as $activity)
                    <div class="flex items-center">
                            <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center">
                                @if($activity['icon'] === 'check')
                                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif($activity['icon'] === 'plus')
                                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                                @endif
                        </div>
                        <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $activity['status'] }} "{{ $activity['book_title'] }}"
                                </p>
                                <p class="text-xs text-gray-500">{{ $activity['time_ago'] }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aktivitas</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai membaca buku untuk melihat aktivitas di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
                        </div>
                    </div>
                    
    <!-- Reading Progress Section -->
    @if($readingProgress->count() > 0)
    <div class="mt-8 sm:mt-12">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Progress Membaca</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($readingProgress as $progress)
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm sm:text-base font-medium text-gray-900 truncate">{{ $progress['book_title'] }}</h3>
                    <span class="text-xs sm:text-sm text-gray-500">{{ $progress['progress'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress['progress'] }}%"></div>
                </div>
                <p class="text-xs text-gray-600">
                    Halaman {{ $progress['current_page'] }} dari {{ $progress['total_pages'] }}
                </p>
                @if($progress['last_read'])
                    <p class="text-xs text-gray-500 mt-1">
                        Terakhir: {{ \Carbon\Carbon::parse($progress['last_read'])->diffForHumans() }}
                    </p>
                @endif
                
                <!-- Lanjut Membaca Button -->
                <div class="mt-3">
                    <a href="{{ route('books.read', $progress['book_slug'] ?? '') }}" 
                       class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200 w-full justify-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Lanjut Membaca
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Buku Terpopuler Section -->
    <div class="mt-8 sm:mt-12">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Buku Terpopuler</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @forelse($popularBooks as $book)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                <div class="p-4 sm:p-6">
                                         <!-- Book Cover -->
                     <div class="flex justify-center mb-4">
                         @if($book->cover_image && Storage::disk('public')->exists($book->cover_image))
                             <div class="book-cover w-20">
                                 <img src="{{ Storage::url($book->cover_image) }}" 
                                      alt="{{ $book->title }}" 
                                      class="hover:scale-105 transition-transform duration-200"
                                      onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                             </div>
                         @else
                             <div class="book-cover w-20 book-cover-placeholder">
                                 <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                         @endif
                     </div>
                    
                    <!-- Book Info -->
                    <div class="text-center mb-4">
                        <h3 class="text-sm sm:text-base font-medium text-gray-900 mb-1 line-clamp-2">
                            {{ $book->title }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 mb-2">
                            {{ $book->author->pen_name }}
                        </p>
                        
                        <!-- Rating -->
                        @if($book->average_rating > 0)
                        <div class="flex items-center justify-center mb-2">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $book->average_rating)
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.118 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.118 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-1 text-xs text-gray-600">({{ $book->ratings_count }})</span>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Stats -->
                        <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $book->readers_count }} pembaca
                            </span>
                            @if($book->pages)
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $book->pages }} hlm
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        @if(isset($book->slug) && $book->slug)
                        <a href="{{ route('books.show', $book->slug) }}" 
                           class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Detail
                        </a>
                        @else
                        <span class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-xs font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Detail
                        </span>
                        @endif
                        
                        @if(Auth::check() && isset($book->id) && $book->id)
                            @php
                                $userBook = Auth::user()->userBooks()->where('book_id', $book->id)->first();
                            @endphp
                            
                            @if(!$userBook)
                                <form action="{{ route('books.start-reading', $book) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Baca
                                    </button>
                                </form>
                            @else
                                <span class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-200 text-xs font-medium rounded-md text-gray-500 bg-gray-100">
                                    @if($userBook->status === 'reading')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Sedang Dibaca
                                    @elseif($userBook->status === 'finished')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Selesai
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Di Library
                                    @endif
                                </span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                                Login
                            </a>
                        @endif
                        </div>
                    </div>
                </div>
            @empty
            <div class="col-span-full text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada buku</h3>
                <p class="mt-1 text-sm text-gray-500">Buku akan muncul di sini setelah ada aktivitas membaca.</p>
            </div>
            @endforelse
            </div>
        </div>
</div>

<!-- Animated Librarian Character -->
    <div class="librarian-container floating-animation">
        <div class="speech-bubble" id="speechBubble">
            Selamat datang di perpustakaan digital! 📚
        </div>
        
        <div class="librarian-character relative" id="librarian" onclick="interactWithLibrarian()">
            <!-- Sparkles Effect -->
            <div class="sparkles">
                <div class="sparkle" style="top: 10%; left: 15%; animation-delay: 0s;"></div>
                <div class="sparkle" style="top: 20%; right: 10%; animation-delay: 0.5s;"></div>
                <div class="sparkle" style="bottom: 30%; left: 20%; animation-delay: 1s;"></div>
                <div class="sparkle" style="bottom: 10%; right: 25%; animation-delay: 1.5s;"></div>
            </div>
            
            <!-- Character SVG -->
            <svg width="120" height="140" viewBox="0 0 120 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Base/Platform -->
                <ellipse cx="60" cy="135" rx="25" ry="3" fill="#e5e7eb" opacity="0.3"/>
                
                <!-- Books stack (left side) -->
                <rect x="15" y="115" width="12" height="15" rx="1" fill="#ef4444" class="book-flip"/>
                <rect x="15" y="100" width="12" height="15" rx="1" fill="#3b82f6"/>
                <rect x="15" y="85" width="12" height="15" rx="1" fill="#10b981"/>
                
                <!-- Body -->
                <ellipse cx="60" cy="100" rx="18" ry="25" fill="#6366f1"/>
                
                <!-- Arms -->
                <ellipse cx="42" cy="85" rx="6" ry="15" fill="#fbbf24" transform="rotate(-15 42 85)"/>
                <ellipse cx="78" cy="85" rx="6" ry="15" fill="#fbbf24" transform="rotate(15 78 85)" id="rightArm"/>
                
                <!-- Hands -->
                <circle cx="38" cy="95" r="4" fill="#fbbf24"/>
                <circle cx="82" cy="95" r="4" fill="#fbbf24" id="rightHand"/>
                
                <!-- Book in hand -->
                <rect x="79" y="90" width="8" height="10" rx="1" fill="#8b5cf6" class="book-flip"/>
                
                <!-- Head -->
                <circle cx="60" cy="55" r="20" fill="#fbbf24"/>
                
                <!-- Hair -->
                <path d="M40 45 C40 35, 50 30, 60 30 C70 30, 80 35, 80 45 C80 40, 70 42, 60 42 C50 42, 40 40, 40 45 Z" fill="#8b5cf6"/>
                
                <!-- Hair bun -->
                <circle cx="60" cy="35" r="6" fill="#8b5cf6"/>
                <circle cx="60" cy="35" r="2" fill="#6d28d9"/>
                
                <!-- Face -->
                <!-- Eyes -->
                <circle cx="54" cy="50" r="2" fill="#1f2937"/>
                <circle cx="66" cy="50" r="2" fill="#1f2937"/>
                
                <!-- Glasses -->
                <circle cx="54" cy="50" r="6" fill="none" stroke="#1f2937" stroke-width="1.5"/>
                <circle cx="66" cy="50" r="6" fill="none" stroke="#1f2937" stroke-width="1.5"/>
                <line x1="60" y1="47" x2="60" y2="50" stroke="#1f2937" stroke-width="1.5"/>
                
                <!-- Glasses glint -->
                <circle cx="56" cy="47" r="1.5" fill="#ffffff" opacity="0.8" class="glasses-glint"/>
                
                <!-- Nose -->
                <circle cx="60" cy="55" r="1" fill="#f59e0b"/>
                
                <!-- Mouth (smiling) -->
                <path d="M56 58 Q60 62 64 58" stroke="#1f2937" stroke-width="1.5" fill="none"/>
                
                <!-- Bow tie -->
                <polygon points="60,70 55,75 65,75" fill="#dc2626"/>
                <polygon points="60,70 58,72 62,72" fill="#991b1b"/>
                
                <!-- Books floating around (animated) -->
                <rect x="95" y="70" width="8" height="6" rx="1" fill="#f59e0b" class="floating-animation" style="animation-delay: 0.5s;"/>
                <rect x="8" y="60" width="6" height="8" rx="1" fill="#ec4899" class="floating-animation" style="animation-delay: 1s;"/>
                <rect x="100" y="45" width="7" height="5" rx="1" fill="#06b6d4" class="floating-animation" style="animation-delay: 1.5s;"/>
                
                <!-- Magical sparkles around character -->
                <circle cx="85" cy="55" r="1" fill="#fbbf24" class="sparkle" style="animation-delay: 0.3s;"/>
                <circle cx="35" cy="40" r="1" fill="#fbbf24" class="sparkle" style="animation-delay: 0.8s;"/>
                <circle cx="90" cy="35" r="1" fill="#fbbf24" class="sparkle" style="animation-delay: 1.3s;"/>
            </svg>
    </div>
</div>
@endsection

@push('scripts')
<script>
        // Librarian interaction variables
        let interactionCount = 0;
        const messages = [
            "Selamat datang di perpustakaan digital! 📚",
            "Sudah siap menjelajahi dunia buku? 🌟",
            "Perpustakaan digital terbaik menanti Anda! ✨",
            "Mari baca dan belajar bersama! 🤓",
            "Pengetahuan adalah harta yang tak ternilai! 💎",
            "Selamat membaca! Semoga harimu menyenangkan! 😊"
        ];

        // Show initial speech bubble with flag to prevent repeated display
        let speechBubbleShown = false;
        if (!speechBubbleShown) {
            setTimeout(() => {
                showSpeechBubble();
                speechBubbleShown = true;
            }, 1000);
            
            // Auto hide speech bubble
            setTimeout(() => {
                hideSpeechBubble();
            }, 4000);
        }

        function showSpeechBubble() {
            const bubble = document.getElementById('speechBubble');
            if (bubble) {
                // Reset any existing animations
                bubble.style.opacity = '0';
                bubble.style.transform = 'translateY(10px) scale(0.8)';
                
                // Force reflow
                bubble.offsetHeight;
                
                // Add show class
                bubble.classList.add('show');
                console.log('Speech bubble shown');
            }
        }

        function hideSpeechBubble() {
            const bubble = document.getElementById('speechBubble');
            if (bubble) {
                bubble.classList.remove('show');
                console.log('Speech bubble hidden');
            }
        }

        function interactWithLibrarian() {
            const bubble = document.getElementById('speechBubble');
            const librarian = document.getElementById('librarian');
            const rightHand = document.getElementById('rightHand');
            
            if (!bubble || !librarian || !rightHand) {
                console.log('Elements not found');
                return;
            }
            
            // Wave animation
            rightHand.classList.add('wave-hand');
            setTimeout(() => {
                rightHand.classList.remove('wave-hand');
            }, 500);
            
            // Change message
            interactionCount = (interactionCount + 1) % messages.length;
            bubble.textContent = messages[interactionCount];
            
            // Show speech bubble
            showSpeechBubble();
            
            // Hide after 3 seconds
            setTimeout(() => {
                hideSpeechBubble();
            }, 3000);
            
            // Add bounce effect to librarian
            librarian.style.animation = 'none';
            librarian.offsetHeight; // Trigger reflow
            librarian.style.animation = 'float 3s ease-in-out infinite';
        }

        // Random interactions
        function randomInteraction() {
            if (Math.random() < 0.3) { // 30% chance
                interactWithLibrarian();
            }
        }

        // Set random interactions every 15-30 seconds
        setInterval(() => {
            randomInteraction();
        }, Math.random() * 15000 + 15000);
        
        // Initialize animations when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing animations');
            
            // Ensure librarian is visible
            const librarian = document.querySelector('.librarian-container');
            if (librarian) {
                librarian.style.display = 'block';
                librarian.style.opacity = '1';
                librarian.style.transform = 'translateY(0)';
                console.log('Librarian animation started');
            }
            
            // Start sparkle animations
            const sparkles = document.querySelectorAll('.sparkle');
            sparkles.forEach((sparkle, index) => {
                sparkle.style.animationDelay = (index * 0.2) + 's';
                console.log('Sparkle animation started for:', sparkle);
            });
            
            // Test speech bubble
            setTimeout(() => {
                const bubble = document.getElementById('speechBubble');
                if (bubble) {
                    console.log('Speech bubble element found:', bubble);
                    console.log('Speech bubble text:', bubble.textContent);
                } else {
                    console.log('Speech bubble element not found');
                }
            }, 2000);
        });
        
        // Force start animations after page load
        window.addEventListener('load', function() {
            console.log('Page fully loaded, starting animations');
        });

        // Easter egg: Double click for special animation
        document.getElementById('librarian').addEventListener('dblclick', function() {
            this.style.transform = 'rotate(360deg) scale(1.2)';
            this.style.transition = 'transform 1s ease-in-out';
            
            const bubble = document.getElementById('speechBubble');
            bubble.textContent = "🎉 Terima kasih sudah bermain! Mari mulai membaca! 🎉";
            showSpeechBubble();
            
            setTimeout(() => {
                this.style.transform = '';
                this.style.transition = 'transform 0.3s ease';
                hideSpeechBubble();
            }, 2000);
        });

        // Hide character on mobile if screen is too small
        function handleResize() {
            const librarian = document.querySelector('.librarian-container');
            if (window.innerWidth < 640 || window.innerHeight < 600) {
                librarian.style.display = 'none';
            } else {
                librarian.style.display = 'block';
                // Ensure animations are running
                librarian.style.animation = 'slideUp 1s ease-out 0.5s forwards, float 3s ease-in-out infinite';
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Check on initial load
        
        // Additional check for animation support
        if (window.matchMedia('(prefers-reduced-motion: no-preference)').matches) {
            console.log('Animations are supported and enabled');
        } else {
            console.log('Animations are disabled (user preference)');
        }
    </script>
    @endpush