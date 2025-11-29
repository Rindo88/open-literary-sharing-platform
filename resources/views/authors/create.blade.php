@extends('layouts.app')

@section('title', 'Buat Profil Penulis')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow-xl rounded-xl p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Buat Profil Penulis</h2>

            <form action="{{ route('author.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="pen_name" class="block text-sm font-medium text-gray-700">Nama Pena</label>
                    <input type="text" id="pen_name" name="pen_name" value="{{ old('pen_name') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('pen_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea id="bio" name="bio" rows="5"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('bio') }}</textarea>
                    @error('bio')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('avatar')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @php($categories = \App\Models\Category::all())
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($categories as $category)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="text-blue-600 rounded border-gray-300"
                                       @if(collect(old('categories'))->contains($category->id)) checked @endif>
                                <span class="text-sm text-gray-700">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-primary px-6 py-3 rounded-md text-white">Simpan Profil</button>
                    <a href="{{ url()->previous() }}" class="ml-3 px-6 py-3 rounded-md border border-gray-300 text-gray-700">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isVerified = document.getElementById('is_verified');
            const verifiedAt = document.getElementById('verified_at');
            function toggleVerifiedAt() {
                const enabled = isVerified.checked;
                verifiedAt.disabled = !enabled;
                if (!enabled) verifiedAt.value = '';
            }
            toggleVerifiedAt();
            isVerified.addEventListener('change', toggleVerifiedAt);
        });
    </script>
@endsection