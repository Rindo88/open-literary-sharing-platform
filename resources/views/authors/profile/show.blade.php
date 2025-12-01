@extends('layouts.app')

@section('title', 'Profil Penulis - ' . ($authorProfile->pen_name ?? 'Penulis'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors">
                        Home
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors">
                        Penulis
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-medium truncate max-w-xs">
                    {{ $authorProfile->pen_name ?? 'Penulis' }}
                </li>
            </ol>
        </nav>

        <!-- Profile Header -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="relative">
                <!-- Profile Banner -->
                <div class="h-32 bg-gradient-to-r from-blue-600 to-purple-600"></div>
                
                <!-- Profile Content -->
                <div class="relative px-6 pb-8">
                    <div class="flex flex-col md:flex-row items-start md:items-end -mt-16 md:-mt-20">
                        <!-- Avatar -->
                        <div class="relative mb-4 md:mb-0">
                            <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl border-4 border-white shadow-xl overflow-hidden bg-white">
                                @if($authorProfile->avatar)
                                    <img src="{{ Storage::url($authorProfile->avatar) }}" 
                                         alt="{{ $authorProfile->pen_name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-4xl md:text-5xl font-bold text-white">
                                            {{ strtoupper(substr($authorProfile->pen_name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Verification Badge -->
                            @if($authorProfile->is_verified)
                            <div class="absolute -bottom-2 -right-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white p-2 rounded-full shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif
                        </div>

                        <!-- Profile Info -->
                        <div class="md:ml-8 flex-1">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                                        {{ $authorProfile->pen_name }}
                                    </h1>
                                    <p class="text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ $authorProfile->user->name ?? 'Penulis' }}
                                    </p>
                                </div>
                                
                                <div class="mt-4 md:mt-0">
                                    @if($authorProfile->is_verified && $authorProfile->verified_at)
                                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-50 text-green-700 border border-green-200">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Terverifikasi {{ $authorProfile->verified_at->diffForHumans() }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="text-center p-4 bg-blue-50 rounded-xl">
                                    <div class="text-2xl font-bold text-blue-700 mb-1">{{ $booksCount }}</div>
                                    <div class="text-sm text-blue-600">Buku</div>
                                </div>
                                <div class="text-center p-4 bg-purple-50 rounded-xl">
                                    <div class="text-2xl font-bold text-purple-700 mb-1">
                                        {{ number_format($averageRating, 1) }}
                                    </div>
                                    <div class="text-sm text-purple-600">Rating Rata-rata</div>
                                </div>
                                <div class="text-center p-4 bg-green-50 rounded-xl">
                                    <div class="text-2xl font-bold text-green-700 mb-1">
                                        {{ $authorProfile->user->created_at->format('Y') }}
                                    </div>
                                    <div class="text-sm text-green-600">Bergabung</div>
                                </div>
                                <div class="text-center p-4 bg-orange-50 rounded-xl">
                                    <div class="text-2xl font-bold text-orange-700 mb-1">
                                        {{ $recentBooks->count() }}
                                    </div>
                                    <div class="text-sm text-orange-600">Karya Terbaru</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Biography -->
                @if($authorProfile->bio)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h2 class="ml-3 text-xl font-bold text-gray-900">Tentang Penulis</h2>
                    </div>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed text-lg">{{ $authorProfile->bio }}</p>
                    </div>
                </div>
                @endif

                <!-- Recent Books -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-indigo-100 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h2 class="ml-3 text-xl font-bold text-gray-900">Karya Terbaru</h2>
                        </div>
                        @if($booksCount > 6)
                        <a href="{{ route('books.index', ['author' => $authorProfile->user->name]) }}" 
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                            Lihat Semua →
                        </a>
                        @endif
                    </div>

                    @if($recentBooks->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($recentBooks as $book)
                            <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}" 
                               class="group bg-gray-50 hover:bg-white rounded-xl p-4 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                                <div class="flex space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($book->cover_image)
                                            <img src="{{ Storage::url($book->cover_image) }}" 
                                                 alt="{{ $book->title }}" 
                                                 class="w-16 h-20 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-bold">B</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-sm text-gray-500 mb-2">{{ $book->published_year }}</p>
                                        
                                        @if($book->ratings->count() > 0)
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $book->ratings->avg('rating') ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                @endfor
                                            </div>
                                            <span class="ml-1 text-xs text-gray-500">({{ $book->ratings->count() }})</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="text-gray-500">Belum ada buku yang diterbitkan</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Categories -->
                @if($categories->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h2 class="ml-3 text-xl font-bold text-gray-900">Kategori Minat</h2>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($categories as $category)
                        <div class="flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                @if($category->icon)
                                <span class="text-xl mr-3">{!! $category->icon !!}</span>
                                @endif
                                <span class="font-medium text-gray-800">{{ $category->name }}</span>
                            </div>
                            @php($categoryBooksCount = $authorProfile->books()->published()->whereJsonContains('categories', $category->id)->count())
                            <span class="text-sm text-gray-500 bg-white px-2 py-1 rounded-full">
                                {{ $categoryBooksCount }} buku
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Contact Info -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h2 class="ml-3 text-xl font-bold text-gray-900">Informasi</h2>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Bergabung</p>
                                <p class="font-medium text-gray-900">
                                    {{ $authorProfile->user->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium {{ $authorProfile->is_verified ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $authorProfile->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Total Karya</p>
                                <p class="font-medium text-blue-600">{{ $booksCount }} buku</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-photo {
        transition: all 0.3s ease;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .profile-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stats-card {
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth hover effects to book cards
    const bookCards = document.querySelectorAll('.group');
    bookCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Follow button animation
    const followBtn = document.querySelector('button[class*="from-blue-600"]');
    if (followBtn) {
        followBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const originalText = this.innerHTML;
            this.innerHTML = `
                <svg class="w-5 h-5 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Memproses...
            `;
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                this.innerHTML = `
                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Diikuti
                `;
                this.classList.remove('from-blue-600', 'to-indigo-600');
                this.classList.add('from-green-500', 'to-emerald-600');
                
                // Revert after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('from-green-500', 'to-emerald-600');
                    this.classList.add('from-blue-600', 'to-indigo-600');
                    this.disabled = false;
                }, 2000);
            }, 1500);
        });
    }
});
</script>
@endpush