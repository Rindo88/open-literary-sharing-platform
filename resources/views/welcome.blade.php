@extends('layouts.app')

@section('title', 'Platform Berbagi Buku & Cerpen — Terbuka untuk Semua')

@push('meta')
    <meta name="description" content="Platform berbagi buku & cerpen terbuka untuk semua orang. Unggah, bagikan, dan temukan karya tanpa batas.">
    <meta name="keywords" content="berbagi buku, cerpen, platform karya, e-book, literasi, komunitas penulis, katalog buku">
    <meta name="author" content="Platform Berbagi Buku & Cerpen">
    <link rel="canonical" href="{{ url('/') }}">
    <meta property="og:title" content="Platform Berbagi Buku & Cerpen">
    <meta property="og:description" content="Bagikan karya Anda dan jelajahi koleksi komunitas.">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="preload" as="image" href="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80">
@endpush

@push('navbar_links')
    <a href="{{ route('landing') }}#bagikan" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Bagikan Karya</a>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="relative min-h-[560px] sm:min-h-[640px]">
            <!-- Background Image -->
            <img
                src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80"
                srcset="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80 800w, https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80 1200w, https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80 1600w"
                sizes="(max-width: 640px) 640px, (max-width: 1024px) 1024px, 1600px"
                alt="Ilustrasi perpustakaan digital modern"
                class="absolute inset-0 w-full h-full object-cover"
                decoding="async"
                fetchpriority="high"
            />

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-blue-700/70 to-green-700/60"></div>

            <!-- Content -->
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-28">
                <div class="max-w-3xl">
                    <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white">
                        Berbagi Buku & Cerpen Terbuka untuk Semua
                    </h2>
                    <p class="mt-5 text-base sm:text-lg text-blue-100 max-w-2xl">
                        Unggah karya Anda — buku, cerpen, atau tulisan lainnya — dan bagi ke komunitas.
                        Siapa pun bisa berkarya di sini, tanpa pandang terkenal atau bukan.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="#bagikan"
                           class="btn-primary inline-flex items-center justify-center px-6 py-3 rounded-lg text-white text-sm sm:text-base">
                            Bagikan Karya
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M5 7h8"></path>
                            </svg>
                        </a>
                        <a href="{{ route('home.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-lg border border-white/30 text-white/90 hover:bg-white/10 text-sm sm:text-base">
                            Jelajahi Koleksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="text-center">
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900">Fitur Utama</h3>
                <p class="mt-3 text-gray-600">Dirancang modern dengan pengalaman membaca yang cepat dan menyenangkan</p>
            </div>

            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Fitur 1 -->
                <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
                    <div class="h-12 w-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m0-12C9.5 5 7 5 5 6v12c2-1 4.5-1 7-0m0-12c2.5-1 5-1 7 0v12c-2-1-4.5-1-7-0"/>
                        </svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Akses Bebas</h4>
                    <p class="mt-2 text-sm text-gray-600">Buka koleksi tanpa batas, tanpa hambatan perangkat dan lokasi.</p>
                </div>

                <!-- Fitur 2 -->
                <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
                    <div class="h-12 w-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                        </svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Katalog Kaya</h4>
                    <p class="mt-2 text-sm text-gray-600">E-book, jurnal, dan referensi kurasi dari berbagai bidang.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
                    <div class="h-12 w-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A2 2 0 0122 9.553V14.5a2 2 0 01-1.053 1.764L15 18V10zM3 7h12v10H3a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Baca di Mana Saja</h4>
                    <p class="mt-2 text-sm text-gray-600">Optimasi untuk mobile, tablet, dan desktop dengan performa.</p>
                </div>

                <!-- Fitur 4 -->
                <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
                    <div class="h-12 w-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Rekomendasi Pintar</h4>
                    <p class="mt-2 text-sm text-gray-600">Temukan bacaan relevan berbasis minat dan riwayat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Share Your Work Section -->
    <section id="bagikan" class="bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="text-center mb-10">
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900">Bagikan Karyamu</h3>
                <p class="mt-3 text-gray-600">Buku, cerpen, atau tulisan — publik bisa ikut berkarya tanpa batas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-xl border bg-white p-6 shadow-sm">
                    <div class="h-12 w-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Siapkan Naskah</h4>
                    <p class="mt-2 text-sm text-gray-600">Susun karya Anda (PDF/teks). Tambahkan cover dan ringkasan.</p>
                </div>
                <div class="rounded-xl border bg-white p-6 shadow-sm">
                    <div class="h-12 w-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Unggah & Atur</h4>
                    <p class="mt-2 text-sm text-gray-600">Pilih kategori, tag, dan lisensi (bebas/terbatas). Sistem akan kami siapkan.</p>
                </div>
                <div class="rounded-xl border bg-white p-6 shadow-sm">
                    <div class="h-12 w-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A2 2 0 0122 9.553V14.5a2 2 0 01-1.053 1.764L15 18V10zM3 7h12v10H3a2 2 0 01-2-2V9a2 2 0 012-2z"/></svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Publikasikan</h4>
                    <p class="mt-2 text-sm text-gray-600">Karya akan tampil di katalog komunitas. Siap dibaca dan didiskusikan.</p>
                </div>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#" class="btn-primary inline-flex items-center justify-center px-6 py-3 rounded-lg text-white text-sm sm:text-base disabled:opacity-70"
                   aria-disabled="true"
                   title="Fitur unggah akan segera hadir">
                    Mulai Bagikan Karya (Coming Soon)
                </a>
                <a href="{{ route('home.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50 text-sm sm:text-base">
                    Lihat Karya Komunitas
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials / Partners -->
    <section class="bg-gradient-to-br from-blue-50 to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="rounded-xl bg-white p-6 border">
                    <h5 class="text-lg font-semibold text-gray-900">Testimonial</h5>
                    <div class="mt-4 space-y-4">
                        <div>
                            <div class="flex items-center gap-2 text-yellow-500">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.294a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.294c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.176 0l-2.802 2.034c-.785.57-1.84-.197-1.54-1.118l1.07-3.294a1 1 0 00-.364-1.118L3.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.294z"/></svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.294a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.294c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.176 0l-2.802 2.034c-.785.57-1.84-.197-1.54-1.118l1.07-3.294a1 1 0 00-.364-1.118L3.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.294z"/></svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.294a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.294c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.176 0l-2.802 2.034c-.785.57-1.84-.197-1.54-1.118l1.07-3.294a1 1 0 00-.364-1.118L3.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.294z"/></svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.294a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.294c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.176 0l-2.802 2.034c-.785.57-1.84-.197-1.54-1.118l1.07-3.294a1 1 0 00-.364-1.118L3.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.294z"/></svg>
                            </div>
                            <p class="mt-3 text-gray-700">“Koleksi lengkap dan akses cepat. Platform yang mengubah cara saya membaca.”</p>
                            <p class="mt-1 text-sm text-gray-500">— Dosen & Peneliti</p>
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-gray-700">“UI-nya bersih, futuristik, dan sangat mudah digunakan.”</p>
                            <p class="mt-1 text-sm text-gray-500">— Mahasiswa Teknik</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-xl bg-white p-6 border">
                    <h5 class="text-lg font-semibold text-gray-900">Partner Institusi</h5>
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="h-16 rounded-lg border flex items-center justify-center text-gray-600">Universitas</div>
                        <div class="h-16 rounded-lg border flex items-center justify-center text-gray-600">Lembaga Riset</div>
                        <div class="h-16 rounded-lg border flex items-center justify-center text-gray-600">Penerbit</div>
                        <div class="h-16 rounded-lg border flex items-center justify-center text-gray-600">Komunitas</div>
                        <div class="h-16 rounded-lg border flex items-center justify-center text-gray-600">Arsip</div>
                        <div class="h-16 rounded-lg border flex items-center justify-center text-gray-600">Perpustakaan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="rounded-2xl bg-gradient-to-r from-blue-600 to-green-600 p-8 sm:p-12 text-white">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                    <div>
                        <h4 class="text-2xl font-bold">Siap menjelajah koleksi digital?</h4>
                        <p class="mt-2 text-blue-100">Temukan buku favorit dan mulai membaca sekarang.</p>
                    </div>
                    <a href="{{ route('home.index') }}" class="btn-primary px-6 py-3 rounded-lg text-white">
                        Explore Koleksi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Categories Section -->
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900">Kategori Populer</h3>
                    <p class="mt-2 text-gray-600">Topik yang paling sering dibaca minggu ini</p>
                </div>
                <a href="{{ route('home.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat semua</a>
            </div>
            <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @if(isset($categories) && count($categories))
                    @foreach ($categories->take(6) as $category)
                        <a href="{{ route('home.index', ['category' => $category->id]) }}" class="group rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                            <div class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M5 7h14"/>
                                </svg>
                            </div>
                            <p class="mt-3 text-sm font-semibold text-gray-900 group-hover:text-blue-700">{{ $category->name }}</p>
                        </a>
                    @endforeach
                @else
                    @foreach (["Teknologi","Bisnis","Sains","Sastra","Sejarah","Psikologi"] as $name)
                        <div class="rounded-xl border bg-white p-4 shadow-sm">
                            <div class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M5 7h14"/>
                                </svg>
                            </div>
                            <p class="mt-3 text-sm font-semibold text-gray-900">{{ $name }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Stats / Impact Section -->
    <section class="bg-gradient-to-r from-blue-50 to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="rounded-2xl bg-white border p-8 sm:p-12">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ isset($books) && method_exists($books,'total') ? number_format($books->total()) : '10K+' }}</p>
                        <p class="mt-1 text-sm text-gray-600">Koleksi Buku</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900">120+</p>
                        <p class="mt-1 text-sm text-gray-600">Kategori</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900">500K+</p>
                        <p class="mt-1 text-sm text-gray-600">Pembaca</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900">4.8/5</p>
                        <p class="mt-1 text-sm text-gray-600">Rating Rata-rata</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="text-center">
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900">Cara Kerja</h3>
                <p class="mt-3 text-gray-600">Tiga langkah sederhana mulai membaca</p>
            </div>
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="rounded-xl border bg-white p-6">
                    <div class="h-12 w-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Jelajahi</h4>
                    <p class="mt-2 text-sm text-gray-600">Gunakan pencarian dan filter untuk temukan buku.</p>
                </div>
                <div class="rounded-xl border bg-white p-6">
                    <div class="h-12 w-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-6-4h12"/></svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Koleksi</h4>
                    <p class="mt-2 text-sm text-gray-600">Tambahkan ke wishlist atau mulai membaca langsung.</p>
                </div>
                <div class="rounded-xl border bg-white p-6">
                    <div class="h-12 w-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900">Nikmati</h4>
                    <p class="mt-2 text-sm text-gray-600">Baca nyaman di perangkat favorit Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="max-w-3xl mx-auto">
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center">Pertanyaan Umum</h3>
                <div class="mt-8 space-y-6">
                    <details class="rounded-xl bg-white border p-4">
                        <summary class="font-semibold text-gray-900 cursor-pointer">Apakah aksesnya gratis?</summary>
                        <p class="mt-3 text-gray-600">Sebagian besar koleksi tersedia gratis; beberapa materi premium membutuhkan akses khusus.</p>
                    </details>
                    <details class="rounded-xl bg-white border p-4">
                        <summary class="font-semibold text-gray-900 cursor-pointer">Bagaimana cara mengunduh e-book?</summary>
                        <p class="mt-3 text-gray-600">Buka detail buku lalu pilih tombol unduh jika tersedia sesuai lisensi.</p>
                    </details>
                    <details class="rounded-xl bg-white border p-4">
                        <summary class="font-semibold text-gray-900 cursor-pointer">Apakah ada aplikasi mobile?</summary>
                        <p class="mt-3 text-gray-600">Versi web dioptimasi untuk perangkat mobile; aplikasi native dalam pengembangan.</p>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="rounded-2xl bg-gradient-to-r from-blue-600 to-purple-600 p-8 sm:p-12 text-white">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                    <div>
                        <h4 class="text-2xl font-bold">Dapatkan update koleksi & event terbaru</h4>
                        <p class="mt-2 text-blue-100">Masukkan email Anda untuk berlangganan newsletter.</p>
                    </div>
                    <form class="flex flex-col sm:flex-row gap-3">
                        <input type="email" placeholder="Email Anda" class="flex-1 px-4 py-3 rounded-lg text-gray-900" required>
                        <button type="submit" class="btn-primary px-6 py-3 rounded-lg">Berlangganan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- About & Contact -->
    <section id="tentang" class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div>
                    <h5 class="text-xl font-semibold text-gray-900">Tentang Kami</h5>
                    <p class="mt-3 text-gray-600">Kami membangun ekosistem literasi digital yang terbuka, inklusif, dan berkelanjutan. Fokus kami adalah menghadirkan akses ilmu pengetahuan untuk semua.</p>
                    <p class="mt-3 text-gray-600">Platform ini terus berkembang dengan dukungan komunitas, institusi pendidikan, dan penerbit.</p>
                </div>
                <div id="kontak">
                    <h5 class="text-xl font-semibold text-gray-900">Kontak</h5>
                    <p class="mt-3 text-gray-600">Butuh bantuan atau ingin berkolaborasi? Hubungi kami.</p>
                    <div class="mt-4 flex gap-3">
                        <a href="mailto:info@perpustakaan.digital" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Email</a>
                        <a href="https://facebook.com/" target="_blank" rel="noopener" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Facebook</a>
                        <a href="https://twitter.com/" target="_blank" rel="noopener" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Twitter</a>
                        <a href="https://instagram.com/" target="_blank" rel="noopener" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Instagram</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
