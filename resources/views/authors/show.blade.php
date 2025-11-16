@extends('layouts.app')

@section('title', 'Profil Penulis')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white shadow-xl rounded-xl p-6">
        <div class="flex items-center space-x-6">
            @if($authorProfile && $authorProfile->avatar)
                <img src="{{ Storage::url($authorProfile->avatar) }}" alt="Avatar {{ $authorProfile->pen_name ?? ($authorProfile->user->name ?? 'Penulis') }}" class="h-24 w-24 rounded-full object-cover profile-photo">
            @else
                <div class="h-24 w-24 rounded-full bg-blue-600 flex items-center justify-center profile-photo">
                    <span class="text-white text-2xl font-semibold">{{ strtoupper(substr($authorProfile->pen_name ?? ($authorProfile->user->name ?? 'P'), 0, 1)) }}</span>
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $authorProfile->pen_name ?? 'Tanpa Nama Pena' }}</h1>
                @if($authorProfile->user)
                    <p class="text-sm text-gray-500">{{ $authorProfile->user->name }}{{ $authorProfile->user->email ? ' · '.$authorProfile->user->email : '' }}</p>
                @endif
                <div class="mt-2">
                    @if($authorProfile->is_verified)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Terverifikasi</span>
                        @if($authorProfile->verified_at)
                            <span class="ml-2 text-xs text-gray-500">sejak {{ $authorProfile->verified_at->format('d M Y') }}</span>
                        @endif
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Belum Terverifikasi</span>
                    @endif
                </div>
            </div>
        </div>

        @if($authorProfile->bio)
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Biografi</h2>
                <p class="text-gray-700 leading-relaxed">{{ $authorProfile->bio }}</p>
            </div>
        @endif

        @php($categoryIds = $authorProfile->categories ?? [])
        @php($categories = count($categoryIds) ? \App\Models\Category::whereIn('id', $categoryIds)->get() : collect())
        @if($categories->count() > 0)
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Kategori</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $cat)
                        <span class="px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700 border border-blue-200">{{ $cat->name }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        @php($booksCount = \App\Models\Book::where('author_id', $authorProfile->id)->count())
        <div class="mt-8 flex items-center justify-between">
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Kembali</a>
            <div class="text-sm text-gray-500">
                <svg class="inline-block w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                {{ $booksCount }} Buku
            </div>
        </div>
    </div>
</div>
@endsection
