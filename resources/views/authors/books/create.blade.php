@extends('layouts.author')

@section('title', 'Tambah Buku Baru')

@section('authors-content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Buku Baru</h1>
                    <p class="mt-2 text-gray-600">Upload buku baru ke perpustakaan digital</p>
                </div>
                <a href="{{ route('authors.books.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('authors.books.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Buku *</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Author -->
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700">Penulis *</label>
                            <input type="text" 
                                   name="author" 
                                   id="author" 
                                   value="{{ old('author') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('author')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Publisher -->
                        <div>
                            <label for="publisher" class="block text-sm font-medium text-gray-700">Penerbit *</label>
                            <input type="text" 
                                   name="publisher" 
                                   id="publisher" 
                                   value="{{ old('publisher') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('publisher')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Publication Year -->
                        <div>
                            <label for="published_year" class="block text-sm font-medium text-gray-700">Tahun Terbit *</label>
                            <input type="number" 
                                   name="published_year" 
                                   id="published_year" 
                                   value="{{ old('published_year') }}"
                                   min="1000" 
                                   max="{{ date('Y') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('published_year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pages -->
                        <div>
                            <label for="pages" class="block text-sm font-medium text-gray-700">Jumlah Halaman *</label>
                            <input type="number" 
                                   name="pages" 
                                   id="pages" 
                                   value="{{ old('pages') }}"
                                   min="1"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('pages')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ISBN -->
                        <div>
                            <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                            <input type="text" 
                                   name="isbn" 
                                   id="isbn" 
                                   value="{{ old('isbn') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('isbn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori *</label>
                            <div class="mt-2 space-y-2 max-h-60 overflow-y-auto border border-gray-300 rounded-md p-3 bg-white">
                                @foreach($categories as $category)
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="categories[]" 
                                               value="{{ $category->id }}" 
                                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Cover Image -->
                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Buku</label>
                            <div id="cover-upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    {{-- Loading Indicator --}}
                                    <div id="cover-loading" class="hidden mb-4">
                                        <div class="flex flex-col items-center justify-center p-8">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mb-2"></div>
                                            <p class="text-sm text-blue-600 font-medium">Mengupload cover...</p>
                                        </div>
                                    </div>

                                    {{-- Pratinjau Gambar akan muncul di sini --}}
                                    <div id="cover-preview-container" class="mb-4">
                                        @if(isset($book) && $book->cover_image)
                                            <img src="{{ Storage::url($book->cover_image) }}" alt="Current cover" class="mx-auto h-32 w-auto object-cover rounded">
                                            <p id="cover-filename" class="text-sm text-gray-500 mt-2">
                                                <div class="flex items-center justify-center">
                                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-green-600 font-semibold">Cover: {{ basename($book->cover_image) }}</span>
                                                </div>
                                            </p>
                                        @else
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <p id="cover-filename" class="text-sm text-gray-500 mt-2">Belum ada cover dipilih</p>
                                        @endif
                                    </div>
                                    <div class="flex justify-center text-sm text-gray-600">
                                        <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Pilih Cover</span>
                                            <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF (tanpa batasan ukuran)</p>
                                </div>
                            </div>
                            @error('cover_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- E-book File -->
                        <div>
                            <label for="file_path" class="block text-sm font-medium text-gray-700">File E-book *</label>
                            <div id="ebook-upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    {{-- Loading Indicator --}}
                                    <div id="ebook-loading" class="hidden mb-4">
                                        <div class="flex flex-col items-center justify-center p-8">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mb-2"></div>
                                            <p class="text-sm text-blue-600 font-medium">Mengupload e-book...</p>
                                        </div>
                                    </div>

                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    {{-- Nama file akan muncul di sini --}}
                                    <p id="ebook-filename" class="text-sm text-gray-500 mt-2">
                                        @if(isset($book) && $book->file_path)
                                            <div class="flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-green-600 font-semibold">File: {{ basename($book->file_path) }}</span>
                                            </div>
                                        @else
                                            Belum ada file dipilih
                                        @endif
                                    </p>
                                    <div class="flex justify-center text-sm text-gray-600">
                                        <label for="file_path" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Pilih File</span>
                                            <input id="file_path" name="file_path" type="file" class="sr-only" accept=".pdf,.epub" @if(!isset($book)) required @endif>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, EPUB (tanpa batasan ukuran)</p>
                                </div>
                            </div>
                            @error('file_path')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" 
                                    id="status" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi/Sinopsis *</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type = 'success') {
        // Hapus notifikasi lama jika ada
        const existingNotification = document.querySelector('.upload-notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Buat elemen notifikasi
        const notification = document.createElement('div');
        notification.className = `upload-notification fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
        if (type === 'success') {
            notification.classList.add('bg-green-500', 'text-white');
        } else if (type === 'error') {
            notification.classList.add('bg-red-500', 'text-white');
        } else if (type === 'info') {
            notification.classList.add('bg-blue-500', 'text-white');
        }

        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    ${type === 'success' ? 
                        '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>' :
                        '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>'
                    }
                </svg>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Animasikan masuk
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto hide setelah 5 detik
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, 5000);
    }

    // Fungsi untuk menangani pratinjau dan validasi file
    function handleFileUpload(inputId, previewContainerId, filenameId, isImage) {
        const fileInput = document.getElementById(inputId);
        if (!fileInput) return;

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const filenameEl = document.getElementById(filenameId);
            const previewContainer = document.getElementById(previewContainerId);
            const loadingEl = document.getElementById(isImage ? 'cover-loading' : 'ebook-loading');

            if (file) {
                // Tampilkan loading indicator
                if (loadingEl) {
                    loadingEl.classList.remove('hidden');
                }
                
                // Sembunyikan preview container sementara
                if (previewContainer) {
                    previewContainer.style.opacity = '0.5';
                }

                // Simulasi loading dengan timeout (untuk demo)
                setTimeout(() => {
                    // Sembunyikan loading
                    if (loadingEl) {
                        loadingEl.classList.add('hidden');
                    }
                    
                    // Kembalikan opacity preview container
                    if (previewContainer) {
                        previewContainer.style.opacity = '1';
                    }

                    // Tampilkan notifikasi upload berhasil
                    const fileType = isImage ? 'Cover' : 'File E-book';
                    const fileSize = (file.size / (1024 * 1024)).toFixed(2);
                    showNotification(`${fileType} "${file.name}" berhasil dipilih (${fileSize} MB)`, 'success');

                    // Tampilkan Nama File dengan indikator sukses
                    if (filenameEl) {
                        const fileType = isImage ? 'Cover' : 'File';
                        filenameEl.innerHTML = `
                            <div class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-green-600 font-semibold">${fileType}: ${file.name} - Berhasil terupload</span>
                            </div>
                        `;
                        filenameEl.classList.remove('text-gray-500');
                    }
                    // Tampilkan Pratinjau (jika gambar)
                    if (isImage && previewContainer) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            // Hapus pratinjau lama/placeholder
                            previewContainer.innerHTML = ''; 
                            
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.className = 'mx-auto h-32 w-auto object-cover rounded shadow-lg';
                            previewContainer.appendChild(img);

                            // Tambahkan indikator sukses
                            const successIndicator = document.createElement('div');
                            successIndicator.className = 'absolute top-2 right-2 bg-green-500 text-white rounded-full p-1';
                            successIndicator.innerHTML = `
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            `;
                            previewContainer.style.position = 'relative';
                            previewContainer.appendChild(successIndicator);
                        };
                        reader.readAsDataURL(file);
                    }

                    // Tambahkan efek visual pada upload area
                    const uploadArea = fileInput.closest('.border-dashed');
                    if (uploadArea) {
                        uploadArea.classList.add('border-green-500', 'bg-green-50');
                        uploadArea.classList.remove('border-gray-300');
                        
                        // Kembalikan ke normal setelah 3 detik
                        setTimeout(() => {
                            uploadArea.classList.remove('border-green-500', 'bg-green-50');
                            uploadArea.classList.add('border-gray-300');
                        }, 3000);
                    }
                }, 1500); // Loading selama 1.5 detik
            }
        });

        // Drag and drop functionality
        const uploadArea = fileInput.closest('.border-dashed');
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-blue-500', 'bg-blue-50');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
                uploadArea.classList.add('border-gray-300');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
                uploadArea.classList.add('border-gray-300');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            });
        }
    }

    // Inisialisasi untuk Cover Buku
    handleFileUpload('cover_image', 'cover-preview-container', 'cover-filename', true);

    // Inisialisasi untuk File E-book
    handleFileUpload('file_path', null, 'ebook-filename', false);

    // Form submission dengan loading indicator
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Tampilkan loading state
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengupload...
            `;
            submitBtn.disabled = true;

            // Reset button setelah 10 detik (fallback)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 10000);
        });
    }
});
</script>
@endpush

