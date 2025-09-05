
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Glassmorphism effect */
        .glass-nav {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Smooth animations */
        .nav-link {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }
        
        .nav-link:hover::before,
        .nav-link.active::before {
            width: 100%;
        }
        
        .nav-link:hover {
            color: #3b82f6;
            transform: translateY(-1px);
        }
        
        /* Mobile menu improvements */
        #mobile-menu {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top;
            z-index: 50;
        }
        
        /* Force mobile menu button to be visible */
        #mobile-menu-button {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            background: #3b82f6 !important;
            color: white !important;
            border: 2px solid #3b82f6 !important;
            border-radius: 8px !important;
            padding: 10px !important;
            position: relative !important;
            z-index: 1000 !important;
            transition: all 0.2s ease !important;
            min-width: 48px !important;
            min-height: 48px !important;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2) !important;
        }
        
        #mobile-menu-button:hover {
            background: #2563eb !important;
            border-color: #2563eb !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3) !important;
        }
        
        /* Simple hover effect */
        #mobile-menu-button:hover {
            background: #f3f4f6 !important;
            border-color: #d1d5db !important;
        }
        
        /* Override any Tailwind classes that might hide the button */
        .md\\:hidden {
            display: flex !important;
        }
        
        /* Ensure mobile menu container is visible */
        .md\\:hidden#mobile-menu {
            display: block !important;
        }
        
        #mobile-menu.hidden {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px) scale(0.95);
            pointer-events: none;
            max-height: 0;
            overflow: hidden;
        }
        
        #mobile-menu:not(.hidden) {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            pointer-events: auto;
            max-height: calc(100vh - 5rem);
            overflow: visible;
        }
        
        /* Mobile menu button animation */
        .hamburger-line {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }
        
        .hamburger-open .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }
        
        .hamburger-open .hamburger-line:nth-child(2) {
            opacity: 0;
            transform: scale(0);
        }
        
        .hamburger-open .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }
        
        /* Button hover effects */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Profile photo styling */
        .profile-photo {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #3b82f6, #8b5cf6) border-box;
        }
        
        .profile-photo:hover {
            transform: scale(1.1) rotate(3deg);
            box-shadow: 0 10px 25px -3px rgba(59, 130, 246, 0.3);
        }
        
        /* Logo animation */
        .logo-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .logo-icon:hover {
            transform: rotate(5deg) scale(1.1);
            color: #3b82f6;
        }
        
        /* Dropdown menu styling */
        .dropdown-menu {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Mobile menu button animation */
        .hamburger-line {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }
        
        .hamburger-open .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }
        
        .hamburger-open .hamburger-line:nth-child(2) {
            opacity: 0;
            transform: scale(0);
        }
        
        .hamburger-open .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }
        
        /* Notification badge animation */
        @keyframes pulse-ring {
            0% {
                transform: scale(0.33);
            }
            40%, 50% {
                opacity: 0;
            }
            100% {
                opacity: 0;
                transform: scale(1.2);
            }
        }
        
        .notification-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 2px solid #ef4444;
            border-radius: 50%;
            animation: pulse-ring 2s infinite;
        }
        
        /* Mobile menu responsive improvements */
        @media (max-width: 768px) {
            /* Force mobile menu button visibility */
        #mobile-menu-button {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                z-index: 1000 !important;
                position: relative !important;
                background: #3b82f6 !important;
                color: white !important;
                border: 2px solid #3b82f6 !important;
                border-radius: 8px !important;
                padding: 10px !important;
                min-width: 48px !important;
                min-height: 48px !important;
                transition: all 0.2s ease !important;
                box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2) !important;
            }
            
            /* Mobile menu styling */
            #mobile-menu {
                max-height: calc(100vh - 5rem);
                overflow-y: auto;
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 50 !important;
                background: rgba(255, 255, 255, 0.98) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border-top: 1px solid #e5e7eb !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
            }
            
            .mobile-menu-item {
                transition: all 0.2s ease;
            }
            
            .mobile-menu-item:hover {
                background-color: rgba(59, 130, 246, 0.1);
                transform: translateX(4px);
            }
            
            /* Mobile menu button styling */
            .hamburger-line {
                stroke: white !important;
                stroke-width: 2 !important;
            }
            
            /* Ensure mobile navigation is visible */
            .md\\:hidden {
                display: block !important;
            }
            
            /* Override any conflicting styles */
            .md\\:hidden.flex {
                display: flex !important;
            }
            
            /* Hover effect for mobile menu button */
            #mobile-menu-button:hover {
                background: #2563eb !important;
                border-color: #2563eb !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3) !important;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-blue-50 min-h-screen">
    <!-- Navigation -->
    <nav class="glass-nav sticky top-0 z-40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('books.index') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <svg class="h-8 w-8 lg:h-10 lg:w-10 text-blue-600 logo-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        </div>
                        <div>
                            <h1 class="text-xl lg:text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Perpustakaan Digital
                            </h1>
                            <p class="text-xs text-gray-500 hidden lg:block">Modern Library System</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- Navigation Links -->
                    @auth
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('dashboard') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="{{ route('books.my-books') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                            Buku Saya
                        </a>
                            <a href="{{ route('books.index') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                                Katalog
                            </a>
                        </div>
                    @else
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('books.index') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                                Katalog
                            </a>
                        </div>
                    @endauth
                    
                    <!-- Search Bar -->
                    <div class="hidden lg:block">
                        <div class="relative">
                            <input type="text" placeholder="Cari buku..." 
                                   id="desktop-search"
                                   class="w-64 px-4 py-2 pl-10 text-sm border border-gray-200 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/80 backdrop-blur-sm transition-all duration-300">
                            <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- User Section -->
                    @auth
                        <div class="flex items-center space-x-4">
                        <!-- User dropdown -->
                        <div class="relative">
                                <button type="button" class="flex items-center space-x-3 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-full p-1" id="user-menu-button">
                                    @if(auth()->user()->profile_photo)
                                        <div class="profile-photo h-9 w-9 rounded-full overflow-hidden">
                                            <img src="{{ Storage::url(auth()->user()->profile_photo) }}" 
                                                 alt="{{ auth()->user()->name }}" 
                                                 class="h-full w-full object-cover">
                                        </div>
                                    @else
                                        <div class="profile-photo h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                    @endif
                                    <div class="hidden lg:block text-left">
                                        <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                            </button>
                            
                                <div class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg dropdown-menu ring-1 ring-black ring-opacity-5 focus:outline-none z-50" id="user-menu">
                                    <div class="py-2">
                                        <div class="px-4 py-3 border-b border-gray-100">
                                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                            @if(auth()->user()->role === 'admin')
                                                <span class="inline-block mt-1 px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Admin</span>
                                            @endif
                                </div>
                                        <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Profil Saya
                                        </a>
                                        <div class="border-t border-gray-100 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                    </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Mobile Menu Button - ALWAYS VISIBLE -->
                <div class="md:hidden flex items-center space-x-2">
                    <!-- Mobile search button
                    <button class="p-2 text-gray-400 hover:text-gray-500 transition-colors duration-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button> -->
                    
                    <!-- Mobile menu button -->
                    <button type="button" class="p-2 rounded-lg text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all duration-200 border border-gray-200" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="mobile-menu-icon">
                            <path class="hamburger-line" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16"></path>
                            <path class="hamburger-line" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16"></path>
                            <path class="hamburger-line" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div class="hidden md:hidden absolute left-0 right-0 top-full shadow-xl rounded-b-2xl bg-white/98 backdrop-blur-sm border-t border-gray-100" id="mobile-menu">
                <div class="px-4 py-6 space-y-4">
                    <!-- Mobile search -->
                    <div class="relative mb-4">
                        <input type="text" placeholder="Cari buku..." 
                               id="mobile-search"
                               class="w-full px-4 py-3 pl-10 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/90 backdrop-blur-sm">
                        <svg class="absolute left-3 top-3.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <!-- Navigation Links -->
                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 mobile-menu-item">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('books.my-books') }}" class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 mobile-menu-item">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Buku Saya
                        </a>
                        <a href="{{ route('books.index') }}" class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 mobile-menu-item">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Katalog Buku
                        </a>
                    @else
                        <a href="{{ route('books.index') }}" class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 mobile-menu-item">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Katalog Buku
                        </a>
                        <a href="{{ route('login') }}" class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 mobile-menu-item">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 mobile-menu-item">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Register
                        </a>
                    @endauth
                        
                        <!-- Mobile User Info -->
                    @auth
                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <div class="flex items-center px-4 py-3">
                                @if(auth()->user()->profile_photo)
                                    <div class="profile-photo h-10 w-10 rounded-full overflow-hidden">
                                        <img src="{{ Storage::url(auth()->user()->profile_photo) }}" 
                                             alt="{{ auth()->user()->name }}" 
                                             class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <div class="profile-photo h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                @endif
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 rounded-xl text-sm text-gray-700 hover:bg-gray-50 transition-all duration-200 mobile-menu-item">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-3 rounded-xl text-sm text-red-600 hover:bg-red-50 transition-all duration-200 mobile-menu-item">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Perpustakaan Digital. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const desktopSearch = document.getElementById('desktop-search');
            const mobileSearch = document.getElementById('mobile-search');
            
            function performSearch(query) {
                if (query.trim() === '') return;
                
                // Redirect to books index with search query
                const searchUrl = `{{ route('books.index') }}?search=${encodeURIComponent(query.trim())}`;
                window.location.href = searchUrl;
            }
            
            // Desktop search
            if (desktopSearch) {
                desktopSearch.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        performSearch(this.value);
                    }
                });
            }
            
            // Mobile search
            if (mobileSearch) {
                mobileSearch.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        performSearch(this.value);
                    }
                });
            }
            
            // User dropdown toggle - Only for authenticated users
            const userMenuButton = document.getElementById('user-menu-button');
            if (userMenuButton) {
                userMenuButton.addEventListener('click', function() {
                    const menu = document.getElementById('user-menu');
                    if (menu) {
                        menu.classList.toggle('hidden');
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    const button = document.getElementById('user-menu-button');
                    const menu = document.getElementById('user-menu');
                    
                    if (button && menu && !button.contains(event.target) && !menu.contains(event.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }

            // Mobile menu toggle - Available for all users
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuIcon = document.getElementById('mobile-menu-icon');
            
            console.log('Checking mobile menu elements...');
            console.log('mobileMenuButton:', mobileMenuButton);
            console.log('mobileMenu:', mobileMenu);
            console.log('mobileMenuIcon:', mobileMenuIcon);
            
            if (mobileMenuButton && mobileMenu && mobileMenuIcon) {
                console.log('✅ Mobile menu elements found:', { mobileMenuButton, mobileMenu, mobileMenuIcon });
                
                // Mobile menu toggle
                mobileMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('🎯 Mobile menu button clicked');
                    const isHidden = mobileMenu.classList.contains('hidden');
                    
                    if (isHidden) {
                        // Smooth open animation
                        mobileMenu.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                        mobileMenu.classList.remove('hidden');
                        mobileMenuButton.classList.add('hamburger-open');
                        mobileMenuButton.setAttribute('aria-expanded', 'true');
                        console.log('✅ Mobile menu opened');
                    } else {
                        // Smooth close animation
                        mobileMenu.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.classList.remove('hamburger-open');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                        console.log('❌ Mobile menu closed');
                    }
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.classList.remove('hamburger-open');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });

                // Close mobile menu on window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 768) { // md breakpoint
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.classList.remove('hamburger-open');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });

                // Close mobile menu on escape key
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.classList.remove('hamburger-open');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });

                // Prevent menu from closing when clicking inside
                mobileMenu.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            } else {
                console.log('❌ Mobile menu elements not found:', { 
                    mobileMenuButton: !!mobileMenuButton, 
                    mobileMenu: !!mobileMenu, 
                    mobileMenuIcon: !!mobileMenuIcon 
                });
                
                // Try to find elements again after a short delay
                setTimeout(() => {
                    const retryMobileMenuButton = document.getElementById('mobile-menu-button');
                    const retryMobileMenu = document.getElementById('mobile-menu');
                    const retryMobileMenuIcon = document.getElementById('mobile-menu-icon');
                    
                    console.log('🔄 Retry finding mobile menu elements:', {
                        mobileMenuButton: !!retryMobileMenuButton,
                        mobileMenu: !!retryMobileMenu,
                        mobileMenuIcon: !!retryMobileMenuIcon
                    });
                }, 1000);
            }
        });
    </script>

</body>
</html>
