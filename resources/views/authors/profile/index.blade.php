@extends('layouts.author')

@section('title', 'Profil Penulis')
@section('authors-content')
<div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Profil Penulis</h1>
                        <p class="text-gray-600">Kelola informasi profil penulis Anda</p>
                    </div>
                </div>
                
                <a href="{{ route('authors.books.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Kelola Buku
                </a>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-6">
            <!-- Profile Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Profil</h2>
                        <p class="text-sm text-gray-600 mt-1">Data profil penulis Anda</p>
                    </div>
                    <a href="{{ route('authors.profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Avatar & Basic Info -->
                    <div class="lg:col-span-1">
                        <div class="space-y-6">
                            <!-- Avatar -->
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    @if($authorProfile->avatar)
                                        <img src="{{ Storage::url($authorProfile->avatar) }}" 
                                             alt="{{ $authorProfile->pen_name }}" 
                                             class="h-40 w-40 rounded-full object-cover border-4 border-white shadow-lg">
                                    @else
                                        <div class="h-40 w-40 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center border-4 border-white shadow-lg">
                                            <span class="text-4xl font-bold text-white">
                                                {{ substr($authorProfile->pen_name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if($authorProfile->is_verified)
                                    <div class="absolute bottom-2 right-2 bg-green-500 text-white p-1 rounded-full">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="mt-4 text-center">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $authorProfile->pen_name }}</h3>
                                    <div class="mt-2 flex items-center justify-center space-x-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Penulis
                                        </span>
                                        @if($authorProfile->is_verified)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Terverifikasi
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Statistik Penulis</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Total Buku</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ $authorProfile->books_count ?? 0 }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Bergabung Sejak</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ $authorProfile->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    @if($authorProfile->verified_at)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Terverifikasi</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ $authorProfile->verified_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Details -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            <!-- Bio -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Biografi</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    @if($authorProfile->bio)
                                        <p class="text-gray-700 leading-relaxed">{{ $authorProfile->bio }}</p>
                                    @else
                                        <p class="text-gray-500 italic">Belum ada biografi</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Categories -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Kategori Minat</h4>
                                <div class="flex flex-wrap gap-2">
                                    @if($authorProfile->categories && count($authorProfile->categories) > 0)
                                        @foreach($authorProfile->categories as $categoryId)
                                            @php($category = \App\Models\Category::find($categoryId))
                                            @if($category)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700 border border-blue-100">
                                                @if($category->icon)
                                                    <span class="mr-2">{!! $category->icon !!}</span>
                                                @endif
                                                {{ $category->name }}
                                            </span>
                                            @endif
                                        @endforeach
                                    @else
                                        <p class="text-gray-500 italic">Belum memilih kategori</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Informasi Kontak</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Email Utama</p>
                                                <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Nama Asli</p>
                                                <p class="text-sm text-gray-600">{{ auth()->user()->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Books -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Buku Terbaru</h2>
                        <p class="text-sm text-gray-600 mt-1">Buku-buku yang baru Anda terbitkan</p>
                    </div>
                    <a href="{{ route('authors.books.index') }}" 
                       class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            
            <div class="p-6">
                @php($recentBooks = $authorProfile->books()->latest()->take(3)->get())
                @if($recentBooks->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($recentBooks as $book)
                        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-start space-x-4">
                                @if($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="h-20 w-16 object-cover rounded">
                                @else
                                    <div class="h-20 w-16 bg-gradient-to-r from-blue-400 to-purple-500 rounded flex items-center justify-center">
                                        <span class="text-white font-bold">B</span>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 line-clamp-2">{{ $book->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ $book->published_year }}</p>
                                    <div class="mt-2 flex items-center">
                                        <span class="text-xs px-2 py-1 rounded-full {{ $book->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $book->status === 'published' ? 'Terbit' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <p class="mt-3 text-gray-500">Belum ada buku yang diterbitkan</p>
                        <a href="{{ route('authors.books.create') }}" 
                           class="mt-3 inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Terbitkan Buku Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection