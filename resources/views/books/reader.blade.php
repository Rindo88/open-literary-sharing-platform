@extends('layouts.app')

@section('title', 'Baca ' . $book->title)

@section('content')
<!-- Alpine.js for dropdown functionality -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';</script>

<style>
    /* Custom breakpoint for extra small devices */
    @media (min-width: 475px) {
        .xs\:inline { display: inline !important; }
        .xs\:hidden { display: none !important; }
    }
    
    /* Modern Dark Mode Variables */
    :root {
        /* Light mode colors */
        --bg-light: #f8fafc;
        --bg-light-secondary: #ffffff;
        --text-light: #1e293b;
        --text-light-secondary: #64748b;
        --border-light: #e2e8f0;
        --shadow-light: rgba(0, 0, 0, 0.1);
        
        /* Dark mode colors */
        --bg-dark: #0f172a;
        --bg-dark-secondary: #1e293b;
        --bg-dark-tertiary: #334155;
        --text-dark: #f1f5f9;
        --text-dark-secondary: #cbd5e1;
        --border-dark: #334155;
        --shadow-dark: rgba(0, 0, 0, 0.3);
        
        /* PDF specific colors */
        --pdf-bg-light: #ffffff;
        --pdf-bg-dark: #1e293b;
        --pdf-controls-bg-light: rgba(255, 255, 255, 0.95);
        --pdf-controls-bg-dark: rgba(15, 23, 42, 0.95);
        
        /* Transition settings */
        --transition-fast: 0.15s ease-in-out;
        --transition-normal: 0.3s ease-in-out;
        --transition-slow: 0.5s ease-in-out;
    }
    
    /* Dark mode base styles */
    .dark-mode {
        background-color: var(--bg-dark) !important;
        color: var(--text-dark) !iportant;
        transition: background-color var(--transition-normal), color var(--transition-normal);
    }
    
    .dark-mode .bg-white {
        background-color: var(--bg-dark-secondary) !important;
        border-color: var(--border-dark) !important;
        transition: background-color var(--transition-normal), border-color var(--transition-normal);
    }
    
    .dark-mode .text-gray-900 {
        color: var(--text-dark) !important;
    }
    
    .dark-mode .text-gray-600 {
        color: var(--text-dark-secondary) !important;
    }
    
    .dark-mode .text-gray-700 {
        color: var(--text-dark) !important;
    }
    
    .dark-mode .border-gray-200 {
        border-color: var(--border-dark) !important;
    }
    
    .dark-mode .border-gray-300 {
        border-color: var(--border-dark) !important;
    }
    
    /* PDF Container Dark Mode */
    .dark-mode #pdfContainer {
        background-color: var(--bg-dark) !important;
        transition: background-color var(--transition-normal);
    }
    
    /* PDF Canvas Dark Mode with improved rendering */
    .dark-mode #pdfCanvas {
        background-color: var(--pdf-bg-dark) !important;
        filter: invert(0.95) hue-rotate(180deg) contrast(1.1);
        transition: filter var(--transition-normal);
        box-shadow: 0 4px 20px var(--shadow-dark);
    }
    
    /* PDF Controls Dark Mode */
    .dark-mode .pdf-controls {
        background: var(--pdf-controls-bg-dark) !important;
        border-color: var(--border-dark) !important;
        color: var(--text-dark) !important;
        backdrop-filter: blur(12px);
        transition: all var(--transition-normal);
    }
    
    /* Form elements dark mode */
    .dark-mode .page-input {
        background-color: var(--bg-dark-tertiary) !important;
        border-color: var(--border-dark) !important;
        color: var(--text-dark) !important;
        transition: all var(--transition-fast);
    }
    
    .dark-mode .page-input:focus {
        background-color: var(--bg-dark-secondary) !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Button dark mode */
    .dark-mode button {
        background-color: var(--bg-dark-tertiary) !important;
        border-color: var(--border-dark) !important;
        color: var(--text-dark) !important;
        transition: all var(--transition-fast);
    }
    
    .dark-mode button:hover:not(:disabled) {
        background-color: var(--bg-dark-secondary) !important;
        border-color: #64748b !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px var(--shadow-dark);
    }
    
    .dark-mode button:active {
        transform: translateY(0);
    }
    
    .dark-mode button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Progress bar dark mode */
    .dark-mode .bg-gray-200 {
        background-color: var(--bg-dark-tertiary) !important;
    }
    
    .dark-mode .bg-blue-600 {
        background-color: #3b82f6 !important;
    }
    
    /* Discussion dropdown dark mode */
    .dark-mode .discussion-dropdown {
        background-color: var(--bg-dark-secondary) !important;
        border-color: var(--border-dark) !important;
        box-shadow: 0 10px 25px var(--shadow-dark);
    }
    
    .dark-mode .discussion-dropdown a {
z        color: var(--text-dark) !important;
    }
    
    .dark-mode .discussion-dropdown a:hover {
        background-color: var(--bg-dark-tertiary) !important;
    }
    
    .dark-mode .discussion-dropdown .text-gray-500 {
        color: var(--text-dark-secondary) !important;
    }
    
    .dark-mode .discussion-dropdown .text-gray-400 {
        color: #94a3b8 !important;
    }
    
    /* Blue accent elements dark mode */
    .dark-mode .bg-blue-50 {
        background-color: rgba(59, 130, 246, 0.1) !important;
    }
    
    .dark-mode .border-blue-200 {
        border-color: rgba(59, 130, 246, 0.3) !important;
    }
    
    .dark-mode .bg-blue-100 {
        background-color: rgba(59, 130, 246, 0.2) !important;
    }
    
    .dark-mode .text-blue-700 {
        color: #60a5fa !important;
    }
    
    /* Responsive height adjustments */
    @media (max-width: 768px) {
        #pdfContainer { height: calc(100vh - 15rem); }
    }
    @media (min-width: 768px) {
        #pdfContainer { height: calc(100vh - 12rem); }
    }
    
    /* PDF Viewer Styles */
    #pdfContainer {
        position: relative;
        width: 100%;
        overflow: auto;
        background: var(--bg-light);
        transition: all 0.3s ease;
    }
    
    /* Fullscreen PDF container */
    :fullscreen #pdfContainer,
    :-webkit-full-screen #pdfContainer,
    :-moz-full-screen #pdfContainer,
    :-ms-fullscreen #pdfContainer {
        width: 100vw !important;
        height: calc(100vh - 80px) !important;
        margin: 0 !important;
        padding: 0 !important;
        background: #f1f5f9 !important;
    }
    
    #pdfCanvas {
        display: block;
        margin: 1rem auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        background: var(--canvas-bg-light);
        transition: all 0.3s ease;
        max-width: calc(100% - 2rem);
    }
    
    /* Fullscreen canvas optimization */
    :fullscreen #pdfCanvas,
    :-webkit-full-screen #pdfCanvas,
    :-moz-full-screen #pdfCanvas,
    :-ms-fullscreen #pdfCanvas {
        margin: 0.5rem auto !important;
        max-width: 100% !important;
        max-height: calc(100vh - 100px) !important;
        object-fit: contain !important;
    }
    
    .pdf-controls {
        position: sticky;
        top: 0;
        z-index: 10;
        background: var(--controls-bg-light);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid var(--border-light);
        transition: all 0.3s ease;
    }
    
    /* Fullscreen controls - Fixed at bottom */
    :fullscreen .pdf-controls,
    :-webkit-full-screen .pdf-controls,
    :-moz-full-screen .pdf-controls,
    :-ms-fullscreen .pdf-controls {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        top: auto !important;
        z-index: 9999 !important;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px) !important;
        border-top: 1px solid #e5e7eb !important;
        border-bottom: none !important;
        margin: 0 !important;
        padding: 0.75rem !important;
    }
    
    /* Dark mode fullscreen controls */
    .dark-mode:fullscreen .pdf-controls,
    .dark-mode:-webkit-full-screen .pdf-controls,
    .dark-mode:-moz-full-screen .pdf-controls,
    .dark-mode:-ms-fullscreen .pdf-controls {
        background: rgba(30,41,59,0.95) !important;
        border-top-color: #475569 !important;
    }
    
    .page-navigation {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .page-input {
        width: 60px;
        text-align: center;
        border: 1px solid var(--border-light);
        border-radius: 0.375rem;
        padding: 0.25rem;
        font-size: 0.875rem;
        background-color: white;
        transition: all 0.3s ease;
    }
    
    .loading-spinner {
        display: inline-block;
        width: 40px;
        height: 40px;
        border: 4px solid #e5e7eb;
        border-top: 4px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .error-message {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 1rem;
        border-radius: 0.5rem;
        text-align: center;
        margin: 2rem auto;
        max-width: 500px;
    }
    
    /* Hide header and other elements in fullscreen mode */
    :fullscreen .bg-white.shadow-sm.border-b.sticky.top-0.z-20,
    :-webkit-full-screen .bg-white.shadow-sm.border-b.sticky.top-0.z-20,
    :-moz-full-screen .bg-white.shadow-sm.border-b.sticky.top-0.z-20,
    :-ms-fullscreen .bg-white.shadow-sm.border-b.sticky.top-0.z-20,
    :fullscreen .max-w-7xl.mx-auto.px-3.sm\\:px-4.md\\:px-6.lg\\:px-8.pb-3.sm\\:pb-4.md\\:pb-6,
    :-webkit-full-screen .max-w-7xl.mx-auto.px-3.sm\\:px-4.md\\:px-6.lg\\:px-8.pb-3.sm\\:pb-4.md\\:pb-6,
    :-moz-full-screen .max-w-7xl.mx-auto.px-3.sm\\:px-4.md\\:px-6.lg\\:px-8.pb-3.sm\\:pb-4.md\\:pb-6,
    :-ms-fullscreen .max-w-7xl.mx-auto.px-3.sm\\:px-4.md\\:px-6.lg\\:px-8.pb-3.sm\\:pb-4.md\\:pb-6 {
        display: none !important;
    }
    
    /* Optimize PDF container and controls in fullscreen */
    :fullscreen #pdfContainer,
    :-webkit-full-screen #pdfContainer,
    :-moz-full-screen #pdfContainer,
    :-ms-fullscreen #pdfContainer {
        height: calc(100vh - 80px) !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Show only PDF controls in fullscreen */
    :fullscreen .pdf-controls,
    :-webkit-full-screen .pdf-controls,
    :-moz-full-screen .pdf-controls,
    :-ms-fullscreen .pdf-controls {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 9999 !important;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px) !important;
        border-top: 1px solid #e5e7eb !important;
        border-bottom: none !important;
        margin: 0 !important;
        padding: 0.75rem !important;
    }
    
    /* Fullscreen body styling */
    :fullscreen body,
    :-webkit-full-screen body,
    :-moz-full-screen body,
    :-ms-fullscreen body {
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }
    
    /* Dark mode toggle button */
    .dark-mode-toggle {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .dark-mode-toggle:hover {
        background-color: #e5e7eb;
    }
    
    .dark-mode .dark-mode-toggle {
        background-color: #4b5563;
        border-color: #6b7280;
        color: #f9fafb;
    }
    
    .dark-mode .dark-mode-toggle:hover {
        background-color: #374151;
    }
    
    /* Fullscreen optimizations */
    :fullscreen {
        background: #f1f5f9;
    }
    
    :-webkit-full-screen {
        background: #f1f5f9;
    }
    
    :-moz-full-screen {
        background: #f1f5f9;
    }
    
    :-ms-fullscreen {
        background: #f1f5f9;
    }
    
    /* Discussion menu styles */
    .discussion-dropdown {
        z-index: 1000;
    }
    
    @media (max-width: 640px) {
        .discussion-dropdown {
            right: 0;
            left: auto;
            width: 200px;
        }
    }
    
    /* Ensure dropdown is above PDF controls */
    .discussion-dropdown {
        z-index: 1001;
    }
</style>

<div class="min-h-screen bg-gray-50" id="mainContent">
    <div class="bg-white shadow-sm border-b sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 sm:py-4 space-y-3 sm:space-y-0">
                <div class="flex items-center space-x-2 sm:space-x-4 w-full sm:w-auto">
                    <a href="{{ route('books.show', ['type' => 'book', 'id' => $book->id]) }}" class="text-gray-600 hover:text-gray-900 flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-lg sm:text-xl font-semibold text-gray-900 truncate">{{ $book->title }}</h1>
                        <p class="text-xs sm:text-sm text-gray-600 truncate">oleh {{ $book->author->pen_name }}</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3 lg:space-x-4 w-full sm:w-auto">
                    <div class="flex flex-col sm:flex-row items-center space-y-1 sm:space-y-0 sm:space-x-3">
                        <div class="text-xs sm:text-sm text-gray-600 text-center sm:text-left">
                            <span id="currentPage">1</span> dari <span id="totalPages">{{ $book->pages ?? '?' }}</span>
                        </div>
                        <div class="w-24 sm:w-32 bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-center sm:justify-end space-x-2 sm:space-x-3">
                        <!-- Discussion Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center px-2 sm:px-3 py-2 border border-gray-300 text-xs sm:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span class="hidden xs:inline">Diskusi</span>
                                <span class="xs:hidden">💬</span>
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1 sm:ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Discussion Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg border border-gray-200 discussion-dropdown">
                                <div class="py-1">
                                    <a href="{{ route('discussions.show', $book) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                        </svg>
                                        Masuk Diskusi
                                    </a>
                                    <a href="{{ route('discussions.create', $book) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                                        Mulai Diskusi Baru
                                    </a>
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <div class="px-4 py-2 text-xs text-gray-500">
                                        <p class="font-medium">Diskusi Aktif</p>
                                        <p class="text-gray-400">Bergabung dengan komunitas pembaca</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dark Mode Toggle -->
                        <button id="darkModeToggle" class="dark-mode-toggle" title="Toggle Dark Mode">
                            <svg id="sunIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <svg id="moonIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </button>
                        
                        <form action="{{ route('books.finish-reading', $book->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-2 sm:px-3 py-2 border border-transparent text-xs sm:text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="hidden xs:inline">Selesai Baca</span>
                                <span class="xs:hidden">Selesai</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages - Modern Popup Notification -->
    @if(session('success') || session('error'))
        <div id="notification-popup" class="fixed top-6 right-6 z-[9999] max-w-sm w-full sm:max-w-md transform transition-all duration-500 ease-in-out translate-x-full opacity-0">
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl shadow-2xl border border-green-400 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-semibold text-white">Berhasil!</h3>
                                <p class="text-sm text-green-100 mt-1">{{ session('success') }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <button onclick="closeNotification()" class="inline-flex text-green-200 hover:text-white focus:outline-none focus:text-white transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-400 h-1 w-full"></div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl shadow-2xl border border-red-400 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-400 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-semibold text-white">Error!</h3>
                                <p class="text-sm text-red-100 mt-1">{{ session('error') }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <button onclick="closeNotification()" class="inline-flex text-red-200 hover:text-white focus:outline-none focus:text-white transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-red-400 h-1 w-full"></div>
                </div>
            @endif
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-3 sm:py-4 md:py-6">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if($book->file_path)
                @php
                    $extension = pathinfo($book->file_path, PATHINFO_EXTENSION);
                    $isPdf = strtolower($extension) === 'pdf';
                    $isEpub = strtolower($extension) === 'epub';
                @endphp
                
                @if($isPdf)
                    <div class="relative" id="pdfViewerContainer">
                        <div id="pdfContainer">
                            <div id="pdfLoading" class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <div class="loading-spinner mx-auto mb-4"></div>
                                    <p class="text-gray-600">Memuat PDF, mohon tunggu...</p>
                                </div>
                            </div>
                            <canvas id="pdfCanvas" class="hidden"></canvas>
                            <div id="pdfError" class="error-message hidden">
                                <h3 class="text-lg font-medium mb-2">Gagal Memuat PDF</h3>
                                <p class="text-sm mb-4">File mungkin rusak atau tidak dapat diakses. Silakan coba lagi atau download file.</p>
                                <button id="retryLoad" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">Coba Lagi</button>
                            </div>
                                </div>
                                
                        <!-- PDF Controls -->
                        <div class="pdf-controls p-3 sm:p-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                                <div class="hidden lg:flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-2h2v2h-2zm0-4V7h2v6h-2z"></path></svg>
                                    <span class="text-sm font-medium text-gray-700">Adobe PDF Reader</span>
                                    </div>
                                    
                                <div class="page-navigation w-full justify-center">
                                    <button id="prevPage" title="Halaman Sebelumnya (←)" class="p-2 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    </button>
                                    
                                    <input type="number" id="pageInput" class="page-input" min="1" value="1">
                                    <span class="text-sm text-gray-600">dari <span id="pdfTotalPages">-</span></span>
                                    
                                    <button id="nextPage" title="Halaman Selanjutnya (→)" class="p-2 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                    
                                    <div class="w-px h-6 bg-gray-300 mx-2 hidden sm:block"></div>
                                    
                                    <button id="zoomOut" title="Perkecil (-)" class="p-2 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path></svg>
                                    </button>
                                    <span id="zoomLevel" class="text-sm text-gray-600 px-1 tabular-nums">100%</span>
                                    <button id="zoomIn" title="Perbesar (+)" class="p-2 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                                    </button>
                                    
                                    <div class="w-px h-6 bg-gray-300 mx-2 hidden sm:block"></div>

                                    <button id="fullscreenBtn" title="Layar Penuh (F11)" class="p-2 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                @elseif($isEpub)
                    <!-- <div class="text-center py-12 px-4 sm:px-6 lg:px-8">
                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">Format EPUB</h3>
                        <p class="mt-2 text-base text-gray-500">
                            File EPUB tidak dapat ditampilkan langsung di browser.<br>
                            Silakan download file untuk membacanya dengan aplikasi EPUB reader favorit Anda.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('books.download', $book->slug) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Download EPUB
                                        </a>
                                    </div>
                    </div> -->
                @else
                    <!-- <div class="text-center py-12 px-4 sm:px-6 lg:px-8">
                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">Format File Tidak Didukung</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Format file <strong>.{{ strtoupper($extension) }}</strong> tidak dapat ditampilkan. Silakan download untuk membukanya.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('books.download', $book->slug) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Download File
                            </a>
                        </div>
                    </div> -->
                @endif
            @else
                <div class="text-center py-12 px-4 sm:px-6 lg:px-8">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mt-4 text-xl font-medium text-gray-900">File Tidak Tersedia</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Maaf, file e-book untuk buku ini belum diunggah atau tidak tersedia.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 pb-3 sm:pb-4 md:pb-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Informasi Sesi Membaca -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-4 md:p-6">
            <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-3 sm:mb-4">Informasi Sesi Membaca</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                <div class="text-center sm:text-left">
                    <p class="text-xs sm:text-sm text-gray-600">Mulai membaca</p>
                    <p class="text-xs sm:text-sm font-medium text-gray-900">
                            {{ $readingSession->started_at ? $readingSession->started_at->format('d M Y, H:i') : '-' }}
                    </p>
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-xs sm:text-sm text-gray-600">Terakhir dibaca</p>
                    <p class="text-xs sm:text-sm font-medium text-gray-900">
                            {{ $readingSession->last_read_at ? $readingSession->last_read_at->format('d M Y, H:i') : '-' }}
                    </p>
                </div>
                    <div class="text-center sm:text-left">
                        <p class="text-xs sm:text-sm text-gray-600">Halaman terakhir</p>
                        <p class="text-xs sm:text-sm font-medium text-gray-900" id="lastPageInfo">{{ $readingSession->current_page ?? 1 }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Diskusi Buku -->
            <div class="bg-white rounded-lg shadow p-3 sm:p-4 md:p-6">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900">Diskusi Buku</h3>
                    <a href="{{ route('discussions.index', $book) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                        Lihat Semua →
                    </a>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Bergabung dengan Diskusi</p>
                                <p class="text-xs text-gray-600">Bagikan pemikiran dan diskusikan buku ini</p>
                            </div>
                        </div>
                        <a href="{{ route('discussions.create', $book) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors">
                            Mulai
                        </a>
                    </div>

                    @if(isset($discussions) && $discussions->count() > 0)
                        <div class="space-y-2">
                            @foreach($discussions as $discussion)
                                <a href="{{ route('discussions.show', [$book, $discussion]) }}" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $discussion->title }}</p>
                                            <p class="text-xs text-gray-600">Status: {{ ucfirst($discussion->status) }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            @if($discussion->last_activity_at)
                                                Terakhir: {{ $discussion->last_activity_at->diffForHumans() }}
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-sm text-gray-600 mb-3">Belum ada diskusi untuk buku ini</p>
                            <a href="{{ route('discussions.create', $book) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Diskusi Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



<form id="progressForm" action="{{ route('books.update-progress', $book->slug) }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="current_page" id="progressCurrentPage" value="{{ $readingSession->current_page ?? 1 }}">
    <input type="hidden" name="total_pages" id="progressTotalPages" value="{{ $book->pages ?? 1 }}">
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Check if the book is a PDF
    const isPdf = @json($isPdf ?? false);
    if (!isPdf) {
        initializeDarkMode();
        return;
    }

    // --- DOM Elements ---
    const pdfContainer = document.getElementById('pdfContainer');
    const pdfViewerContainer = document.getElementById('pdfViewerContainer');
    const canvas = document.getElementById('pdfCanvas');
    const loadingEl = document.getElementById('pdfLoading');
    const errorEl = document.getElementById('pdfError');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const pageInput = document.getElementById('pageInput');
    const totalPagesEl = document.getElementById('pdfTotalPages');
    const zoomInBtn = document.getElementById('zoomIn');
    const zoomOutBtn = document.getElementById('zoomOut');
    const zoomLevelEl = document.getElementById('zoomLevel');
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const retryBtn = document.getElementById('retryLoad');
    const pdfControls = document.querySelector('.pdf-controls');
    
    // --- Header Progress Elements ---
    const headerCurrentPage = document.getElementById('currentPage');
    const headerTotalPages = document.getElementById('totalPages');
        const progressBar = document.getElementById('progressBar');
    const lastPageInfo = document.getElementById('lastPageInfo');
    const mainContent = document.getElementById('mainContent');

    // --- State Variables ---
    let pdfDoc = null;
    let currentPageNum = {{ $readingSession->current_page ?? 1 }};
    let totalPages = 0;
    let scale = 1.5;
    let isRendering = false;
    let renderPending = false;
    let progressUpdateTimer;
    let controlsHideTimer;
    let isFullscreen = false;
    
    const pdfUrl = '{{ route("books.stream", $book->slug) }}';
    const fallbackUrl = '{{ route("books.download", $book->slug) }}';
    const bookSlug = '{{ $book->slug }}';
    const bookId = {{ $book->id }};
    
    // Load saved progress from localStorage
    const savedProgress = localStorage.getItem(`book_progress_${bookId}`);
    if (savedProgress) {
        try {
            const progress = JSON.parse(savedProgress);
            currentPageNum = progress.currentPage || currentPageNum;
            scale = progress.scale || scale;
        } catch (e) {
            console.warn('Failed to parse saved progress:', e);
        }
    }

    // --- Dark Mode Functions ---
    function initializeDarkMode() {
        const darkModeToggle = document.getElementById('darkModeToggle');
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');
        
        // Check for saved dark mode preference
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            enableDarkMode();
        }

        function enableDarkMode() {
            document.body.classList.add('dark-mode');
            mainContent.classList.add('dark-mode');
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
            localStorage.setItem('darkMode', 'true');
        }

        function disableDarkMode() {
            document.body.classList.remove('dark-mode');
            mainContent.classList.remove('dark-mode');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
            localStorage.setItem('darkMode', 'false');
        }

        darkModeToggle.addEventListener('click', () => {
            if (document.body.classList.contains('dark-mode')) {
                disableDarkMode();
            } else {
                enableDarkMode();
            }
        });
    }

    // --- Core Functions ---
    const loadPdf = async (url) => {
        try {
            console.log('Loading PDF from:', url);
            loadingEl.classList.remove('hidden');
            errorEl.classList.add('hidden');
            canvas.classList.add('hidden');

            if (!url || url === '') {
                throw new Error('PDF URL tidak valid');
            }

            const loadingTask = pdfjsLib.getDocument(url);
            console.log('PDF loading task created');
            
            pdfDoc = await loadingTask.promise;
            console.log('PDF loaded successfully, pages:', pdfDoc.numPages);
            
            totalPages = pdfDoc.numPages;
            totalPagesEl.textContent = totalPages;
            headerTotalPages.textContent = totalPages;
            pageInput.max = totalPages;

            currentPageNum = Math.max(1, Math.min(currentPageNum, totalPages));

            await renderPage(currentPageNum);
            
            loadingEl.classList.add('hidden');
            canvas.classList.remove('hidden');

        } catch (error) {
            console.error('Error loading PDF:', error);
            
            if (url === pdfUrl && fallbackUrl !== pdfUrl) {
                console.log('Trying fallback URL:', fallbackUrl);
                loadingEl.classList.add('hidden');
                setTimeout(() => loadPdf(fallbackUrl), 1000);
                return;
            }
            
            loadingEl.classList.add('hidden');
            errorEl.classList.remove('hidden');
            
            const errorTitle = errorEl.querySelector('h3');
            const errorDesc = errorEl.querySelector('p');
            if (errorTitle && errorDesc) {
                errorTitle.textContent = 'Gagal Memuat PDF';
                errorDesc.textContent = `Error: ${error.message}. Silakan coba lagi atau hubungi admin.`;
            }
        }
    };

    const renderPage = async (num) => {
        if (isRendering) {
            renderPending = num;
            return;
        }
        isRendering = true;

        const page = await pdfDoc.getPage(num);
        const viewport = page.getViewport({ scale });
        const context = canvas.getContext('2d');
        
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderContext = { canvasContext: context, viewport: viewport };
        await page.render(renderContext).promise;

        isRendering = false;
        currentPageNum = num;
        updateUI();
        scheduleProgressUpdate();

        if (renderPending) {
            const pendingPage = renderPending;
            renderPending = false;
            renderPage(pendingPage);
        }
    };

    // --- UI Update Functions ---
    const updateUI = () => {
        pageInput.value = currentPageNum;
        headerCurrentPage.textContent = currentPageNum;
        lastPageInfo.textContent = currentPageNum;
        
        const progress = totalPages > 0 ? (currentPageNum / totalPages) * 100 : 0;
        progressBar.style.width = `${progress}%`;
        
        prevPageBtn.disabled = currentPageNum <= 1;
        nextPageBtn.disabled = currentPageNum >= totalPages;
        zoomLevelEl.textContent = `${Math.round(scale * 100)}%`;
        
        saveProgressToLocalStorage();
    };
    
    const saveProgressToLocalStorage = () => {
        try {
            const progress = {
                currentPage: currentPageNum,
                totalPages: totalPages,
                scale: scale,
                timestamp: Date.now(),
                bookId: bookId,
                bookSlug: bookSlug
            };
            localStorage.setItem(`book_progress_${bookId}`, JSON.stringify(progress));
        } catch (e) {
            console.warn('Failed to save progress to localStorage:', e);
        }
    };

    // --- Fullscreen Functions ---
    const enterFullscreen = () => {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        }
    };

    const exitFullscreen = () => {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        }
    };

    const updateFullscreenButton = () => {
        isFullscreen = !!(document.fullscreenElement || 
            document.webkitFullscreenElement || 
            document.msFullscreenElement || 
            document.mozFullScreenElement);
            
        if (isFullscreen) {
            fullscreenBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            `;
            fullscreenBtn.title = "Keluar dari Layar Penuh (ESC)";
            fullscreenBtn.classList.remove('bg-white', 'border-gray-300');
            fullscreenBtn.classList.add('bg-red-600', 'border-red-600', 'text-white');
        } else {
            fullscreenBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                </svg>
            `;
            fullscreenBtn.title = "Layar Penuh (F11)";
            fullscreenBtn.classList.remove('bg-red-600', 'border-red-600', 'text-white');
            fullscreenBtn.classList.add('bg-white', 'border-gray-300');
        }
    };

    const setupFullscreenControls = () => {
        // Controls setup for fullscreen (if needed)
    };

    // --- Event Handlers ---
    const goToPage = (num) => {
        const pageNumber = parseInt(num, 10);
        if (pageNumber >= 1 && pageNumber <= totalPages && pageNumber !== currentPageNum) {
            renderPage(pageNumber);
        }
    };

    // Navigation event listeners
    prevPageBtn.addEventListener('click', () => {
        if (currentPageNum > 1) goToPage(currentPageNum - 1);
    });

    nextPageBtn.addEventListener('click', () => {
        if (currentPageNum < totalPages) goToPage(currentPageNum + 1);
    });

    pageInput.addEventListener('change', (e) => {
        goToPage(e.target.value);
    });

    // Zoom event listeners
    zoomInBtn.addEventListener('click', () => {
        scale = parseFloat((scale + 0.25).toFixed(2));
        renderPage(currentPageNum);
    });

    zoomOutBtn.addEventListener('click', () => {
        if (scale > 0.25) {
            scale = parseFloat((scale - 0.25).toFixed(2));
            renderPage(currentPageNum);
        }
    });

    // Fullscreen event listener
    fullscreenBtn.addEventListener('click', () => {
        if (!isFullscreen) {
            enterFullscreen();
        } else {
            exitFullscreen();
        }
    });

    retryBtn.addEventListener('click', () => loadPdf(pdfUrl));

    // --- Fullscreen Event Listeners ---
    document.addEventListener('fullscreenchange', updateFullscreenButton);
    document.addEventListener('webkitfullscreenchange', updateFullscreenButton);
    document.addEventListener('msfullscreenchange', updateFullscreenButton);
    document.addEventListener('mozfullscreenchange', updateFullscreenButton);

    // Mouse movement in fullscreen to show/hide controls
    document.addEventListener('mousemove', () => {
        // Mouse movement handling (if needed for fullscreen)
    });

    // Keep controls visible when hovering over them
    pdfControls.addEventListener('mouseenter', () => {
        // Controls hover handling (if needed)
    });

    pdfControls.addEventListener('mouseleave', () => {
        // Controls leave handling (if needed)
    });

    // --- Keyboard Event Listeners ---
    document.addEventListener('keydown', (e) => {
        // F11 for fullscreen
        if (e.key === 'F11') {
            e.preventDefault();
            fullscreenBtn.click();
        }
        
        // Escape to exit fullscreen
        if (e.key === 'Escape' && isFullscreen) {
            exitFullscreen();
        }
        
        // Arrow keys for navigation
        if (e.key === 'ArrowLeft' && currentPageNum > 1) {
            e.preventDefault();
            goToPage(currentPageNum - 1);
        }
        
        if (e.key === 'ArrowRight' && currentPageNum < totalPages) {
            e.preventDefault();
            goToPage(currentPageNum + 1);
        }
        
        // Plus/Minus for zoom
        if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            zoomInBtn.click();
        }
        
        if (e.key === '-') {
            e.preventDefault();
            zoomOutBtn.click();
        }
        
        // Home/End for first/last page
        if (e.key === 'Home') {
            e.preventDefault();
            goToPage(1);
        }
        
        if (e.key === 'End') {
            e.preventDefault();
            goToPage(totalPages);
        }
    });

    // --- Progress Tracking ---
    const sendProgressToServer = () => {
        const form = document.getElementById('progressForm');
        document.getElementById('progressCurrentPage').value = currentPageNum;
        document.getElementById('progressTotalPages').value = totalPages;
        
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': formData.get('_token'), 'Accept': 'application/json' },
            body: formData
        })
        .then(response => {
            if(!response.ok) console.error('Failed to update progress on server.');
        })
        .catch(error => console.error('Error sending progress:', error));
    };

    const scheduleProgressUpdate = () => {
        clearTimeout(progressUpdateTimer);
        progressUpdateTimer = setTimeout(sendProgressToServer, 2000);
    };

    // --- Initialization ---
    console.log('Initializing PDF reader...');
    
    if (typeof pdfjsLib === 'undefined') {
        console.error('PDF.js library not loaded!');
        errorEl.classList.remove('hidden');
        loadingEl.classList.add('hidden');
        return;
    }
    
    // Initialize dark mode
    initializeDarkMode();
    
    // Load PDF
    loadPdf(pdfUrl);
    
    // Initialize fullscreen button state
    updateFullscreenButton();
    
    // Save progress when page is unloaded
    window.addEventListener('beforeunload', () => {
        saveProgressToLocalStorage();
    });
    
    // Save progress periodically (every 30 seconds)
    setInterval(() => {
        if (pdfDoc && currentPageNum > 0) {
            saveProgressToLocalStorage();
        }
    }, 30000);

    // Modern notification popup functionality
    const notificationPopup = document.getElementById('notification-popup');
    if (notificationPopup) {
        // Animate in with bounce effect
        setTimeout(() => {
            notificationPopup.classList.remove('translate-x-full', 'opacity-0');
            notificationPopup.classList.add('translate-x-0', 'opacity-100');
        }, 100);

        // Auto hide after 6 seconds
        setTimeout(() => {
            closeNotification();
        }, 6000);

        // Add progress bar animation
        const progressBar = notificationPopup.querySelector('.h-1');
        if (progressBar) {
            progressBar.style.width = '100%';
            progressBar.style.transition = 'width 6s linear';
            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 100);
        }
    }
});

// Function to close notification with smooth animation
function closeNotification() {
    const notificationPopup = document.getElementById('notification-popup');
    if (notificationPopup) {
        // Animate out
        notificationPopup.classList.remove('translate-x-0', 'opacity-100');
        notificationPopup.classList.add('translate-x-full', 'opacity-0');
        
        // Remove from DOM after animation
        setTimeout(() => {
            if (notificationPopup.parentElement) {
                notificationPopup.remove();
            }
        }, 500);
    }
}
</script>
@endsection
