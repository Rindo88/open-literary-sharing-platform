@extends('layouts.author')

@section('title', 'Edit Profil Penulis')
@section('authors-content')
<div class="px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <h1 class="text-2xl font-bold text-gray-900">Edit Profil Penulis</h1>
            </div>
            <p class="text-gray-600">
                Perbarui informasi profil penulis Anda.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <!-- Form Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-gray-900">Edit Informasi Profil</h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui data sesuai kebutuhan</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('authors.profile.update', $authorProfile->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Avatar Preview -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Foto Profil Saat Ini</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if($authorProfile->avatar)
                                <img src="{{ Storage::url($authorProfile->avatar) }}" 
                                     alt="{{ $authorProfile->pen_name }}" 
                                     class="h-24 w-24 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div class="h-24 w-24 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center border-2 border-gray-200">
                                    <span class="text-2xl font-bold text-white">
                                        {{ substr($authorProfile->pen_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-2">Unggah foto baru (opsional)</p>
                            <input type="file" 
                                   id="avatar" 
                                   name="avatar" 
                                   accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   onchange="previewImage(event)">
                            <p class="text-xs text-gray-500 mt-2">
                                Format: JPG, PNG, GIF • Maksimal: 2MB • Ukuran disarankan: 400x400px
                            </p>
                            @if($authorProfile->avatar)
                            <div class="mt-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="remove_avatar" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Hapus foto profil saat ini</span>
                                </label>
                            </div>
                            @endif
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

                <!-- Nama Pena -->
                <div class="space-y-2">
                    <label for="pen_name" class="block text-sm font-medium text-gray-700">
                        Nama Pena
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="pen_name" 
                           name="pen_name" 
                           value="{{ old('pen_name', $authorProfile->pen_name) }}"
                           placeholder="Masukkan nama pena Anda"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                           required>
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
                              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">{{ old('bio', $authorProfile->bio) }}</textarea>
                    <div class="flex justify-between">
                        <p class="text-xs text-gray-500">Maksimal 500 karakter</p>
                        <p id="bio-counter" class="text-xs text-gray-500">0 / 500</p>
                    </div>
                    @error('bio')
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
                                   {{ in_array($category->id, $authorProfile->categories ?? []) ? 'checked' : '' }}
                                   {{ collect(old('categories', $authorProfile->categories ?? []))->contains($category->id) ? 'checked' : '' }}>
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

                <!-- Verified Status -->
                @if(auth()->user()->role === 'admin')
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="is_verified" class="block text-sm font-medium text-gray-700">
                            Status Verifikasi
                        </label>
                        <span class="text-xs text-gray-500">Admin only</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" 
                               id="is_verified" 
                               name="is_verified" 
                               value="1"
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                               {{ old('is_verified', $authorProfile->is_verified) ? 'checked' : '' }}
                               onclick="toggleVerifiedAt()">
                        <label for="is_verified" class="text-sm text-gray-700">Tandai sebagai penulis terverifikasi</label>
                    </div>
                    
                    <div id="verified_at_container" class="space-y-2 {{ $authorProfile->is_verified ? '' : 'hidden' }}">
                        <label for="verified_at" class="block text-sm font-medium text-gray-700">Tanggal Verifikasi</label>
                        <input type="date" 
                               id="verified_at" 
                               name="verified_at" 
                               value="{{ old('verified_at', $authorProfile->verified_at ? $authorProfile->verified_at->format('Y-m-d') : '') }}"
                               class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    </div>
                </div>
                @endif

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <a href="{{ route('authors.profile') }}" 
                               class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali ke Profil
                            </a>
                        </div>
                        <div class="flex space-x-3">
                            <button type="button" 
                                    onclick="window.location.href='{{ route('authors.profile') }}'"
                                    class="inline-flex items-center px-5 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </button>
                            <button type="submit" 
                                    class="inline-flex items-center px-5 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
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
        const previewContainer = input.closest('.flex').querySelector('.flex-shrink-0');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-24 w-24 rounded-full object-cover border-2 border-gray-200';
                
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
        const counter = document.getElementById('bio-counter');
        
        function updateCounter() {
            const currentLength = bioTextarea.value.length;
            const maxLength = 500;
            counter.textContent = `${currentLength} / ${maxLength}`;
            
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

    // Toggle verified_at field
    function toggleVerifiedAt() {
        const isVerified = document.getElementById('is_verified');
        const verifiedAtContainer = document.getElementById('verified_at_container');
        
        if (isVerified.checked) {
            verifiedAtContainer.classList.remove('hidden');
        } else {
            verifiedAtContainer.classList.add('hidden');
            document.getElementById('verified_at').value = '';
        }
    }

    // Initialize verified_at toggle
    toggleVerifiedAt();
    const isVerifiedCheckbox = document.getElementById('is_verified');
    if (isVerifiedCheckbox) {
        isVerifiedCheckbox.addEventListener('change', toggleVerifiedAt);
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