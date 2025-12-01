@extends('layouts.app')

@section('title', $category->name . ' - Perpustakaan Terbuka')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <section class="bg-gradient-to-r from-purple-600 to-pink-500 text-white py-12">
        <div class="container mx-auto px-4 max-w-7xl">
            <nav class="flex items-center space-x-2 text-sm mb-4">
                <a href="{{ route('home.index') }}" class="text-white opacity-90 hover:opacity-100">Home</a>
                <span class="text-white opacity-70">></span>
                <span class="text-white font-semibold">{{ $category->name }}</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $category->name }}</h1>
            <p class="text-lg opacity-90">{{ $category->description ?? 'Jelajahi koleksi buku dalam kategori ' . $category->name }}</p>
        </div>
    </section>

    <!-- Books Section -->
    <section class="py-8">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filter -->
                <aside class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-24">
                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-4 text-gray-800">Kategori</h3>
                            <div class="space-y-2 max-h-80 overflow-y-auto">
                                <a href="{{ route('home.index') }}" 
                                   class="block px-3 py-2 rounded-lg border border-gray-200 hover:border-purple-500 hover:bg-purple-50 text-gray-700 transition-all duration-200">
                                    <div class="flex justify-between items-center">
                                        <span class="flex items-center">
                                            <span class="mr-2">📚</span>
                                            Semua Kategori
                                        </span>
                                    </div>
                                </a>
                                @foreach($categories as $cat)
                                <a href="{{ route('books.by-type', $cat->id) }}" 
                                   class="block px-3 py-2 rounded-lg border transition-all duration-200 {{ $cat->id == $category->id ? 'bg-purple-600 text-white border-purple-600' : 'border-gray-200 hover:border-purple-500 hover:bg-purple-50 text-gray-700' }}">
                                    <div class="flex justify-between items-center">
                                        <span class="flex items-center">
                                            @if($cat->icon) 
                                                <span class="mr-2">{!! $cat->icon !!}</span>
                                            @endif
                                            {{ $cat->name }}
                                        </span>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $cat->id == $category->id ? 'bg-white text-purple-600' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $cat->books_count }}
                                        </span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-4 text-gray-800">Urutkan</h3>
                            <div class="space-y-3">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="sort" value="latest" 
                                           class="w-4 h-4 text-purple-600 focus:ring-purple-500" 
                                           {{ request('sort', 'latest') == 'latest' ? 'checked' : '' }}>
                                    <span class="text-gray-700">Terbaru</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="sort" value="popular" 
                                           class="w-4 h-4 text-purple-600 focus:ring-purple-500"
                                           {{ request('sort') == 'popular' ? 'checked' : '' }}>
                                    <span class="text-gray-700">Terpopuler</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="sort" value="rating" 
                                           class="w-4 h-4 text-purple-600 focus:ring-purple-500"
                                           {{ request('sort') == 'rating' ? 'checked' : '' }}>
                                    <span class="text-gray-700">Rating Tertinggi</span>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @auth
                        <div class="space-y-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('authors.books.create') }}" 
                               class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 flex items-center justify-center text-sm">
                                <span class="mr-2">📖</span>
                                Upload Karya
                            </a>
                        </div>
                        @else
                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('register') }}" 
                               class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 flex items-center justify-center text-sm mb-2">
                                <span class="mr-2">🔐</span>
                                Daftar Menulis
                            </a>
                            <p class="text-xs text-gray-600 text-center">Gabung komunitas penulis</p>
                        </div>
                        @endauth
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="flex-1 min-w-0">
                    <!-- Toolbar -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="text-gray-700">
                                Menampilkan <strong>{{ $books->firstItem() ?? 0 }}-{{ $books->lastItem() ?? 0 }}</strong> 
                                dari <strong>{{ $books->total() }}</strong> karya dalam {{ $category->name }}
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-600 text-sm hidden sm:block">Tampilan:</span>
                                <div class="flex bg-gray-100 rounded-lg p-1">
                                    <button class="view-btn px-3 py-1 rounded-md transition-all duration-200 bg-white shadow-sm" data-view="grid">
                                        ⬜ Grid
                                    </button>
                                    <button class="view-btn px-3 py-1 rounded-md transition-all duration-200" data-view="list">
                                        ☰ List
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Books Grid -->
                    <div class="books-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="booksContainer">
                        @forelse($books as $book)
                        <div class="book-card bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300">
                            <div class="relative overflow-hidden">
                                <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-cover.jpg') }}" 
                                     alt="{{ $book->title }}" 
                                     class="w-full h-48 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-70 flex items-center justify-center transition-all duration-300 opacity-0 hover:opacity-100">
                                    @if($book->file_path)
                                    <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}" 
                                       class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-full transition-all duration-200 transform hover:scale-105">
                                        📖 Baca
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 mb-2 line-clamp-2 hover:text-purple-600 transition-colors duration-200">
                                    <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}">
                                        {{ $book->title }}
                                    </a>
                                </h3>
                                
                                <div class="flex items-center mb-2">
                                    <span class="text-gray-600 text-sm">
                                        oleh {{ $book->author->display_name }}
                                        @if($book->author->is_verified)
                                        <span class="ml-1 text-green-500 text-xs" title="Verified Author">✅</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center space-x-2 mb-3">
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                                        {{ $book->published_year }}
                                    </span>
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                                        {{ $book->pages }} hlm
                                    </span>
                                </div>

                                <div class="flex items-center space-x-2 mb-3">
                                    <div class="flex space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                        <span class="star text-sm {{ $i <= $book->average_rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                    <span class="text-gray-500 text-xs">({{ $book->total_ratings }})</span>
                                </div>

                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach($book->categoryObjects->take(2) as $cat)
                                    <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">
                                        {{ $cat->name }}
                                    </span>
                                    @endforeach
                                </div>

                                <div class="flex space-x-2">
                                    @if($book->file_path)
                                    <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}" 
                                       class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-200 text-center text-sm">
                                        Baca Gratis
                                    </a>
                                    @endif
                                    <button class="bg-white border border-gray-300 hover:border-purple-500 text-gray-700 hover:text-purple-600 font-semibold py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center text-sm">
                                        <span class="mr-1">🤍</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-5xl mb-4">📚</div>
                            <h3 class="text-xl font-bold text-gray-700 mb-3">Belum ada karya dalam kategori ini</h3>
                            <p class="text-gray-600 mb-6">
                                @auth 
                                <a href="{{ route('authors.books.create') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                                    Jadilah yang pertama mengupload karya
                                </a>
                                @else 
                                Daftar untuk mulai mengupload karya
                                @endauth
                            </p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($books->hasPages())
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-center">
                            {{ $books->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </main>
            </div>
        </div>
    </section>
</div>

<!-- Mobile Filter Button -->
<button class="lg:hidden fixed bottom-6 right-6 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-full shadow-lg transition-all duration-200 transform hover:scale-110 z-50 mobile-filter-toggle">
    📋 Filter
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-apply sort filters
    const applyFilters = () => {
        const url = new URL(window.location.href);
        const params = new URLSearchParams();

        // Sort
        const sort = document.querySelector('input[name="sort"]:checked');
        if (sort && sort.value !== 'latest') {
            params.set('sort', sort.value);
        }

        window.location.href = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
    };

    // Auto-apply filters on change
    document.querySelectorAll('input[name="sort"]').forEach(element => {
        element.addEventListener('change', applyFilters);
    });

    // View toggle
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => {
                b.classList.remove('bg-white', 'shadow-sm');
                b.classList.add('text-gray-600');
            });
            this.classList.add('bg-white', 'shadow-sm');
            this.classList.remove('text-gray-600');
            
            const booksContainer = document.getElementById('booksContainer');
            if (this.dataset.view === 'list') {
                booksContainer.className = 'books-grid grid grid-cols-1 gap-4 mb-8';
                document.querySelectorAll('.book-card').forEach(card => {
                    card.classList.add('flex');
                    card.querySelector('img').classList.add('w-32', 'h-32', 'object-cover');
                    card.querySelector('img').classList.remove('h-48');
                });
            } else {
                booksContainer.className = 'books-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8';
                document.querySelectorAll('.book-card').forEach(card => {
                    card.classList.remove('flex');
                    card.querySelector('img').classList.remove('w-32', 'h-32');
                    card.querySelector('img').classList.add('h-48');
                });
            }
        });
    });

    // Mobile filter toggle
    const mobileFilterToggle = document.querySelector('.mobile-filter-toggle');
    const sidebar = document.querySelector('aside');

    mobileFilterToggle.addEventListener('click', function() {
        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('fixed', 'inset-0', 'z-40', 'bg-white', 'p-6', 'overflow-y-auto');
        } else {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('fixed', 'inset-0', 'z-40', 'bg-white', 'p-6', 'overflow-y-auto');
        }
    });

    // Close mobile filter when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 1024 && 
            sidebar && 
            !sidebar.classList.contains('hidden') &&
            !sidebar.contains(e.target) && 
            !mobileFilterToggle.contains(e.target)) {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('fixed', 'inset-0', 'z-40', 'bg-white', 'p-6', 'overflow-y-auto');
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('fixed', 'inset-0', 'z-40', 'bg-white', 'p-6', 'overflow-y-auto', 'hidden');
        } else if (!sidebar.classList.contains('lg:w-64')) {
            sidebar.classList.add('hidden');
        }
    });
});
</script>
@endsection