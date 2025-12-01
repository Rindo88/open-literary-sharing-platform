@extends('layouts.app')

@section('title', 'Katalog Buku - LitShare')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Katalog Buku</h1>
                        <p class="text-gray-600 mt-2">Jelajahi semua karya tulis yang tersedia di LitShare</p>
                    </div>
                    <div class="mt-4 lg:mt-0">
                        <div class="relative w-full lg:w-96">
                            <form action="{{ route('books.index') }}" method="GET">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari judul, penulis, atau kata kunci..."
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar -->
                <div class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-24">
                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                Kategori
                            </h3>
                            <div class="space-y-2 max-h-96 overflow-y-auto">
                                <a href="{{ route('books.index') }}"
                                    class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ !request('category') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200">
                                    <span class="flex items-center">
                                        <span class="mr-2">📚</span>
                                        Semua Kategori
                                    </span>
                                    <span
                                        class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">{{ $totalBooks }}</span>
                                </a>
                                @foreach ($categories as $category)
                                    <a href="{{ route('books.index', ['category' => $category->id]) }}"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ request('category') == $category->id ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200">
                                        <span class="flex items-center">
                                            @if ($category->icon)
                                                <span class="mr-2">{!! $category->icon !!}</span>
                                            @endif
                                            {{ $category->name }}
                                        </span>
                                        <span
                                            class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">{{ $category->books_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                                </svg>
                                Urutkan
                            </h3>
                            <div class="space-y-3">
                                @foreach ([
            'latest' => 'Terbaru',
            'popular' => 'Terpopuler',
            'rating' => 'Rating Tertinggi',
            'title' => 'Judul A-Z',
        ] as $value => $label)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="sort" value="{{ $value }}"
                                            class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                                            {{ request('sort', 'latest') == $value ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <span class="text-sm text-gray-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Active Filters -->
                        @if (request()->anyFilled(['search', 'category']))
                            <div class="pt-4 border-t border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                        </path>
                                    </svg>
                                    Filter Aktif
                                </h3>
                                <div class="space-y-2">
                                    @if (request('search'))
                                        <div class="flex items-center justify-between bg-blue-50 px-3 py-2 rounded-lg">
                                            <span class="text-sm text-blue-700">Pencarian: "{{ request('search') }}"</span>
                                            <a href="{{ route('books.index', request()->except('search')) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                    @if (request('category'))
                                        @php $activeCategory = $categories->firstWhere('id', request('category')); @endphp
                                        @if ($activeCategory)
                                            <div class="flex items-center justify-between bg-blue-50 px-3 py-2 rounded-lg">
                                                <span class="text-sm text-blue-700">Kategori:
                                                    {{ $activeCategory->name }}</span>
                                                <a href="{{ route('books.index', request()->except('category')) }}"
                                                    class="text-blue-500 hover:text-blue-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                    @if (request()->anyFilled(['search', 'category']))
                                        <a href="{{ route('books.index') }}"
                                            class="block text-center text-sm text-blue-600 hover:text-blue-700 font-medium mt-2">
                                            Hapus Semua Filter
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="flex-1">
                    <!-- Results Info -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-gray-600">
                                Menampilkan <span
                                    class="font-semibold text-gray-900">{{ $books->firstItem() ?? 0 }}-{{ $books->lastItem() ?? 0 }}</span>
                                dari <span class="font-semibold text-gray-900">{{ $books->total() }}</span> hasil
                            </div>
                            <div class="flex items-center space-x-4 mt-2 sm:mt-0">
                                <span class="text-sm text-gray-600 hidden sm:block">Tampilan:</span>
                                <div class="flex bg-gray-100 rounded-lg p-1">
                                    <button
                                        class="view-toggle px-3 py-2 rounded-md text-sm {{ $view === 'grid' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600' }}"
                                        data-view="grid">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button
                                        class="view-toggle px-3 py-2 rounded-md text-sm {{ $view === 'list' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600' }}"
                                        data-view="list">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Books -->
                    <div class="{{ $view === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-4' }}"
                        id="booksContainer">
                        @forelse($books as $book)
                            <div
                                class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300 {{ $view === 'list' ? 'flex' : '' }}">
                                <div class="{{ $view === 'list' ? 'w-32 flex-shrink-0' : '' }}">
                                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-cover.jpg') }}"
                                        alt="{{ $book->title }}"
                                        class="{{ $view === 'list' ? 'h-32 w-32 object-cover' : 'w-full h-48 object-cover' }}">
                                </div>
                                <div class="p-4 flex-1">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3
                                            class="font-semibold text-gray-900 hover:text-blue-600 transition-colors line-clamp-2">
                                            <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}">
                                                {{ $book->title }}
                                            </a>
                                        </h3>
                                        @if ($book->discussions_count > 10)
                                            <span
                                                class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap ml-2">
                                                🔥 Trending
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center mb-2">
                                        <span class="text-sm text-gray-600">
                                            oleh {{ $book->author->display_name }}
                                            @if ($book->author->is_verified)
                                                <span class="ml-1 text-green-500 text-xs" title="Verified Author">✅</span>
                                            @endif
                                        </span>
                                    </div>

                                    <div class="flex items-center space-x-4 mb-3 text-sm text-gray-500">
                                        <span>{{ $book->published_year }}</span>
                                        <span>{{ $book->pages }} halaman</span>
                                        <span>{{ $book->discussions_count }} diskusi</span>
                                    </div>

                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span
                                                    class="text-sm {{ $i <= $book->average_rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                            @endfor
                                            <span class="text-gray-500 text-xs ml-1">({{ $book->total_ratings }})</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-1 mb-4">
                                        @foreach ($book->categoryObjects->take(3) as $category)
                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>

                                    <div class="flex space-x-2">
                                        <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}"
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg text-center transition-colors duration-200">
                                            Baca Gratis
                                        </a>
                                        @php
                                            $userBook = auth()->check()
                                                ? $book->userBooks->firstWhere('user_id', auth()->id())
                                                : null;
                                        @endphp


                                        <button
                                            class="wishlist-btn p-2 rounded-lg transition-colors duration-200
                                            {{ $userBook && $userBook->status === 'wishlist' ? 'text-red-500' : '' }}"
                                            data-book-id="{{ $book->id }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="text-6xl mb-4">📚</div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada buku ditemukan</h3>
                                <p class="text-gray-600 mb-6">Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                                </p>
                                <a href="{{ route('books.index') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                    Tampilkan Semua Buku
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($books->hasPages())
                        <div class="mt-8">
                            {{ $books->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Filter Button -->
    <button
        class="lg:hidden fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg transition-all duration-200 transform hover:scale-110 z-50"
        id="mobileFilterButton">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
            </path>
        </svg>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View toggle
            const viewToggles = document.querySelectorAll('.view-toggle');
            const booksContainer = document.getElementById('booksContainer');

            viewToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const view = this.dataset.view;

                    // Update active state
                    viewToggles.forEach(t => {
                        t.classList.toggle('bg-white', t === this);
                        t.classList.toggle('shadow-sm', t === this);
                        t.classList.toggle('text-gray-900', t === this);
                        t.classList.toggle('text-gray-600', t !== this);
                    });

                    // Update URL without page reload
                    const url = new URL(window.location);
                    url.searchParams.set('view', view);
                    window.history.replaceState({}, '', url);

                    // Update container class
                    if (view === 'grid') {
                        booksContainer.className =
                            'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';
                    } else {
                        booksContainer.className = 'space-y-4';
                    }

                    // Update individual book cards
                    document.querySelectorAll('.bg-white.rounded-lg').forEach(card => {
                        if (view === 'list') {
                            card.classList.add('flex');
                            const img = card.querySelector('img');
                            img.classList.remove('h-48', 'w-full');
                            img.classList.add('h-32', 'w-32');
                        } else {
                            card.classList.remove('flex');
                            const img = card.querySelector('img');
                            img.classList.remove('h-32', 'w-32');
                            img.classList.add('h-48', 'w-full');
                        }
                    });
                });
            });

            // Mobile filter toggle
            const mobileFilterButton = document.getElementById('mobileFilterButton');
            const sidebar = document.querySelector('.lg\\:w-64');

            if (mobileFilterButton && sidebar) {
                mobileFilterButton.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('fixed');
                    sidebar.classList.toggle('inset-0');
                    sidebar.classList.toggle('z-40');
                    sidebar.classList.toggle('bg-white');
                    sidebar.classList.toggle('p-6');
                    sidebar.classList.toggle('overflow-y-auto');
                });

                // Close sidebar when clicking outside
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && !mobileFilterButton.contains(e.target) && !sidebar
                        .classList.contains('hidden')) {
                        sidebar.classList.add('hidden');
                        sidebar.classList.remove('fixed', 'inset-0', 'z-40', 'bg-white', 'p-6',
                            'overflow-y-auto');
                    }
                });
            }

            // Auto-submit sort form
            document.querySelectorAll('input[name="sort"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        });


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
