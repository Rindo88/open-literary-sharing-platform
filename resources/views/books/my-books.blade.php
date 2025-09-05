
    @extends('layouts.app')

    @section('title', 'My Books - Perpustakaan Digital')

    @section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages - Modern Popup Notification -->
            @if(session('success') || session('error'))
                <div id="notification-popup" class="fixed top-6 right-6 z-[9999] max-w-sm w-full sm:max-w-md transform transition-all duration-500 ease-in-out translate-x-full opacity-0">
                    @if(session('success'))
                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl shadow-2xl border border-green-400 overflow-hidden">
                            <div class="p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <h3 class="text-sm font-semibold text-white">Berhasil!</h3>
                                        <p class="text-sm text-green-100 mt-1">{{ session('success') }}</p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <button onclick="closeNotification()" class="inline-flex text-green-200 hover:text-white focus:outline-none focus:text-white transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-green-400 h-1 w-full"></div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl shadow-2xl border border-red-400 overflow-hidden">
                            <div class="p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-red-400 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <h3 class="text-sm font-semibold text-white">Error!</h3>
                                        <p class="text-sm text-red-100 mt-1">{{ session('error') }}</p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <button onclick="closeNotification()" class="inline-flex text-red-200 hover:text-white focus:outline-none focus:text-white transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-red-400 h-1 w-full"></div>
                        </div>
                    @endif
                </div>
            @endif
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Books</h1>
                <p class="mt-2 text-gray-600">Kelola buku-buku Anda</p>
            </div>

            <!-- Reading Books -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                    Sedang Dibaca
                    <span class="ml-2 bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded-full">{{ $readingBooks->count() }}</span>
                </h2>
                
                @if($readingBooks->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($readingBooks as $userBook)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $userBook->book->title }}</h3>
                                    <p class="text-gray-600 mb-2">oleh {{ $userBook->book->author }}</p>
                                    <p class="text-sm text-gray-500 mb-2">Dimulai: {{ $userBook->started_at ? $userBook->started_at->format('d M Y') : 'N/A' }}</p>
                                    <p class="text-sm text-blue-600 mb-4">📚 Status: Sedang dibaca</p>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('books.show', $userBook->book->slug) }}" 
                                           class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md text-center text-sm hover:bg-blue-700 transition-colors font-medium inline-flex items-center justify-center min-h-[40px]">
                                            Lanjutkan Baca
                                        </a>
                                        <form action="{{ route('books.finish-reading', $userBook->book->slug) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 transition-colors font-medium min-h-[40px]">
                                                Selesai
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg p-8 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 19 16.5 19c-1.746 0-3.332-.523-4.5-1.253" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada buku yang sedang dibaca</h3>
                        <p class="text-gray-500 mb-4">Mulai membaca buku dari koleksi kami</p>
                        <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors min-h-[40px]">
                            Jelajahi Buku
                        </a>
                    </div>
                @endif
            </div>

            <!-- Finished Books -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                    Buku Selesai Dibaca
                    <span class="ml-2 bg-green-100 text-green-800 text-sm px-2 py-1 rounded-full">{{ $finishedBooks->count() }}</span>
                </h2>
                
                @if($finishedBooks->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($finishedBooks as $userBook)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $userBook->book->title }}</h3>
                                    <p class="text-gray-600 mb-2">oleh {{ $userBook->book->author }}</p>
                                    <p class="text-sm text-gray-500 mb-4">Selesai: {{ $userBook->finished_at ? $userBook->finished_at->format('d M Y') : 'N/A' }}</p>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('books.show', $userBook->book->slug) }}" 
                                           class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-md text-center text-sm hover:bg-gray-700 transition-colors font-medium inline-flex items-center justify-center min-h-[40px]">
                                            Lihat Detail
                                        </a>
                                        <a href="{{ route('books.show', $userBook->book->slug) }}" 
                                           class="flex-1 bg-yellow-600 text-white px-4 py-2 rounded-md text-center text-sm hover:bg-yellow-700 transition-colors font-medium inline-flex items-center justify-center min-h-[40px]">
                                            Beri Rating
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg p-8 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada buku yang selesai dibaca</h3>
                        <p class="text-gray-500">Lengkapi buku yang sedang Anda baca</p>
                    </div>
                @endif
            </div>

            <!-- Wishlist Books -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></span>
                    Wishlist
                    <span class="ml-2 bg-yellow-100 text-yellow-800 text-sm px-2 py-1 rounded-full">{{ $wishlistBooks->count() }}</span>
                </h2>
                
                @if($wishlistBooks->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($wishlistBooks as $userBook)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $userBook->book->title }}</h3>
                                    <p class="text-gray-600 mb-2">oleh {{ $userBook->book->author }}</p>
                                    <p class="text-sm text-gray-500 mb-4">Ditambahkan: {{ $userBook->created_at->format('d M Y') }}</p>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('books.show', $userBook->book->slug) }}" 
                                           class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md text-center text-sm hover:bg-blue-700 transition-colors font-medium inline-flex items-center justify-center min-h-[40px]">
                                            Lihat Detail
                                        </a>
                                        @if($userBook->book->file_path)
                                            <a href="{{ route('books.read', $userBook->book->slug) }}" 
                                               class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md text-center text-sm hover:bg-green-700 transition-colors font-medium inline-flex items-center justify-center min-h-[40px]">
                                                Baca Buku
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg p-8 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Wishlist kosong</h3>
                        <p class="text-gray-500 mb-4">Tambahkan buku ke wishlist untuk dibaca nanti</p>
                        <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors min-h-[40px]">
                            Jelajahi Buku
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modern notification popup functionality
        const notificationPopup = document.getElementById('notification-popup');
        if (notificationPopup) {
            // Animate in with bounce effect
            setTimeout(() => {
                notificationPopup.classList.remove('translate-x-full', 'opacity-0');
                notificationPopup.classList.add('translate-x-0', 'opacity-100');
            }, 100);

            // Auto hide after 6 seconds
            setTimeout(() => {
                closeNotification();
            }, 6000);

            // Add progress bar animation
            const progressBar = notificationPopup.querySelector('.h-1');
            if (progressBar) {
                progressBar.style.width = '100%';
                progressBar.style.transition = 'width 6s linear';
                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 100);
            }
        }
    });

    // Function to close notification with smooth animation
    function closeNotification() {
        const notificationPopup = document.getElementById('notification-popup');
        if (notificationPopup) {
            // Animate out
            notificationPopup.classList.remove('translate-x-0', 'opacity-100');
            notificationPopup.classList.add('translate-x-full', 'opacity-0');
            
            // Remove from DOM after animation
            setTimeout(() => {
                if (notificationPopup.parentElement) {
                    notificationPopup.remove();
                }
            }, 500);
        }
    }
    </script>
    @endpush