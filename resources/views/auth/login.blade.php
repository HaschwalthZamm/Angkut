<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Angkut</title>

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
        <!-- Daun 1 -->
        <svg class="leaf text-green-500 w-6 h-6 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/>
        </svg>
        <!-- Daun 2 (Warna beda) -->
        <svg class="leaf text-green-600 w-5 h-5 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/>
        </svg>
        <!-- Daun 3 -->
        <svg class="leaf text-amber-500 w-7 h-7 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/>
        </svg>
        <!-- Daun 4 -->
        <svg class="leaf text-green-400 w-4 h-4 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/>
        </svg>
        <!-- Daun 5 -->
        <svg class="leaf text-emerald-600 w-5 h-5 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/>
        </svg>
        <!-- Daun 6 -->
        <svg class="leaf text-amber-400 w-6 h-6 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C15 20 20 13 20 8a7.63 7.63 0 00-3-5.88c-1.15-.8-2.61-1.12-4-1.12A10 10 0 009 2c0 6 3 7 8 6z"/>
        </svg>
    </div>

    <!-- Overlay Gelap -->
    <div class="dark-overlay absolute inset-0"></div>

    <!-- GELEMBUNG DEKORATIF (Hanya di area form) -->
    <div class="bubble w-4 h-4 left-[10%] top-[20%]" style="animation-delay: 0s;"></div>
    <div class="bubble w-8 h-8 left-[5%] top-[60%]" style="animation-delay: 1.5s;"></div>
    <div class="bubble w-3 h-3 left-[40%] top-[15%]" style="animation-delay: 0.5s;"></div>
    <div class="bubble w-6 h-6 left-[35%] top-[75%]" style="animation-delay: 2s;"></div>

    <!-- ============================================== -->
    <!-- HEADER: LOGO & NAVIGASI                        -->
    <!-- ============================================== -->
    <div class="absolute top-0 left-0 w-full z-50 flex justify-between items-center px-8 py-6 sm:px-16 lg:px-24">
        <!-- Logo (Ukuran Normal) -->
        <a href="/" class="flex items-center gap-2 hover:opacity-80 transition">
            <img id="logo-image" src="{{ asset('images/logo.png') }}" alt="Angkut Logo" class="h-10 object-contain drop-shadow-md transition-all duration-300">
        </a>

        <!-- Menu Kanan (Sedikit lebih kecil, digeser ke kanan) -->
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

            <!-- Tombol JOIN -->
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="bg-white px-4 py-1 rounded-full border-2 border-angkut-deep shadow-cartoon-xs hover:-translate-y-0.5 hover:shadow-cartoon-sm active:translate-y-0 active:shadow-none transition-all text-angkut-deep">
                    JOIN
                </a>
            @endif
        </div>
    </div>

    <!-- Bagian Kiri: Form Login -->
    <div class="w-full lg:w-1/2 flex flex-col relative z-10 px-8 pt-24 pb-6 sm:px-16 lg:px-24 lg:pt-28 justify-between min-h-screen">

        <!-- Form Area -->
        <div class="w-full max-w-md mx-auto my-auto">
            <h3 class="text-sm font-bold text-angkut-dark uppercase tracking-wider mb-2 transition-colors">Start for free</h3>
            <h1 class="text-4xl font-bold text-angkut-deep mb-6 transition-colors">SIGN IN</h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-angkut-dark/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="Email or Username"
                        class="w-full bg-white/90 backdrop-blur-md border-2 border-angkut-deep/20 rounded-xl px-4 py-3.5 text-angkut-deep placeholder-angkut-dark/40 focus:ring-2 focus:ring-angkut-orange focus:border-angkut-orange shadow-cartoon-xs transition-all outline-none">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs font-bold" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-angkut-dark/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="Password"
                        class="w-full bg-white/90 backdrop-blur-md border-2 border-angkut-deep/20 rounded-xl px-4 py-3.5 text-angkut-deep placeholder-angkut-dark/40 focus:ring-2 focus:ring-angkut-orange focus:border-angkut-orange shadow-cartoon-xs transition-all outline-none">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs font-bold" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-2">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-angkut-dark/30 text-angkut-orange shadow-sm focus:ring-angkut-orange bg-white/50" name="remember">
                        <span class="ms-2 text-sm font-bold text-angkut-deep transition-colors">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-bold text-angkut-deep hover:text-angkut-orange transition-colors" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-angkut-orange text-white font-bold text-lg py-3.5 rounded-xl shadow-cartoon hover:-translate-y-1 hover:shadow-cartoon-md active:translate-y-0 active:shadow-cartoon-xs transition-all mt-4 border-2 border-angkut-deep">
                    LOGIN
                </button>
            </form>

            <!-- Pindahan: Teks Create Account -->
            <p class="text-sm text-angkut-deep font-bold mt-6 text-center drop-shadow-md transition-colors">
                Don't have an Account?
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-angkut-orange hover:underline drop-shadow-sm">Create Account</a>
                @endif
            </p>

            <!-- ELEMEN BARU: Teks Tambahan -->
            <div class="mt-10 text-center px-4">
                <!-- Garis Pembatas -->
                <div class="flex items-center justify-center gap-3 mb-4 opacity-60">
                    <span class="h-[2px] w-10 bg-angkut-deep rounded-full"></span>
                    <span class="text-xs font-bold text-angkut-dark uppercase tracking-widest">Angkut</span>
                    <span class="h-[2px] w-10 bg-angkut-deep rounded-full"></span>
                </div>
                <!-- Quote -->
                <p class="text-[13px] sm:text-sm font-bold text-angkut-deep/90 leading-relaxed italic drop-shadow-sm transition-colors">
                    "Bersama Angkut, wujudkan lingkungan yang lebih bersih dan bebas sampah."
                </p>
                <!-- Sub-teks -->
                <p class="text-[11px] sm:text-xs font-medium text-angkut-deep/70 mt-2 transition-colors">
                    Layanan pengangkutan sampah terpercaya & ramah lingkungan.
                </p>
            </div>

        </div>

        <!-- Footer Kosong -->
        <div class="pb-4"></div>
    </div>

    <!-- Bagian Kanan: Maskot Truk Sampah -->
    <div class="w-full lg:w-1/2 relative flex items-center justify-center p-12 mt-12 lg:mt-0 z-10">
        <!-- Mengubah max-w-2xl menjadi max-w-3xl agar maskot lebih besar lagi -->
        <img id="maskot-image" src="{{ asset('images/maskot.webp') }}" alt="Angkut Mascot"
            class="relative z-10 w-full max-w-3xl object-contain drop-shadow-2xl animate-float transition-all duration-300">
    </div>

    <!-- Script Logika Mode Gelap/Terang -->
    <script>
        (function () {
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

            // Terapkan tema saat halaman dimuat
            applyTheme(document.documentElement.classList.contains('dark'));

            // Toggle saat tombol diklik
            themeToggleBtn.addEventListener('click', function () {
                const nextIsDark = !document.documentElement.classList.contains('dark');
                localStorage.setItem('theme', nextIsDark ? 'dark' : 'light');
                applyTheme(nextIsDark);
            });

            // Ikuti perubahan preferensi sistem (jika user belum memilih manual)
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
                if (!localStorage.getItem('theme')) {
                    applyTheme(e.matches);
                }
            });
        })();
    </script>
</body>
</html>