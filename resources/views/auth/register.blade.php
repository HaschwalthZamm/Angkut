<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Angkut</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Script Deteksi Awal (hindari flash) -->
    <script>
        (function () {
            var saved = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- CSS Murni untuk Dark Mode, Animasi Daun & Background -->
    <style>
        /* =========================================================
           1. BACKGROUND
           ========================================================= */
        .bg-custom-device {
            background-image: url('{{ asset('images/lbmaskot.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #e5e7eb; /* fallback mode terang */
        }
        html.dark .bg-custom-device {
            background-color: #0b1220; /* fallback mode gelap */
        }

        /* =========================================================
           2. TRANSISI & COLOR-SCHEME
           ========================================================= */
        html { color-scheme: light; }
        html.dark { color-scheme: dark; }

        body, input, a, button, label, p, span {
            transition: background-color .35s ease,
                        color .35s ease,
                        border-color .35s ease,
                        box-shadow .35s ease,
                        opacity .35s ease;
        }

        /* =========================================================
           3. OVERLAY GELAP
           ========================================================= */
        .dark-overlay {
            background-color: #000;
            opacity: 0;
            pointer-events: none;
            transition: opacity .5s ease;
            z-index: 1; /* Di atas background, di bawah konten */
        }
        html.dark .dark-overlay {
            opacity: .8;
        }

        /* =========================================================
           4. DASAR MODE GELAP
           ========================================================= */
        html.dark body {
            background-color: #0b1220;
            color: #f1f5f9;
        }

        /* =========================================================
           5. TEKS MODE GELAP
           ========================================================= */
        html.dark .text-angkut-deep { color: #f1f5f9 !important; }
        html.dark .text-angkut-dark { color: #94a3b8 !important; }
        
        /* PERBAIKAN: Garis pemisah agar terang saat mode gelap */
        html.dark .bg-angkut-deep { background-color: #64748b !important; }

        /* =========================================================
           6. PERMUKAAN (CARD / INPUT / TOMBOL PUTIH) MODE GELAP
           ========================================================= */
        html.dark .bg-white\/90 {
            background-color: rgba(30, 41, 59, .95) !important;
            color: #f1f5f9 !important;
            border-color: rgba(71, 85, 105, .85) !important;
        }
        html.dark .bg-white {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #475569 !important;
        }
        html.dark .bg-white\/50 {
            background-color: rgba(51, 65, 85, .6) !important;
        }

        /* =========================================================
           7. INPUT & PLACEHOLDER MODE GELAP
           ========================================================= */
        html.dark input,
        html.dark textarea {
            color: #f1f5f9 !important;
        }
        html.dark input::placeholder {
            color: rgba(148, 163, 184, .65) !important;
        }
        html.dark input[type="checkbox"] {
            background-color: #334155 !important;
            border-color: #64748b !important;
        }

        /* =========================================================
           8. TOMBOL TEMA MODE GELAP
           ========================================================= */
        html.dark #theme-toggle {
            background-color: #334155 !important;
            color: #f1f5f9 !important;
            border-color: #64748b !important;
        }

        /* =========================================================
           9. ANIMASI DAUN JATUH
           ========================================================= */
        .leaf-container {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0; /* Di belakang overlay dan konten */
        }

        .leaf {
            position: absolute;
            top: -10vh;
            animation: leaf-fall linear infinite;
        }

        @keyframes leaf-fall {
            0% {
                transform: translateY(-10vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.8;
            }
            90% {
                opacity: 0.8;
            }
            100% {
                transform: translateY(110vh) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Konfigurasi Daun (Posisi, Durasi, Delay) */
        .leaf:nth-child(1) { left: 5%; animation-duration: 12s; animation-delay: 0s; }
        .leaf:nth-child(2) { left: 25%; animation-duration: 16s; animation-delay: 2s; }
        .leaf:nth-child(3) { left: 45%; animation-duration: 10s; animation-delay: 5s; }
        .leaf:nth-child(4) { left: 70%; animation-duration: 14s; animation-delay: 1s; }
        .leaf:nth-child(5) { left: 85%; animation-duration: 18s; animation-delay: 7s; }
        .leaf:nth-child(6) { left: 95%; animation-duration: 11s; animation-delay: 4s; }

        /* Animasi Gelembung/Partikel Kecil */
        @keyframes float-bubble {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
            50% { transform: translateY(-20px) scale(1.1); opacity: 0.9; }
        }
        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: float-bubble 4s ease-in-out infinite;
            z-index: 0;
        }
        html.dark .bubble { background: rgba(255, 255, 255, 0.1); }
    </style>
</head>

<body class="font-fun text-angkut-deep antialiased min-h-screen flex flex-col lg:flex-row overflow-x-hidden relative transition-colors duration-300 bg-custom-device">

    <!-- 1. ANIMASI DAUN JATUH -->
    <div class="leaf-container">
        <svg class="leaf text-green-500 w-6 h-6 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/></svg>
        <svg class="leaf text-green-600 w-5 h-5 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/></svg>
        <svg class="leaf text-amber-500 w-7 h-7 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/></svg>
        <svg class="leaf text-green-400 w-4 h-4 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/></svg>
        <svg class="leaf text-emerald-600 w-5 h-5 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/></svg>
        <svg class="leaf text-amber-400 w-6 h-6 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/></svg>
    </div>

    <!-- Overlay Gelap -->
    <div class="dark-overlay absolute inset-0"></div>

    <!-- GELEMBUNG DEKORATIF -->
    <div class="bubble w-4 h-4 left-[10%] top-[20%]" style="animation-delay: 0s;"></div>
    <div class="bubble w-8 h-8 left-[5%] top-[60%]" style="animation-delay: 1.5s;"></div>
    <div class="bubble w-3 h-3 left-[40%] top-[15%]" style="animation-delay: 0.5s;"></div>
    <div class="bubble w-6 h-6 left-[35%] top-[75%]" style="animation-delay: 2s;"></div>

    <!-- ============================================== -->
    <!-- HEADER: LOGO & NAVIGASI                        -->
    <!-- ============================================== -->
    <div class="absolute top-0 left-0 w-full z-50 flex justify-between items-center px-8 py-6 sm:px-16 lg:px-24">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-2 hover:opacity-80 transition">
            <img id="logo-image" src="{{ asset('images/logo.png') }}" alt="Angkut Logo" class="h-10 object-contain drop-shadow-md transition-all duration-300">
        </a>

        <!-- Menu Kanan -->
        <div class="flex items-center gap-2.5 sm:gap-3 font-bold text-[13px] sm:text-sm -mr-2 sm:-mr-4 lg:-mr-6">

            <!-- TOMBOL MODE GELAP/TERANG -->
            <button id="theme-toggle" type="button"
                class="bg-angkut-pop text-angkut-deep px-3.5 py-1 rounded-full border-2 border-angkut-deep shadow-cartoon-xs hover:-translate-y-0.5 hover:shadow-cartoon-sm active:translate-y-0 active:shadow-none transition-all flex items-center gap-1.5">
                <span id="theme-text">terang</span>
                <svg id="icon-moon" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="icon-sun" class="w-3.5 h-3.5 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Tombol HOME -->
            <a href="/" class="bg-white px-4 py-1 rounded-full border-2 border-angkut-deep shadow-cartoon-xs hover:-translate-y-0.5 hover:shadow-cartoon-sm active:translate-y-0 active:shadow-none transition-all text-angkut-deep">
                HOME
            </a>

            <!-- Tombol LOGIN -->
            <a href="{{ route('login') }}" class="bg-white px-4 py-1 rounded-full border-2 border-angkut-deep shadow-cartoon-xs hover:-translate-y-0.5 hover:shadow-cartoon-sm active:translate-y-0 active:shadow-none transition-all text-angkut-deep">
                LOGIN
            </a>
        </div>
    </div>

    <!-- Bagian Kiri: Form Register -->
    <div class="w-full lg:w-1/2 flex flex-col relative z-10 px-8 pt-24 pb-6 sm:px-16 lg:px-24 lg:pt-28 justify-between min-h-screen">

        <!-- Form Area -->
        <div class="w-full max-w-md mx-auto my-auto">
            
            <!-- Judul di tengah -->
            <h1 class="text-3xl font-bold text-angkut-deep mb-6 text-center transition-colors">CREATE ACCOUNT</h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Jarak antar input diperlebar (space-y-6) agar tidak menempel -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-angkut-dark/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Full Name"
                        class="w-full bg-white/90 backdrop-blur-md border-2 border-angkut-deep/20 rounded-xl px-4 py-2.5 text-sm text-angkut-deep placeholder-angkut-dark/40 focus:ring-2 focus:ring-angkut-orange focus:border-angkut-orange shadow-cartoon-xs transition-all outline-none">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-xs font-bold" />
                </div>

                <!-- Email Address -->
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-angkut-dark/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        placeholder="Email Address"
                        class="w-full bg-white/90 backdrop-blur-md border-2 border-angkut-deep/20 rounded-xl px-4 py-2.5 text-sm text-angkut-deep placeholder-angkut-dark/40 focus:ring-2 focus:ring-angkut-orange focus:border-angkut-orange shadow-cartoon-xs transition-all outline-none">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs font-bold" />
                </div>

                <!-- Phone Number -->
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-angkut-dark/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel"
                        placeholder="Nomor HP (WhatsApp)"
                        class="w-full bg-white/90 backdrop-blur-md border-2 border-angkut-deep/20 rounded-xl px-4 py-2.5 text-sm text-angkut-deep placeholder-angkut-dark/40 focus:ring-2 focus:ring-angkut-orange focus:border-angkut-orange shadow-cartoon-xs transition-all outline-none">
                    <x-input-error :messages="$errors->get('phone')" class="mt-1 text-red-500 text-xs font-bold" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <div class="absolute inset-y-0 right-10 pr-2 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-angkut-dark/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="Password"
                        class="w-full bg-white/90 backdrop-blur-md border-2 border-angkut-deep/20 rounded-xl px-4 py-2.5 pr-12 text-sm text-angkut-deep placeholder-angkut-dark/40 focus:ring-2 focus:ring-angkut-orange focus:border-angkut-orange shadow-cartoon-xs transition-all outline-none">
                    
                    <!-- Tombol Mata Password -->
                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-angkut-dark/50 hover:text-angkut-orange transition-colors focus:outline-none">
                        <svg id="eye-open-password" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-closed-password" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                    
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs font-bold" />
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <div class="absolute inset-y-0 right-10 pr-2 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-angkut-dark/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Confirm Password"
                        class="w-full bg-white/90 backdrop-blur-md border-2 border-angkut-deep/20 rounded-xl px-4 py-2.5 pr-12 text-sm text-angkut-deep placeholder-angkut-dark/40 focus:ring-2 focus:ring-angkut-orange focus:border-angkut-orange shadow-cartoon-xs transition-all outline-none">
                    
                    <!-- Tombol Mata Confirm Password -->
                    <button type="button" id="toggle-password-confirm" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-angkut-dark/50 hover:text-angkut-orange transition-colors focus:outline-none">
                        <svg id="eye-open-confirm" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-closed-confirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                    
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-xs font-bold" />
                </div>

                <!-- Register Button -->
                <button type="submit" class="w-full bg-angkut-orange text-white font-bold text-base py-3 rounded-xl shadow-cartoon hover:-translate-y-1 hover:shadow-cartoon-md active:translate-y-0 active:shadow-cartoon-xs transition-all mt-6 border-2 border-angkut-deep">
                    REGISTER
                </button>
            </form>

            <!-- Pindahan: Teks Login -->
            <p class="text-sm text-angkut-deep font-bold mt-6 text-center drop-shadow-md transition-colors">
                Already have an Account?
                <a href="{{ route('login') }}" class="text-angkut-orange hover:underline drop-shadow-sm">Log In</a>
            </p>

            <!-- ELEMEN BARU: Teks Tambahan (SUDAH DIPERBAIKI UNTUK DARK MODE) -->
            <div class="mt-8 text-center px-4">
                <div class="flex items-center justify-center gap-3 mb-4 opacity-60">
                    <span class="h-[2px] w-10 bg-angkut-deep rounded-full transition-colors"></span>
                    <span class="text-xs font-bold text-angkut-dark uppercase tracking-widest transition-colors">Angkut</span>
                    <span class="h-[2px] w-10 bg-angkut-deep rounded-full transition-colors"></span>
                </div>
                <!-- Diubah menjadi text-angkut-deep dengan opacity-90 -->
                <p class="text-[13px] sm:text-sm font-bold text-angkut-deep opacity-90 leading-relaxed italic drop-shadow-sm transition-colors">
                    "Mulai langkahmu hari ini. Bergabunglah bersama Angkut untuk masa depan yang lebih bersih."
                </p>
                <!-- Diubah menjadi text-angkut-deep dengan opacity-70 -->
                <p class="text-[11px] sm:text-xs font-medium text-angkut-deep opacity-70 mt-2 transition-colors">
                    Layanan pengangkutan sampah terpercaya & ramah lingkungan.
                </p>
            </div>

        </div>

        <!-- Footer Kosong -->
        <div class="pb-4"></div>
    </div>

    <!-- Bagian Kanan: Maskot Truk Sampah -->
    <div class="w-full lg:w-1/2 relative flex items-center justify-center p-12 mt-12 lg:mt-0 z-10">
        <img id="maskot-image" src="{{ asset('images/ceria.webp') }}" alt="Angkut Mascot"
            class="relative z-10 w-full max-w-md object-contain drop-shadow-2xl animate-float transition-all duration-300">
    </div>

    <!-- Script Logika Mode Gelap/Terang & Toggle Password -->
    <script>
        (function () {
            // --- LOGIKA TEMA GELAP/TERANG ---
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeText      = document.getElementById('theme-text');
            const iconMoon       = document.getElementById('icon-moon');
            const iconSun        = document.getElementById('icon-sun');
            const logoImage      = document.getElementById('logo-image');
            const maskotImage    = document.getElementById('maskot-image');

            function applyTheme(isDark) {
                const root = document.documentElement;

                if (isDark) {
                    root.classList.add('dark');
                    themeText.textContent = 'gelap';
                    iconMoon.classList.add('hidden');
                    iconSun.classList.remove('hidden');
                    logoImage.style.filter = 'brightness(0) invert(1)';
                    maskotImage.style.opacity = '0.85';
                } else {
                    root.classList.remove('dark');
                    themeText.textContent = 'terang';
                    iconMoon.classList.remove('hidden');
                    iconSun.classList.add('hidden');
                    logoImage.style.filter = 'none';
                    maskotImage.style.opacity = '1';
                }
            }

            applyTheme(document.documentElement.classList.contains('dark'));

            themeToggleBtn.addEventListener('click', function () {
                const nextIsDark = !document.documentElement.classList.contains('dark');
                localStorage.setItem('theme', nextIsDark ? 'dark' : 'light');
                applyTheme(nextIsDark);
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
                if (!localStorage.getItem('theme')) {
                    applyTheme(e.matches);
                }
            });

            // --- LOGIKA TOGGLE PASSWORD UTAMA ---
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open-password');
            const eyeClosed = document.getElementById('eye-closed-password');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeClosed.classList.add('hidden');
                    eyeOpen.classList.remove('hidden');
                } else {
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                }
            });

            // --- LOGIKA TOGGLE CONFIRM PASSWORD ---
            const togglePasswordConfirm = document.getElementById('toggle-password-confirm');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const eyeOpenConfirm = document.getElementById('eye-open-confirm');
            const eyeClosedConfirm = document.getElementById('eye-closed-confirm');

            togglePasswordConfirm.addEventListener('click', function () {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeClosedConfirm.classList.add('hidden');
                    eyeOpenConfirm.classList.remove('hidden');
                } else {
                    eyeOpenConfirm.classList.add('hidden');
                    eyeClosedConfirm.classList.remove('hidden');
                }
            });
        })();
    </script>
</body>
</html>