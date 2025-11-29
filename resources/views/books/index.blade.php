@extends('layouts.app')

@section('title', 'Katalog Buku - Perpustakaan Digital')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Flash Messages - Modern Popup Notification -->
        @if (session('success') || session('error'))
            <div id="notification-popup"
                class="fixed top-6 right-6 z-[9999] max-w-sm w-full sm:max-w-md transform transition-all duration-500 ease-in-out translate-x-full opacity-0">
                @if (session('success'))
                    <div
                        class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl shadow-2xl border border-green-400 overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-semibold text-white">Berhasil!</h3>
                                    <p class="text-sm text-green-100 mt-1">{{ session('success') }}</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <button onclick="closeNotification()"
                                        class="inline-flex text-green-200 hover:text-white focus:outline-none focus:text-white transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-400 h-1 w-full"></div>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl shadow-2xl border border-red-400 overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-red-400 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-semibold text-white">Error!</h3>
                                    <p class="text-sm text-red-100 mt-1">{{ session('error') }}</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <button onclick="closeNotification()"
                                        class="inline-flex text-red-200 hover:text-white focus:outline-none focus:text-white transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
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
        <div class="px-4 py-6 sm:px-0">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Katalog Buku</h1>
                    <p class="mt-2 text-gray-600">Jelajahi ribuan buku digital dari berbagai kategori</p>
                </div>
                @auth
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('books.my-books') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Buku Saya
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white rounded-lg shadow p-6">
                <form method="GET" action="{{ route('books.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Buku</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Judul, penulis, atau deskripsi..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category" id="category"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                            <select name="sort" id="sort"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                                <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Penulis A-Z
                                </option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Cari
                        </button>

                        @if (request('search') || request('category') || request('sort') != 'latest')
                            <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-gray-900">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="px-4 py-6 sm:px-0">
            @if ($books->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($books as $book)
                        <div
                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <!-- Book Cover -->
                            <div class="aspect-w-2 aspect-h-3 bg-gray-200">
                                @if ($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-full h-64 object-cover">
                                @else
                                    <div class="w-full h-64 flex items-center justify-center bg-gray-200">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Book Info -->
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    @foreach ($book->category_list as $cat)
                                        <span class="px-2 py-1 rounded bg-blue-100 text-blue-800 text-xs">
                                            {{ $cat->name }}
                                        </span>
                                    @endforeach

                                    @if ($book->ratings->count() > 0)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="ml-1 text-sm text-gray-600">
                                                {{ number_format($book->ratings->avg('rating'), 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    <a href="{{ route('books.show', $book->slug) }}" class="hover:text-indigo-600">
                                        {{ $book->title }}
                                    </a>
                                </h3>

                                <p class="text-sm text-gray-600 mb-2">oleh {{ $book->author->pen_name }}</p>

                                <p class="text-sm text-gray-500 mb-4 line-clamp-3">{{ $book->description }}</p>

                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <a href="{{ route('books.show', $book->slug) }}"
                                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 px-3 rounded text-sm font-medium">
                                        Detail
                                    </a>

                                    @auth
                                        <form method="POST" action="{{ route('books.add-to-wishlist', $book) }}"
                                            class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-3 rounded text-sm font-medium">
                                                Wishlist
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $books->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada buku ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda.</p>
                </div>
            @endif
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
