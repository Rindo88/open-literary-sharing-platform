@extends('layouts.app')

@section('title', 'LitShare - Perpustakaan Digital Terbuka')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
        <!-- Hero Section -->
        <section class="relative py-20 lg:py-32">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                        Temukan & Bagikan
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Karya Terbaik
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        Platform perpustakaan digital terbuka untuk membaca, berbagi, dan berdiskusi tentang karya tulis
                        terbaik dari penulis Indonesia.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('books.index') }}"
                            class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-full font-semibold text-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            📚 Jelajahi Koleksi
                        </a>
                        @auth
                            <a href="{{ route('authors.books.create') }}"
                                class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-blue-600 hover:text-white transition-all duration-300">
                                ✍️ Mulai Menulis
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-blue-600 hover:text-white transition-all duration-300">
                                🚀 Bergabung Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">
                            {{ \App\Models\Book::published()->count() }}+</div>
                        <div class="text-gray-600">Karya Tulis</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">
                            {{ \App\Models\AuthorProfile::count() }}+</div>
                        <div class="text-gray-600">Penulis</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">{{ \App\Models\Category::count() }}+
                        </div>
                        <div class="text-gray-600">Kategori</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">
                            {{ \App\Models\BookDiscussion::count() }}+</div>
                        <div class="text-gray-600">Diskusi</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Jelajahi Kategori</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan karya berdasarkan kategori favorit Anda</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!-- Di bagian featured categories, ganti ini: -->
                    @foreach ($categories->take(12) as $category)
                        <a href="{{ route('books.by-type', $category->id) }}"
                            class="group bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                            <div class="text-3xl mb-3 group-hover:scale-110 transition-transform duration-300">
                                @if ($category->icon)
                                    {!! $category->icon !!}
                                @else
                                    📚
                                @endif
                            </div>
                            <h3
                                class="font-semibold text-gray-800 text-sm mb-1 group-hover:text-blue-600 transition-colors">
                                {{ $category->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $category->books_count }} karya</p>
                        </a>
                    @endforeach
                </div>

                @if ($categories->count() > 12)
                    <div class="text-center mt-8">
                        <a href="{{ route('books.index') }}"
                            class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                            Lihat Semua Kategori
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Popular Books -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Karya Populer</h2>
                        <p class="text-lg text-gray-600">Buku-buku yang paling banyak dibaca dan didiskusikan</p>
                    </div>
                    <a href="{{ route('books.index') }}?sort=popular"
                        class="hidden md:flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                        Lihat Semua
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($popularBooks as $book)
                        <div
                            class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                            <div class="relative">
                                <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-cover.jpg') }}"
                                    alt="{{ $book->title }}" class="w-full h-48 object-cover">
                                <div class="absolute top-3 left-3">
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        🔥 Popular
                                    </span>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-70 flex items-center justify-center transition-all duration-300 opacity-0 hover:opacity-100">
                                    <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}"
                                        class="bg-white text-blue-600 px-4 py-2 rounded-full font-semibold hover:bg-blue-600 hover:text-white transition-all duration-200">
                                        Baca Sekarang
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                                    <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}">
                                        {{ $book->title }}
                                    </a>
                                </h3>

                                <div class="flex items-center mb-2">
                                    <span class="text-gray-600 text-sm">
                                        oleh {{ $book->author->display_name }}
                                        @if ($book->author->is_verified)
                                            <span class="ml-1 text-green-500 text-xs" title="Verified Author">✅</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="text-sm {{ $i <= $book->average_rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                        <span class="text-gray-500 text-xs ml-1">({{ $book->total_ratings }})</span>
                                    </div>
                                    <span class="text-gray-500 text-xs">{{ $book->published_year }}</span>
                                </div>

                                <div class="flex flex-wrap gap-1">
                                    @foreach ($book->categoryObjects->take(2) as $category)
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                                                                <div class="wishlist float-right">
                                    @php
                                        $userBook = auth()->check()
                                            ? $book->userBooks->firstWhere('user_id', auth()->id())
                                            : null;
                                    @endphp
    
    
                                    <button
                                        class="wishlist-btn p-2 rounded-lg transition-colors duration-200
                                                {{ $userBook && $userBook->status === 'wishlist' ? 'text-red-500' : '' }}"
                                        data-book-id="{{ $book->id }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8 md:hidden">
                    <a href="{{ route('books.index') }}?sort=popular"
                        class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                        Lihat Semua Karya Populer
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Latest Books -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Karya Terbaru</h2>
                        <p class="text-lg text-gray-600">Buku-buku yang baru saja diupload ke platform</p>
                    </div>
                    <a href="{{ route('books.index') }}"
                        class="hidden md:flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                        Lihat Semua
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($latestBooks as $book)
                        <div
                            class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                            <div class="relative">
                                <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-cover.jpg') }}"
                                    alt="{{ $book->title }}" class="w-full h-48 object-cover">
                                <div class="absolute top-3 left-3">
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        🆕 Baru
                                    </span>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-70 flex items-center justify-center transition-all duration-300 opacity-0 hover:opacity-100">
                                    <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}"
                                        class="bg-white text-blue-600 px-4 py-2 rounded-full font-semibold hover:bg-blue-600 hover:text-white transition-all duration-200">
                                        Baca Sekarang
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3
                                    class="font-bold text-gray-800 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                                    <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}">
                                        {{ $book->title }}
                                    </a>
                                </h3>

                                <div class="flex items-center mb-2">
                                    <span class="text-gray-600 text-sm">
                                        oleh {{ $book->author->display_name }}
                                        @if ($book->author->is_verified)
                                            <span class="ml-1 text-green-500 text-xs" title="Verified Author">✅</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="text-sm {{ $i <= $book->average_rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                        <span class="text-gray-500 text-xs ml-1">({{ $book->total_ratings }})</span>
                                    </div>
                                    <span class="text-gray-500 text-xs">{{ $book->pages }} hlm</span>
                                </div>

                                <div class="flex flex-wrap gap-1">
                                    @foreach ($book->categoryObjects->take(2) as $category)
                                        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="wishlist float-right">
                                    @php
                                        $userBook = auth()->check()
                                            ? $book->userBooks->firstWhere('user_id', auth()->id())
                                            : null;
                                    @endphp
    
    
                                    <button
                                        class="wishlist-btn p-2 rounded-lg transition-colors duration-200
                                                {{ $userBook && $userBook->status === 'wishlist' ? 'text-red-500' : '' }}"
                                        data-book-id="{{ $book->id }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8 md:hidden">
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                        Lihat Semua Karya Terbaru
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Membagikan Karyamu?</h2>
                <p class="text-xl mb-8 opacity-90">Bergabung dengan komunitas penulis dan bagikan karya terbaikmu kepada
                    dunia</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('authors.books.create') }}"
                            class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1">
                            ✍️ Upload Karya Pertamamu
                        </a>
                        <a href="{{ route('authors.dashboard') }}"
                            class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                            📊 Dashboard Penulis
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1">
                            🚀 Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                            class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                            🔐 Masuk ke Akun
                        </a>
                    @endauth
                </div>
            </div>
        </section>
    </div>


    <script>
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const bookId = this.dataset.bookId;

                try {
                    const response = await fetch(`/books/toogle/${bookId}/wishlist`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        }
                    });

                    const data = await response.json();

                    if (data.status === "added") {
                        this.classList.add("text-red-500");
                    } else if (data.status === "removed") {
                        this.classList.remove("text-red-500");
                    }

                } catch (e) {
                    console.error(e);
                    alert("Terjadi error saat mengubah wishlist");
                }
            });
        });
    </script>
@endsection
