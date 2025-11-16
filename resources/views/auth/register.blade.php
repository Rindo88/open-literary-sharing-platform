<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom breakpoint for extra small devices */
        @media (min-width: 475px) {
            .xs\:inline { display: inline !important; }
            .xs:hidden { display: none !important; }
        }
        
        /* Smooth transitions */
        .form-transition {
            transition: all 0.3s ease-in-out;
        }
        
        /* Focus animations */
        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
        }
        
        /* Password strength indicator */
        .password-strength {
            transition: all 0.3s ease-in-out;
        }

        /* Librarian Character Animations */
        .librarian-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 50;
            transform: translateY(0);
            opacity: 1;
            animation: slideUp 1s ease-out 0.5s forwards;
        }

        .librarian-character {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .librarian-character:hover {
            transform: scale(1.1);
        }
        
        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .book-flip {
            animation: bookFlip 2s ease-in-out infinite;
            transform-origin: left center;
        }
        
        @keyframes bookFlip {
            0%, 90%, 100% { transform: rotateY(0deg); }
            45% { transform: rotateY(15deg); }
        }
        
        .glasses-glint {
            animation: glint 4s ease-in-out infinite;
        }
        
        @keyframes glint {
            0%, 95%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }
        
        .speech-bubble {
            position: absolute;
            bottom: 100%;
            right: 0;
            background: white;
            border-radius: 20px 20px 5px 20px;
            padding: 12px 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            opacity: 0;
            transform: translateY(10px) scale(0.8);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            white-space: nowrap;
            font-size: 14px;
            color: #374151;
            margin-bottom: 10px;
        }
        
        .speech-bubble::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 20px;
            width: 16px;
            height: 16px;
            background: white;
            transform: rotate(45deg);
            box-shadow: 3px 3px 5px rgba(0,0,0,0.1);
        }
        
        .speech-bubble.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        
        .wave-hand {
            animation: wave 0.5s ease-in-out;
        }
        
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(20deg); }
            75% { transform: rotate(-10deg); }
        }
        
        .sparkles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #fbbf24;
            border-radius: 50%;
            animation: sparkle 2s ease-in-out infinite;
        }
        
        @keyframes sparkle {
            0%, 100% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm sm:max-w-md space-y-6 sm:space-y-8">
        <!-- Header -->
        <div class="text-center">
            <!-- Logo -->
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-600 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
                Bergabung Bersama Kami! 🚀
            </h1>
            <p class="text-sm sm:text-base text-gray-600">
                Buat akun baru dan mulai jelajahi perpustakaan digital
            </p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative shadow-sm">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 mb-1">Terjadi kesalahan</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Register Form -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 form-transition">
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input id="name" name="name" type="text" autocomplete="name" required 
                               value="{{ old('name') }}"
                               class="block w-full pl-10 pr-3 py-3 sm:py-4 border @error('name') border-red-300 @else border-gray-300 @enderror rounded-xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-focus text-sm sm:text-base" 
                               placeholder="Masukkan nama lengkap Anda">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               value="{{ old('email') }}"
                               class="block w-full pl-10 pr-3 py-3 sm:py-4 border @error('email') border-red-300 @else border-gray-300 @enderror rounded-xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-focus text-sm sm:text-base" 
                               placeholder="Masukkan email Anda">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="new-password" required 
                               class="block w-full pl-10 pr-3 py-3 sm:py-4 border @error('password') border-red-300 @else border-gray-300 @enderror rounded-xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-focus text-sm sm:text-base" 
                               placeholder="Buat password yang kuat">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Password Strength Indicator -->
                    <div class="mt-2">
                        <div class="flex space-x-1">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div id="passwordStrength" class="h-full bg-gray-300 rounded-full password-strength" style="width: 0%"></div>
                            </div>
                        </div>
                        <p id="passwordStrengthText" class="text-xs text-gray-500 mt-1">Password strength</p>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                               class="block w-full pl-10 pr-3 py-3 sm:py-4 border @error('password_confirmation') border-red-300 @else border-gray-300 @enderror rounded-xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-focus text-sm sm:text-base" 
                               placeholder="Ulangi password Anda">
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms Agreement -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="agree_terms" name="agree_terms" type="checkbox" required
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="agree_terms" class="text-gray-700">
                            Saya setuju dengan 
                            <a href="#" class="text-blue-600 hover:text-blue-500 transition-colors duration-200 font-medium">
                                syarat dan ketentuan
                            </a>
                            serta 
                            <a href="#" class="text-blue-600 hover:text-blue-500 transition-colors duration-200 font-medium">
                                kebijakan privasi
                            </a>
                        </label>
                    </div>
                </div>

                <!-- Register Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 sm:py-4 px-4 border border-transparent text-sm sm:text-base font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-green-300 group-hover:text-green-200" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                            </svg>
                        </span>
                        Buat Akun Baru
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200" />
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Atau daftar dengan</span>
                    </div>
                </div>

                <!-- Google Register -->
                <div class="mt-6">
                    <a href="{{ route('auth.google') }}" 
                       class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="ml-3">Daftar dengan Google</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-sm sm:text-base text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login.show') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                    Masuk sekarang
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('books.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Lihat Katalog Buku
            </a>
        </div>
    </div>

    <!-- Animated Librarian Character -->
    <div class="librarian-container floating-animation">
        <div class="speech-bubble" id="speechBubble">
            Selamat datang di perpustakaan digital! 📚
        </div>
        
        <div class="librarian-character relative" id="librarian" onclick="interactWithLibrarian()">
            <!-- Sparkles Effect -->
            <div class="sparkles">
                <div class="sparkle" style="top: 10%; left: 15%; animation-delay: 0s;"></div>
                <div class="sparkle" style="top: 20%; right: 10%; animation-delay: 0.5s;"></div>
                <div class="sparkle" style="bottom: 30%; left: 20%; animation-delay: 1s;"></div>
                <div class="sparkle" style="bottom: 10%; right: 25%; animation-delay: 1.5s;"></div>
            </div>
            
            <!-- Character SVG -->
            <svg width="120" height="140" viewBox="0 0 120 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Base/Platform -->
                <ellipse cx="60" cy="135" rx="25" ry="3" fill="#e5e7eb" opacity="0.3"/>
                
                <!-- Books stack (left side) -->
                <rect x="15" y="115" width="12" height="15" rx="1" fill="#ef4444" class="book-flip"/>
                <rect x="15" y="100" width="12" height="15" rx="1" fill="#3b82f6"/>
                <rect x="15" y="85" width="12" height="15" rx="1" fill="#10b981"/>
                
                <!-- Body -->
                <ellipse cx="60" cy="100" rx="18" ry="25" fill="#6366f1"/>
                
                <!-- Arms -->
                <ellipse cx="42" cy="85" rx="6" ry="15" fill="#fbbf24" transform="rotate(-15 42 85)"/>
                <ellipse cx="78" cy="85" rx="6" ry="15" fill="#fbbf24" transform="rotate(15 78 85)" id="rightArm"/>
                
                <!-- Hands -->
                <circle cx="38" cy="95" r="4" fill="#fbbf24"/>
                <circle cx="82" cy="95" r="4" fill="#fbbf24" id="rightHand"/>
                
                <!-- Book in hand -->
                <rect x="79" y="90" width="8" height="10" rx="1" fill="#8b5cf6" class="book-flip"/>
                
                <!-- Head -->
                <circle cx="60" cy="55" r="20" fill="#fbbf24"/>
                
                <!-- Hair -->
                <path d="M40 45 C40 35, 50 30, 60 30 C70 30, 80 35, 80 45 C80 40, 70 42, 60 42 C50 42, 40 40, 40 45 Z" fill="#8b5cf6"/>
                
                <!-- Hair bun -->
                <circle cx="60" cy="35" r="6" fill="#8b5cf6"/>
                <circle cx="60" cy="35" r="2" fill="#6d28d9"/>
                
                <!-- Face -->
                <!-- Eyes -->
                <circle cx="54" cy="50" r="2" fill="#1f2937"/>
                <circle cx="66" cy="50" r="2" fill="#1f2937"/>
                
                <!-- Glasses -->
                <circle cx="54" cy="50" r="6" fill="none" stroke="#1f2937" stroke-width="1.5"/>
                <circle cx="66" cy="50" r="6" fill="none" stroke="#1f2937" stroke-width="1.5"/>
                <line x1="60" y1="47" x2="60" y2="50" stroke="#1f2937" stroke-width="1.5"/>
                
                <!-- Glasses glint -->
                <circle cx="56" cy="47" r="1.5" fill="#ffffff" opacity="0.8" class="glasses-glint"/>
                
                <!-- Nose -->
                <circle cx="60" cy="55" r="1" fill="#f59e0b"/>
                
                <!-- Mouth (smiling) -->
                <path d="M56 58 Q60 62 64 58" stroke="#1f2937" stroke-width="1.5" fill="none"/>
                
                <!-- Bow tie -->
                <polygon points="60,70 55,75 65,75" fill="#dc2626"/>
                <polygon points="60,70 58,72 62,72" fill="#991b1b"/>
                
                <!-- Books floating around (animated) -->
                <rect x="95" y="70" width="8" height="6" rx="1" fill="#f59e0b" class="floating-animation" style="animation-delay: 0.5s;"/>
                <rect x="8" y="60" width="6" height="8" rx="1" fill="#ec4899" class="floating-animation" style="animation-delay: 1s;"/>
                <rect x="100" y="45" width="7" height="5" rx="1" fill="#06b6d4" class="floating-animation" style="animation-delay: 1.5s;"/>
                
                <!-- Magical sparkles around character -->
                <circle cx="85" cy="55" r="1" fill="#fbbf24" class="sparkle" style="animation-delay: 0.3s;"/>
                <circle cx="35" cy="40" r="1" fill="#fbbf24" class="sparkle" style="animation-delay: 0.8s;"/>
                <circle cx="90" cy="35" r="1" fill="#fbbf24" class="sparkle" style="animation-delay: 1.3s;"/>
            </svg>
        </div>
    </div>

    <!-- Password Strength JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('passwordStrengthText');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strength = calculatePasswordStrength(password);
                updatePasswordStrength(strength);
            });
            
            function calculatePasswordStrength(password) {
                let score = 0;
                
                if (password.length >= 8) score += 1;
                if (password.match(/[a-z]/)) score += 1;
                if (password.match(/[A-Z]/)) score += 1;
                if (password.match(/[0-9]/)) score += 1;
                if (password.match(/[^a-zA-Z0-9]/)) score += 1;
                
                return score;
            }
            
            function updatePasswordStrength(strength) {
                const percentage = (strength / 5) * 100;
                let color = 'bg-red-500';
                let text = 'Sangat Lemah';
                
                if (strength >= 2) {
                    color = 'bg-yellow-500';
                    text = 'Lemah';
                }
                if (strength >= 3) {
                    color = 'bg-blue-500';
                    text = 'Sedang';
                }
                if (strength >= 4) {
                    color = 'bg-green-500';
                    text = 'Kuat';
                }
                if (strength >= 5) {
                    color = 'bg-green-600';
                    text = 'Sangat Kuat';
                }
                
                strengthBar.className = `h-full ${color} rounded-full password-strength`;
                strengthBar.style.width = percentage + '%';
                strengthText.textContent = text;
            }
        });

        // Librarian interaction variables
        let interactionCount = 0;
        const messages = [
            "Selamat datang di perpustakaan digital! 📚",
            "Sudah siap menjelajahi dunia buku? 🌟",
            "Perpustakaan digital terbaik menanti Anda! ✨",
            "Mari baca dan belajar bersama! 🤓",
            "Pengetahuan adalah harta yang tak ternilai! 💎",
            "Selamat membaca! Semoga harimu menyenangkan! 😊"
        ];

        // Show initial speech bubble
        setTimeout(() => {
            showSpeechBubble();
        }, 1000);

        // Auto hide speech bubble
        setTimeout(() => {
            hideSpeechBubble();
        }, 4000);

        function showSpeechBubble() {
            const bubble = document.getElementById('speechBubble');
            bubble.classList.add('show');
        }

        function hideSpeechBubble() {
            const bubble = document.getElementById('speechBubble');
            bubble.classList.remove('show');
        }

        function interactWithLibrarian() {
            const bubble = document.getElementById('speechBubble');
            const librarian = document.getElementById('librarian');
            const rightHand = document.getElementById('rightHand');
            
            // Wave animation
            rightHand.classList.add('wave-hand');
            setTimeout(() => {
                rightHand.classList.remove('wave-hand');
            }, 500);
            
            // Change message
            interactionCount = (interactionCount + 1) % messages.length;
            bubble.textContent = messages[interactionCount];
            
            // Show speech bubble
            showSpeechBubble();
            
            // Hide after 3 seconds
            setTimeout(() => {
                hideSpeechBubble();
            }, 3000);
            
            // Add bounce effect to librarian
            librarian.style.animation = 'none';
            librarian.offsetHeight; // Trigger reflow
            librarian.style.animation = 'float 3s ease-in-out infinite';
        }

        // Random interactions
        function randomInteraction() {
            if (Math.random() < 0.3) { // 30% chance
                interactWithLibrarian();
            }
        }

        // Set random interactions every 15-30 seconds
        setInterval(() => {
            randomInteraction();
        }, Math.random() * 15000 + 15000);
        
        // Debug: Log when animations should start
        console.log('Login page loaded, animations should start');
        
        // Force start animations after page load
        window.addEventListener('load', function() {
            console.log('Page fully loaded, starting animations');
            
            // Ensure librarian is visible
            const librarian = document.querySelector('.librarian-container');
            if (librarian) {
                librarian.style.display = 'block';
                librarian.style.opacity = '1';
                librarian.style.transform = 'translateY(0)';
                console.log('Librarian animation started');
            }
            
            // Start sparkle animations
            const sparkles = document.querySelectorAll('.sparkle');
            sparkles.forEach((sparkle, index) => {
                sparkle.style.animationDelay = (index * 0.2) + 's';
                console.log('Sparkle animation started for:', sparkle);
            });
        });

        // Easter egg: Double click for special animation
        document.getElementById('librarian').addEventListener('dblclick', function() {
            this.style.transform = 'rotate(360deg) scale(1.2)';
            this.style.transition = 'transform 1s ease-in-out';
            
            const bubble = document.getElementById('speechBubble');
            bubble.textContent = "🎉 Terima kasih sudah bermain! Mari mulai membaca! 🎉";
            showSpeechBubble();
            
            setTimeout(() => {
                this.style.transform = '';
                this.style.transition = 'transform 0.3s ease';
                hideSpeechBubble();
            }, 2000);
        });

        // Hide character on mobile if screen is too small
        function handleResize() {
            const librarian = document.querySelector('.librarian-container');
            if (window.innerWidth < 640 || window.innerHeight < 600) {
                librarian.style.display = 'none';
            } else {
                librarian.style.display = 'block';
                // Ensure animations are running
                librarian.style.animation = 'slideUp 1s ease-out 0.5s forwards, float 3s ease-in-out infinite';
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Check on initial load
        
        // Additional check for animation support
        if (window.matchMedia('(prefers-reduced-motion: no-preference)').matches) {
            console.log('Animations are supported and enabled');
        } else {
            console.log('Animations are disabled (user preference)');
        }
    </script>
</body>
</html> 