@extends('layouts.author')

@section('title', 'Buat Profil Penulis')
@section('authors-content')
<div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <h1 class="text-2xl font-bold text-gray-900">Buat Profil Penulis</h1>
            </div>
            <p class="text-gray-600">
                Lengkapi informasi profil penulis Anda untuk memulai perjalanan menulis di platform kami.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <!-- Form Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Profil</h2>
                        <p class="text-sm text-gray-600 mt-1">Isi data dengan lengkap dan akurat</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('author.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Nama Pena -->
                <div class="space-y-2">
                    <label for="pen_name" class="block text-sm font-medium text-gray-700">
                        Nama Pena
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="pen_name" 
                               name="pen_name" 
                               value="{{ old('pen_name') }}"
                               placeholder="Masukkan nama pena Anda"
                               class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    @error('pen_name')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Bio -->
                <div class="space-y-2">
                    <label for="bio" class="block text-sm font-medium text-gray-700">
                        Biografi
                        <span class="text-gray-500 text-xs font-normal">(Opsional)</span>
                    </label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="4"
                              placeholder="Ceritakan sedikit tentang diri Anda, latar belakang, dan minat menulis..."
                              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">{{ old('bio') }}</textarea>
                    <p class="text-xs text-gray-500">Maksimal 500 karakter</p>
                    @error('bio')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Avatar Upload -->
                <div class="space-y-2">
                    <label for="avatar" class="block text-sm font-medium text-gray-700">
                        Foto Profil
                        <span class="text-gray-500 text-xs font-normal">(Opsional)</span>
                    </label>
                    <div class="mt-1 flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300 border-dashed">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition-colors duration-200">
                                <input type="file" 
                                       id="avatar" 
                                       name="avatar" 
                                       accept="image/*"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       onchange="previewImage(event)">
                                <p class="text-xs text-gray-500 mt-2">
                                    Format: JPG, PNG, GIF • Maksimal: 2MB • Ukuran disarankan: 400x400px
                                </p>
                            </div>
                        </div>
                    </div>
                    @error('avatar')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Categories Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Kategori Minat
                        <span class="text-gray-500 text-xs font-normal">(Pilih satu atau lebih)</span>
                    </label>
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($categories as $category)
                        <label class="relative flex items-center p-3 border border-gray-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 cursor-pointer transition-all duration-200">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}" 
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   @if(collect(old('categories'))->contains($category->id)) checked @endif>
                            <span class="ml-3 text-sm font-medium text-gray-700 flex-1">
                                {{ $category->name }}
                            </span>
                            @if($category->icon)
                            <span class="text-lg ml-2">{!! $category->icon !!}</span>
                            @endif
                        </label>
                        @endforeach
                    </div>
                    @error('categories')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-600">
                                Dengan membuat profil penulis, Anda menyetujui
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Syarat & Ketentuan</a> kami.
                            </p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ url()->previous() }}" 
                               class="inline-flex items-center px-5 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-5 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Buat Profil Penulis
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview for avatar upload
    function previewImage(event) {
        const input = event.target;
        const previewContainer = input.closest('div').previousElementSibling;
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-24 w-24 rounded-full object-cover';
                
                const previewDiv = previewContainer.querySelector('div');
                previewDiv.innerHTML = '';
                previewDiv.appendChild(img);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Add event listener for file input
    const avatarInput = document.getElementById('avatar');
    if (avatarInput) {
        avatarInput.addEventListener('change', previewImage);
    }

    // Character counter for bio
    const bioTextarea = document.getElementById('bio');
    if (bioTextarea) {
        // Create character counter
        const counter = document.createElement('p');
        counter.className = 'text-xs text-gray-500 mt-1 text-right';
        counter.id = 'bio-counter';
        bioTextarea.parentNode.appendChild(counter);
        
        function updateCounter() {
            const currentLength = bioTextarea.value.length;
            const maxLength = 500;
            counter.textContent = `${currentLength} / ${maxLength} karakter`;
            
            if (currentLength > maxLength) {
                counter.classList.add('text-red-500');
                counter.classList.remove('text-gray-500');
            } else {
                counter.classList.remove('text-red-500');
                counter.classList.add('text-gray-500');
            }
        }
        
        // Initial counter update
        updateCounter();
        
        // Update on input
        bioTextarea.addEventListener('input', updateCounter);
    }

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const penNameInput = document.getElementById('pen_name');
        if (penNameInput.value.trim() === '') {
            e.preventDefault();
            penNameInput.focus();
            penNameInput.classList.add('border-red-500');
            
            // Show error message
            let errorDiv = penNameInput.nextElementSibling;
            if (!errorDiv || !errorDiv.classList.contains('text-red-600')) {
                errorDiv = document.createElement('p');
                errorDiv.className = 'mt-1 text-sm text-red-600 flex items-center';
                errorDiv.innerHTML = `
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Nama pena wajib diisi.
                `;
                penNameInput.parentNode.appendChild(errorDiv);
            }
        }
    });

    // Auto-hide flash messages after 5 seconds
    const flashMessages = document.querySelectorAll('[id$="-notification"]');
    flashMessages.forEach(message => {
        setTimeout(() => {
            if (message && message.parentElement) {
                message.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (message.parentElement) {
                        message.remove();
                    }
                }, 300);
            }
        }, 5000);
    });
});
</script>
@endsection