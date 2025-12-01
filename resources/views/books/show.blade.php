@extends('layouts.app')

@section('title', $book->title . ' - Perpustakaan Digital')

@section('content')
    <div class="max-w-7xl mx-auto py-4 sm:py-6 px-3 sm:px-6 lg:px-8">
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

        <!-- Breadcrumb -->
        <nav class="flex mb-4 sm:mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home.index') }}" class="text-gray-700 hover:text-gray-900 text-sm sm:text-base">
                        Katalog
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span
                            class="ml-1 text-gray-500 md:ml-2 text-sm sm:text-base truncate max-w-[150px] sm:max-w-none">{{ $book->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            <!-- Mobile Order: Book Cover First, then Details -->
            <!-- Book Cover and Basic Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <!-- Book Cover -->
                    <div class="mb-4 sm:mb-6">
                        @if ($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full rounded-lg shadow-md max-h-[300px] sm:max-h-[400px] lg:max-h-none object-cover mx-auto sm:mx-0">
                        @else
                            <div
                                class="w-full h-48 sm:h-64 lg:h-96 flex items-center justify-center bg-gray-200 rounded-lg">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 lg:w-24 lg:h-24 text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Book Actions -->
                    @auth
                        <div class="space-y-2 sm:space-y-3">
                            <!-- Di bagian Book Actions, perbaiki semua form actions: -->

                            @if ($userBook && $userBook->status === 'reading')
                                <div class="space-y-2">
                                    @if ($book->file_path)
                                        <a href="{{ route('books.read', $book->slug) }}"
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg text-center block text-sm sm:text-base">
                                            📖 Lanjutkan Membaca
                                        </a>
                                    @endif
                                    <!-- PERBAIKAN: gunakan route dengan parameter id -->
                                    <form method="POST" action="{{ route('books.finish-reading', $book->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg text-sm sm:text-base">
                                            ✅ Selesai Baca
                                        </button>
                                    </form>
                                </div>
                            @elseif($userBook && $userBook->status === 'wishlist')
                                <div class="space-y-2">
                                    @if ($book->file_path)
                                        <a href="{{ route('books.read', $book->slug) }}"
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg text-center block text-sm sm:text-base">
                                            📖 Baca Buku
                                        </a>
                                    @endif
                                    <!-- PERBAIKAN: gunakan route dengan parameter id -->
                                    <form method="POST" action="{{ route('books.start-reading', $book->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg text-sm sm:text-base">
                                            ➡️ Mulai Membaca
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="space-y-2">
                                    <!-- PERBAIKAN: gunakan route dengan parameter id -->
                                    <form method="POST" action="{{ route('books.start-reading', $book->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg text-sm sm:text-base">
                                            📚 Mulai Membaca
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <!-- PERBAIKAN: gunakan route dengan parameter id -->
                            <a href="{{ route('discussions.show', $book->id) }}"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg text-center flex items-center justify-center space-x-2 text-sm sm:text-base">
                                <span>💬 Diskusi Buku</span>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3 sm:py-4">
                            <p class="text-gray-600 mb-3 sm:mb-4 text-sm sm:text-base">Login untuk mengakses fitur lengkap</p>
                            <a href="{{ route('login') }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg inline-block text-sm sm:text-base">
                                Login
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Book Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-4 sm:p-6 mb-4 sm:mb-6">
                    <div class="mb-4">
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 leading-tight">
                            {{ $book->title }}</h1>
                                                    @php
                            $isWishlist = $book->is_in_user_wishlist; // accessor kamu sudah ada
                        @endphp

                        <form id="wishlist-form-{{ $book->id }}"
                            action="{{ $isWishlist ? route('books.remove-from-wishlist', $book->id) : route('books.add-to-wishlist', $book->id) }}"
                            method="POST" class="inline">
                            @csrf
                            @if ($isWishlist)
                                @method('DELETE')
                            @endif

                            <button type="submit" class="wishlist-btn text-2xl transition cursor-pointer"
                                data-book-id="{{ $book->id }}">
                                {!! $isWishlist ? '❤️' : '🤍' !!}
                            </button>
                        </form>
                        <p class="text-lg sm:text-xl text-gray-600 mb-3">oleh <a href="{{ route('authors.show', $book->author) }}" class="text-blue-400 underline font-bold">{{ $book->author->display_name }}</a></p>
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            @foreach ($categoryList as $category)
                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-800 text-xs">
                                    {{ $category->name }}
                                </span>
                            @endforeach

                            @if ($book->ratings->count() > 0)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="ml-1 text-base sm:text-lg font-semibold text-gray-900">
                                        {{ number_format($book->ratings->avg('rating'), 1) }}
                                    </span>
                                    <span class="ml-1 text-gray-600 text-sm sm:text-base">({{ $book->ratings->count() }}
                                        rating)</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
                        <p class="text-gray-700 leading-relaxed text-sm sm:text-base">{{ $book->description }}</p>
                    </div>

                    <!-- Book Metadata -->
                    <div class="mt-4 sm:mt-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base mb-1">ISBN</h4>
                                <p class="text-gray-600 text-sm sm:text-base">{{ $book->isbn ?? 'Tidak tersedia' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base mb-1">Tahun Terbit</h4>
                                <p class="text-gray-600 text-sm sm:text-base">
                                    {{ $book->published_year ?? 'Tidak tersedia' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base mb-1">Penerbit</h4>
                                <p class="text-gray-600 text-sm sm:text-base">{{ $book->publisher ?? 'Tidak tersedia' }}
                                </p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base mb-1">Jumlah Halaman</h4>
                                <p class="text-gray-600 text-sm sm:text-base">{{ $book->pages ?? 'Tidak tersedia' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rating Section -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Rating & Review</h3>

                    @auth
                        <!-- Add Rating Form -->
                        <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2 sm:mb-3 text-sm sm:text-base">Berikan Rating Anda</h4>
                            <form method="POST" action="{{ route('books.rate', $book->id) }}"
                                class="space-y-3 sm:space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <div id="rating-stars"
                                        class="flex justify-center sm:justify-start space-x-1 sm:space-x-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <input type="radio" name="rating" value="{{ $i }}"
                                                id="rating_{{ $i }}"
                                                {{ $userRating && $userRating->rating == $i ? 'checked' : '' }}
                                                class="sr-only">
                                            <label for="rating_{{ $i }}" class="cursor-pointer p-1">
                                                <svg class="w-8 h-8 sm:w-8 sm:h-8 {{ $userRating && $userRating->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                <div>
                                    <label for="review" class="block text-sm font-medium text-gray-700 mb-2">Review
                                        (Opsional)</label>
                                    <textarea name="review" id="review" rows="3" placeholder="Bagikan pendapat Anda tentang buku ini..."
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base">{{ $userRating ? $userRating->review : '' }}</textarea>
                                </div>
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-3 sm:px-4 rounded text-sm sm:text-base">
                                    {{ $userRating ? 'Update Rating' : 'Kirim Rating' }}
                                </button>
                            </form>
                        </div>
                    @endauth

                    <!-- Display Ratings -->
                    @if ($book->ratings->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach ($book->ratings as $rating)
                                <div
                                    class="border-b border-gray-200 pb-3 sm:pb-4 last:border-b-0 bg-gray-50 sm:bg-transparent p-3 sm:p-0 rounded-lg sm:rounded-none">
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 space-y-1 sm:space-y-0">
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="font-medium text-gray-900 text-sm sm:text-base">{{ $rating->user->name }}</span>
                                            <div class="flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <span
                                            class="text-xs sm:text-sm text-gray-500 bg-white sm:bg-transparent px-2 py-1 sm:px-0 sm:py-0 rounded text-center sm:text-left">{{ $rating->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if ($rating->review)
                                        <p
                                            class="text-gray-700 text-sm sm:text-base bg-white p-2 rounded border border-gray-200 sm:bg-transparent sm:p-0 sm:border-0">
                                            {{ $rating->review }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-6 sm:py-8 text-sm sm:text-base">Belum ada rating untuk buku
                            ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Rating stars functionality
            const ratingContainer = document.getElementById('rating-stars');
            if (ratingContainer) {
                const stars = ratingContainer.querySelectorAll('label');
                const inputs = ratingContainer.querySelectorAll('input[type="radio"]');

                // Fungsi untuk memperbarui tampilan bintang
                function updateStars(selectedIndex) {
                    stars.forEach((star, index) => {
                        const svg = star.querySelector('svg');
                        if (index < selectedIndex) {
                            svg.classList.add('text-yellow-400');
                            svg.classList.remove('text-gray-300');
                        } else {
                            svg.classList.remove('text-yellow-400');
                            svg.classList.add('text-gray-300');
                        }
                    });
                }

                // Event listener untuk setiap bintang
                stars.forEach((star, index) => {
                    // Efek hover
                    star.addEventListener('mouseover', () => {
                        updateStars(index + 1);
                    });

                    // Kembali ke state awal saat kursor tidak lagi hover
                    star.addEventListener('mouseleave', () => {
                        const checkedInput = ratingContainer.querySelector(
                            'input[type="radio"]:checked');
                        if (checkedInput) {
                            updateStars(parseInt(checkedInput.value));
                        } else {
                            updateStars(0);
                        }
                    });
                });
            }

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

        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // biarkan form tetap submit ke controller
                // TAPI kita update UI dulu sebelum redirect
                const icon = btn.innerHTML.trim();

                if (icon === '🤍') {
                    btn.innerHTML = '❤️';
                } else {
                    btn.innerHTML = '🤍';
                }
            });
        });
    </script>
@endpush
