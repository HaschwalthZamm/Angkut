<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ANGKUT - Sistem Pengaduan & Pengangkutan Sampah Palembang</title>
    <meta name="description" content="ANGKUT: layanan pengaduan dan pengangkutan sampah terpadu untuk 18 kecamatan di Kota Palembang. Lapor, lacak, dan pilah sampah dari rumah.">
    <meta name="theme-color" content="#1E3011">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- UX: perilaku navigasi, fokus keyboard & reduced-motion -->
    <style>
        html { scroll-padding-top: 5.5rem; } /* anchor tidak tertutup navbar sticky */

        /* link navbar + penanda section aktif */
        .nav-link { position: relative; padding: .25rem 0; }
        .nav-link::after {
            content: ""; position: absolute; left: 0; right: 0; bottom: -6px; height: 5px; border-radius: 99px;
            background: #FFBF00; box-shadow: 0 0 0 1.5px #1E3011;
            opacity: 0; transform: scaleX(0); transform-origin: left center; transition: transform .25s ease, opacity .15s ease;
        }
        .nav-link:hover::after, .nav-link.is-active::after { opacity: 1; transform: scaleX(1); }
        .nav-link.is-active { color: #3D5B21; }

        /* navbar responsif: menu penuh mulai 1100px, di bawahnya hamburger */
        header .nav-desktop { display: none; align-items: center; gap: 1.5rem; }
        header .nav-extra { display: none; }
        header .menu-btn { display: flex; }
        @media (min-width: 1100px) {
            header .nav-desktop { display: flex; }
            header .nav-extra { display: inline-flex; }
            header .menu-btn { display: none; }
            header .mobile-menu { display: none !important; }
        }

        /* menu mobile */
        header .mobile-menu { position: absolute; top: 100%; left: 0; right: 0; }
        header .mobile-menu[hidden] { display: none; }
        .mobile-menu-inner { padding-top: 1rem; padding-bottom: 1rem; display: grid; gap: 1rem; }
        .mobile-menu-links { display: grid; gap: .375rem; }
        .menu-actions { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: .5rem; }
        .menu-actions.is-two { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .menu-actions form { display: contents; }
        .menu-actions a, .menu-actions button { display: inline-flex; align-items: center; justify-content: center; min-height: 48px; }
        .mobile-link { display: flex; align-items: center; min-height: 48px; padding: 0 1rem; border-radius: .75rem; }
        .mobile-menu:not([hidden]) { animation: menuIn .22s ease-out; }
        @keyframes menuIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: none; } }
        .mobile-link { border: 2px solid transparent; transition: background-color .15s ease, box-shadow .15s ease, transform .15s ease; }
        .mobile-link:hover { background: #F4F8D8; }
        .mobile-link.is-active { background: #FFBF00; border-color: #1E3011; box-shadow: 3px 3px 0 #1E3011; }

        /* lompat ke konten (keyboard / screen reader) */
        .skip-link {
            position: absolute; left: 1rem; top: -5rem; z-index: 100; padding: .75rem 1.25rem;
            background: #FFBF00; color: #1E3011; font-weight: 800; border: 3px solid #1E3011; border-radius: .75rem;
            box-shadow: 3px 3px 0 #1E3011; transition: top .15s ease;
        }
        .skip-link:focus { top: 1rem; }

        /* cincin fokus yang jelas untuk pengguna keyboard */
        a:focus-visible, button:focus-visible, [tabindex]:focus-visible {
            outline: 3px solid #1E3011; outline-offset: 3px;
        }

        /* tombol kembali ke atas */
        .to-top {
            position: fixed; right: 1rem; bottom: calc(1rem + env(safe-area-inset-bottom, 0px)); z-index: 40;
            width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;
            background: #FFBF00; color: #1E3011; border: 3px solid #1E3011; border-radius: 14px; box-shadow: 3px 3px 0 #1E3011;
            opacity: 0; visibility: hidden; transform: translateY(12px);
            transition: opacity .25s ease, transform .25s ease, visibility 0s linear .25s;
        }
        .to-top.is-visible { opacity: 1; visibility: visible; transform: none; transition-delay: 0s; }
        .to-top:active { transform: translate(2px, 2px); box-shadow: 1px 1px 0 #1E3011; }

        /* hormati pengaturan "kurangi gerakan" milik pengguna */
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto !important; }
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body class="min-h-screen bg-white text-angkut-deep font-sans selection:bg-angkut-light selection:text-angkut-deep overflow-x-hidden">

    <a href="#konten" class="skip-link">Lewati ke konten utama</a>

    <!-- ========================================== -->
    <!-- NAVBAR (WHITE BG + BOLD OUTLINES) -->
    <!-- ========================================== -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b-4 border-angkut-deep transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- BRAND LOGO -->
            <a href="{{ url('/') }}" class="flex items-center group" aria-label="ANGKUT - Beranda">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="ANGKUT Logo" 
                     decoding="async"
                     class="h-10 sm:h-14 w-auto object-contain transition-transform group-hover:-translate-y-0.5 group-hover:scale-105">
            </a>

            <!-- NAVIGATION LINKS (urutan = urutan section di halaman) -->
            <nav aria-label="Navigasi utama" class="nav-desktop font-fun font-bold text-angkut-deep text-sm">
                <a href="#hero" class="nav-link hover:text-angkut-dark transition-colors">Beranda</a>
                <a href="#pemilahan" class="nav-link hover:text-angkut-dark transition-colors">Pilah Sampah</a>
                <a href="#alur" class="nav-link hover:text-angkut-dark transition-colors">Cara Kerja</a>
                <a href="#wilayah" class="nav-link hover:text-angkut-dark transition-colors">Wilayah Layanan</a>
            </nav>

            <!-- ACTION BUTTONS -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" 
                        class="hidden sm:inline-flex bg-angkut-medium text-white font-fun font-bold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm items-center gap-2">
                        <span>{{ auth()->user()->isAdmin() ? 'Admin Panel' : 'Dashboard' }}</span>
                        <span class="w-2 h-2 bg-angkut-light rounded-full border border-angkut-deep"></span>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline-flex">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-fun font-bold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm">
                            Keluar
                        </button>
                    </form>
                @else
                    <!-- TOMBOL LACAK DI NAVBAR UNTUK GUEST -->
                    <a href="{{ route('public.tracking.create') }}" 
                        class="nav-extra bg-angkut-light hover:bg-angkut-pop text-angkut-deep font-fun font-extrabold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm">
                        Lacak
                    </a>
                    <!-- TOMBOL LAPOR DI NAVBAR UNTUK GUEST -->
                    <a href="{{ route('public.report.create') }}" 
                        class="hidden sm:inline-flex bg-angkut-orange hover:bg-[#e66a24] text-white font-fun font-extrabold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm">
                        Lapor
                    </a>
                    <a href="{{ route('login') }}" 
                        class="bg-white hover:bg-slate-100 text-angkut-deep font-fun font-bold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" 
                        class="nav-extra bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun font-extrabold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm">
                        Daftar
                    </a>
                @endauth

                <!-- TOMBOL MENU (tablet & HP) -->
                <button type="button" id="menu-toggle" aria-controls="mobile-menu" aria-expanded="false" aria-label="Buka menu"
                    class="menu-btn w-11 h-11 bg-white text-angkut-deep border-3 border-angkut-deep rounded-xl shadow-cartoon flex items-center justify-center transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5">
                    <svg class="w-6 h-6 menu-icon-open" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                    <svg class="w-6 h-6 menu-icon-close hidden" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>
        </div>

        <!-- PANEL MENU MOBILE -->
        <div id="mobile-menu" hidden class="mobile-menu bg-white border-b-4 border-angkut-deep shadow-cartoon-xl">
            <div class="mobile-menu-inner max-w-7xl mx-auto px-4 sm:px-6">
                <nav aria-label="Navigasi mobile" class="mobile-menu-links font-fun font-bold text-angkut-deep">
                    <a href="#hero" class="mobile-link">Beranda</a>
                    <a href="#pemilahan" class="mobile-link">Pilah Sampah</a>
                    <a href="#alur" class="mobile-link">Cara Kerja</a>
                    <a href="#wilayah" class="mobile-link">Wilayah Layanan</a>
                </nav>

                @auth
                    <div class="menu-actions is-two">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center min-h-[48px] bg-angkut-medium text-white font-fun font-bold text-sm border-3 border-angkut-deep rounded-xl shadow-cartoon">
                            {{ auth()->user()->isAdmin() ? 'Admin Panel' : 'Dashboard' }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center min-h-[48px] bg-red-500 text-white font-fun font-bold text-sm border-3 border-angkut-deep rounded-xl shadow-cartoon">Keluar</button>
                        </form>
                    </div>
                @else
                    <div class="menu-actions">
                        <a href="{{ route('public.tracking.create') }}" class="inline-flex items-center justify-center min-h-[48px] bg-angkut-light text-angkut-deep font-fun font-extrabold text-sm border-3 border-angkut-deep rounded-xl shadow-cartoon">Lacak</a>
                        <a href="{{ route('public.report.create') }}" class="inline-flex items-center justify-center min-h-[48px] bg-angkut-orange text-white font-fun font-extrabold text-sm border-3 border-angkut-deep rounded-xl shadow-cartoon">Lapor</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center min-h-[48px] bg-angkut-pop text-angkut-deep font-fun font-extrabold text-sm border-3 border-angkut-deep rounded-xl shadow-cartoon">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <main id="konten">
    <!-- ========================================== -->
    <!-- HERO SECTION -->
    <!-- ========================================== -->
    <section id="hero" class="relative pt-10 pb-16 lg:py-20 bg-white border-b-4 border-angkut-deep overflow-hidden">
        
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#1E3011 2px, transparent 2px); background-size: 24px 24px;"></div>

        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden">
            <div class="absolute top-10 right-[15%] w-14 h-14 bg-angkut-pop border-3 border-angkut-deep rounded-full flex items-center justify-center shadow-cartoon-xs animate-donut-spin">
                <div class="w-5 h-5 bg-white border-2 border-angkut-deep rounded-full"></div>
            </div>
            <div class="absolute top-24 left-[6%] w-9 h-4 bg-angkut-orange border-2 border-angkut-deep rounded-full rotate-45 animate-float"></div>
            <div class="absolute top-48 left-[12%] w-7 h-3 bg-angkut-light border-2 border-angkut-deep rounded-full -rotate-12 animate-float-reverse"></div>
            <div class="absolute bottom-12 left-[4%] w-11 h-5 bg-angkut-pop border-2 border-angkut-deep rounded-full rotate-12 animate-float"></div>
            <div class="absolute top-1/2 right-[4%] w-10 h-4 bg-angkut-medium border-2 border-angkut-deep rounded-full -rotate-45 animate-float-slow"></div>
            <div class="absolute bottom-20 right-[24%] w-8 h-4 bg-angkut-light border-2 border-angkut-deep rounded-full rotate-12 animate-float-reverse"></div>
            
            <svg class="absolute top-16 left-[28%] w-6 h-6 text-angkut-pop animate-pulse" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            <svg class="absolute bottom-28 left-[45%] w-5 h-5 text-angkut-medium animate-bounce" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-angkut-light border-2 border-angkut-deep px-4 py-1.5 rounded-full shadow-cartoon-xs mb-6">
                        <span class="w-2.5 h-2.5 bg-angkut-dark rounded-full animate-ping"></span>
                        <span class="font-fun font-bold text-xs uppercase tracking-widest text-angkut-dark">
                            SISTEM PENGADUAN & PENGANGKUTAN SAMPAH KOTA
                        </span>
                    </div>

                    <h1 class="font-fun text-4xl sm:text-6xl xl:text-7xl font-extrabold text-angkut-deep tracking-wide leading-none uppercase">
                        SAMPAH NUMPUK?<br>
                        <span class="relative inline-block text-angkut-dark">
                            KITA ANGKUT
                            <svg class="absolute -bottom-2 left-0 w-full h-4 text-angkut-pop" viewBox="0 0 200 12" fill="none">
                                <path d="M2 8C50 2 150 2 198 8" stroke="currentColor" stroke-width="5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        SAMPAI BERSIH!
                    </h1>

                    <p class="mt-6 text-base sm:text-xl text-gray-700 font-medium max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Layanan responsif pengangkutan sampah terpadu untuk 18 Kecamatan Palembang. Pilah sampah dari rumah, biarkan armada kebersihan mengangkut dengan cepat, rapi, dan terpercaya.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                        <div class="inline-flex items-center gap-2 bg-angkut-soft text-angkut-deep font-fun font-semibold px-3.5 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs text-xs sm:text-sm">
                            <span class="w-5 h-5 bg-angkut-dark text-white rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                            </span>
                            <span>Respon Cepat</span>
                        </div>
                        <div class="inline-flex items-center gap-2 bg-angkut-soft text-angkut-deep font-fun font-semibold px-3.5 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs text-xs sm:text-sm">
                            <span class="w-5 h-5 bg-angkut-pop text-angkut-deep rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                            </span>
                            <span>18 Kecamatan Palembang</span>
                        </div>
                        <div class="inline-flex items-center gap-2 bg-angkut-soft text-angkut-deep font-fun font-semibold px-3.5 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs text-xs sm:text-sm">
                            <span class="w-5 h-5 bg-angkut-light text-angkut-dark rounded-full flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </span>
                            <span>100% Bebas Biaya</span>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI UTAMA DI HERO -->
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        
                        <!-- TOMBOL LAPOR SEKARANG -->
                        <a href="{{ route('public.report.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-angkut-orange hover:bg-[#e66a24] text-white font-fun text-lg sm:text-xl font-extrabold px-8 py-4 border-4 border-angkut-deep rounded-2xl shadow-cartoon-lg transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-1 active:translate-y-1 active:shadow-cartoon-xs uppercase tracking-wider text-center">
                            <span>Lapor Sekarang</span>
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>

                        <!-- TOMBOL LACAK LAPORAN -->
                        <a href="{{ route('public.tracking.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-angkut-light hover:bg-angkut-pop text-angkut-deep font-fun text-lg sm:text-xl font-extrabold px-8 py-4 border-4 border-angkut-deep rounded-2xl shadow-cartoon-lg transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-1 active:translate-y-1 active:shadow-cartoon-xs uppercase tracking-wider text-center">
                            <span>Lacak Laporan</span>
                            <svg class="w-5 h-5 text-angkut-deep" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- RIGHT COLUMN: PLAYFUL CARTOON ILLUSTRATION -->
                <div class="lg:col-span-5 relative flex justify-center items-center">
                    <div class="absolute w-80 h-80 sm:w-96 sm:h-96 bg-angkut-light border-4 border-angkut-deep rounded-full -z-0 shadow-cartoon-xl"></div>
                    
                    <div class="relative z-10 w-full max-w-md animate-float">
                        <svg class="w-full h-auto drop-shadow-[6px_6px_0px_#1E3011]" viewBox="0 0 500 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M370 0 C370 50 350 90 320 120" stroke="#8DA750" stroke-width="36" stroke-linecap="round"/>
                            <path d="M370 0 C370 50 350 90 320 120" stroke="#1E3011" stroke-width="44" stroke-linecap="round" style="z-index:-1"/>
                            <ellipse cx="320" cy="120" rx="30" ry="16" fill="#FFFFFF" stroke="#1E3011" stroke-width="6" transform="rotate(-20 320 120)"/>
                            <path d="M320 115 C300 130 270 145 265 170 C260 190 280 205 305 195 C315 210 335 210 345 190 C360 200 375 190 375 175 C385 160 375 140 355 130 Z" fill="#FFFFFF" stroke="#1E3011" stroke-width="6"/>
                            <path d="M310 155 C315 165 320 175 322 185" stroke="#1E3011" stroke-width="4" stroke-linecap="round"/>
                            <path d="M335 155 C340 165 345 175 345 185" stroke="#1E3011" stroke-width="4" stroke-linecap="round"/>
                            <path d="M220 220 C220 160 310 160 310 220" stroke="#FFFFFF" stroke-width="14" stroke-linecap="round"/>
                            <path d="M220 220 C220 160 310 160 310 220" stroke="#1E3011" stroke-width="20" stroke-linecap="round" style="z-index:-1"/>
                            <g transform="translate(190, 110) rotate(-10)">
                                <rect x="30" y="50" width="60" height="90" rx="20" fill="#E4EB9C" stroke="#1E3011" stroke-width="6"/>
                                <rect x="45" y="30" width="30" height="22" rx="6" fill="#8DA750" stroke="#1E3011" stroke-width="5"/>
                                <path d="M20 52 C20 30 70 20 95 40 L115 48 C120 50 115 56 100 55 Z" fill="#FF772A" stroke="#1E3011" stroke-width="5"/>
                                <rect x="35" y="65" width="22" height="16" rx="5" fill="#1E3011"/>
                                <rect x="63" y="65" width="22" height="16" rx="5" fill="#1E3011"/>
                                <line x1="57" y1="72" x2="63" y2="72" stroke="#1E3011" stroke-width="4"/>
                                <line x1="38" y1="68" x2="44" y2="76" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                                <line x1="66" y1="68" x2="72" y2="76" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                                <path d="M48 95 C55 102 65 100 70 94" stroke="#1E3011" stroke-width="4" stroke-linecap="round"/>
                            </g>
                            <g transform="translate(110, 170) rotate(-22)">
                                <rect x="20" y="40" width="55" height="80" rx="14" fill="#FFBF00" stroke="#1E3011" stroke-width="6"/>
                                <ellipse cx="47.5" cy="40" rx="27.5" ry="8" fill="#FAFDE8" stroke="#1E3011" stroke-width="5"/>
                                <path d="M45 35 L40 10 L20 0" stroke="#FF772A" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M45 35 L40 10 L20 0" stroke="#1E3011" stroke-width="12" stroke-linecap="round" stroke-linejoin="round" style="z-index:-1"/>
                                <circle cx="36" cy="65" r="6" fill="#1E3011"/>
                                <circle cx="56" cy="65" r="6" fill="#1E3011"/>
                                <circle cx="38" cy="63" r="2" fill="#FFFFFF"/>
                                <circle cx="58" cy="63" r="2" fill="#FFFFFF"/>
                                <path d="M38 78 Q47 90 56 78 Z" fill="#FF772A" stroke="#1E3011" stroke-width="3.5"/>
                            </g>
                            <g transform="translate(260, 160) rotate(15)">
                                <rect x="0" y="0" width="70" height="70" rx="10" fill="#8DA750" stroke="#1E3011" stroke-width="6"/>
                                <rect x="25" y="0" width="20" height="70" fill="#E4EB9C" stroke="#1E3011" stroke-width="3"/>
                                <path d="M15 30 Q22 24 28 30" stroke="#1E3011" stroke-width="4" stroke-linecap="round" fill="none"/>
                                <circle cx="50" cy="28" r="5" fill="#1E3011"/>
                                <circle cx="52" cy="26" r="1.5" fill="#FFFFFF"/>
                                <path d="M28 45 Q36 52 44 45" stroke="#1E3011" stroke-width="4" stroke-linecap="round" fill="none"/>
                            </g>
                            <path d="M140 210 L350 200 L380 430 C380 445 365 455 345 455 L160 455 C140 455 125 440 122 420 Z" fill="#FFFFFF" stroke="#1E3011" stroke-width="7"/>
                            <path d="M140 210 L105 240 L122 420 L145 280 Z" fill="#E4EB9C" stroke="#1E3011" stroke-width="6"/>
                            <g>
                                <rect x="150" y="230" width="190" height="190" rx="16" fill="#8DA750" stroke="#1E3011" stroke-width="5"/>
                                <path d="M140 250 L190 200 M170 280 L230 220 M200 310 L270 240 M230 340 L310 260 M260 370 L340 290 M290 400 L360 330" stroke="#E4EB9C" stroke-width="16" stroke-linecap="round"/>
                            </g>
                            <g transform="translate(380, 260) rotate(25)">
                                <circle cx="20" cy="20" r="16" fill="#FFBF00" stroke="#1E3011" stroke-width="4"/>
                                <circle cx="20" cy="20" r="6" fill="#537B2F" stroke="#1E3011" stroke-width="3"/>
                            </g>
                            <path d="M80 180 L85 195 L100 200 L85 205 L80 220 L75 205 L60 200 L75 195 Z" fill="#FFBF00" stroke="#1E3011" stroke-width="3"/>
                            <path d="M410 180 L413 190 L425 193 L413 197 L410 208 L407 197 L395 193 L407 190 Z" fill="#E4EB9C" stroke="#1E3011" stroke-width="3"/>
                        </svg>

                        <div class="absolute -bottom-6 -left-4 sm:-left-6 bg-angkut-cream text-angkut-deep p-3 border-3 border-angkut-deep rounded-2xl shadow-cartoon rotate-[-3deg] flex items-center gap-3">
                            <div class="w-10 h-10 bg-angkut-pop border-2 border-angkut-deep rounded-xl flex items-center justify-center font-bold text-angkut-deep">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M19 8h-2V5a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h1a3 3 0 0 0 6 0h4a3 3 0 0 0 6 0h1a1 1 0 0 0 1-1v-5a3 3 0 0 0-3-3zm-12 9a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm10 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wider text-angkut-dark">Armada Siaga</p>
                                <p class="font-fun text-sm font-extrabold text-angkut-deep">Gerak Cepat & Tuntas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION: 3 KOTAK SAMPAH (TONG 3D INTERAKTIF) -->
    <!-- ============================================================== -->
@php
    $bins = [
        [
            'key'        => 'organik',
            'tag'        => 'Kotak Hijau',
            'cat'        => 'Kategori 01',
            'title'      => 'Sampah Organik',
            'sub'        => 'Mudah Membusuk & Terurai Alami',
            'def'        => 'Sampah yang berasal dari sisa makhluk hidup (tumbuhan dan hewan). Mudah membusuk dan terurai secara alami oleh mikroorganisme, sehingga bisa diolah menjadi kompos.',
            'examples'   => ['Sisa makanan, nasi, sayur & lauk', 'Kulit buah, biji & sayuran busuk', 'Daun kering & ranting kecil'],
            'tagClass'   => 'bg-angkut-dark text-white',
            'subClass'   => 'text-angkut-dark',
            'exBg'       => 'bg-angkut-soft',
            'checkClass' => 'text-angkut-dark',
            'ry'         => '34deg',   // sudut Y awal (tong kiri menghadap ke tengah)
            'rx'         => '-15deg',  // kemiringan dilihat dari atas
            'ryOpen'     => '14deg',   // sudut Y saat dibuka
            's'          => '.72',     // skala
            /* ====== BARU ====== */
            'tipLabel'   => 'Tips Hijau',
            'tip'        => 'Sisa dapur bisa dijadikan kompos untuk tanaman di rumah.',
        ],
        [
            'key'        => 'daurulang',
            'tag'        => 'Kotak Kuning',
            'cat'        => 'Kategori 02',
            'title'      => 'Sampah Daur Ulang',
            'sub'        => 'Dapat Diolah & Bernilai Ekonomi',
            'def'        => 'Sampah anorganik yang sulit terurai di alam, tetapi masih bisa diolah kembali menjadi produk baru. Jika dipilah bersih dan kering, nilai jualnya lebih tinggi.',
            'examples'   => ['Botol plastik, gelas kemasan & galon', 'Kaleng minuman, kaleng biskuit & seng', 'Kertas, kardus & botol kaca'],
            'tagClass'   => 'bg-angkut-pop text-angkut-deep',
            'subClass'   => 'text-amber-700',
            'exBg'       => 'bg-amber-50',
            'checkClass' => 'text-amber-600',
            'ry'         => '-10deg',
            'rx'         => '-20deg',
            'ryOpen'     => '-2deg',
            's'          => '.82',
            /* ====== BARU ====== */
            'tipLabel'   => 'Tips Cerdas',
            'tip'        => 'Pastikan bersih & kering agar nilai jualnya lebih tinggi.',
        ],
        [
            'key'        => 'b3',
            'tag'        => 'Kotak Merah',
            'cat'        => 'Kategori 03',
            'title'      => 'B3 & Residu Khusus',
            'sub'        => 'Limbah Berbahaya & Butuh Penanganan Khusus',
            'def'        => 'Limbah Bahan Berbahaya dan Beracun (B3) serta residu yang tidak bisa didaur ulang. Bisa mencemari tanah dan air atau melukai petugas, jadi jangan dicampur dengan sampah lain.',
            'examples'   => ['Baterai bekas, aki & limbah elektronik', 'Lampu neon, bohlam pecah & kaca runcing', 'Obat kedaluwarsa & popok bekas'],
            'tagClass'   => 'bg-rose-500 text-white',
            'subClass'   => 'text-rose-600',
            'exBg'       => 'bg-rose-50',
            'checkClass' => 'text-rose-600',
            'ry'         => '-36deg',  // tong kanan menghadap ke tengah
            'rx'         => '-12deg',
            'ryOpen'     => '-14deg',
            's'          => '.72',
            /* ====== BARU ====== */
            'tipLabel'   => 'Tips Aman',
            'tip'        => 'Jangan dicampur, serahkan ke posko B3 terdekat.',
        ],
    ];
@endphp

<section id="pemilahan" class="py-16 lg:py-24 bg-white border-b-4 border-angkut-deep">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-block bg-angkut-light text-angkut-dark font-fun font-bold px-4 py-1.5 border-2 border-angkut-deep rounded-full shadow-cartoon-xs text-xs uppercase tracking-widest mb-3">
                Panduan Pemilahan Sampah
            </div>
            <h2 class="font-fun text-3xl sm:text-5xl font-black text-angkut-deep tracking-wide uppercase">
                Pilah Berdasarkan Warna Kotak Sampah
            </h2>
            <p class="mt-3 text-gray-600 font-semibold text-base sm:text-lg">
                Memilah sampah dari rumah mempermudah proses daur ulang dan mencegah penumpukan di TPS lingkungan.
            </p>
        </div>

        {{-- ====== PANGGUNG 3 TONG ====== --}}
        <div class="bin-row">
            @foreach($bins as $i => $b)
                <div class="bin-item bin-{{ $b['key'] }}"
                     tabindex="0" role="button" aria-expanded="false"
                     aria-label="{{ $b['title'] }}: buka untuk melihat pengertian dan contoh"
                     style="--ry: {{ $b['ry'] }}; --rx: {{ $b['rx'] }}; --ry-open: {{ $b['ryOpen'] }}; --s: {{ $b['s'] }}; --bob-delay: {{ $i * -1.3 }}s;">

                    {{-- ---------- TONG 3D ---------- --}}
                    <div class="bin-figure">
                        <div class="bin-shadow"></div>

                        <div class="bin-rot">
                            {{-- dinding belakang, kiri, kanan, depan --}}
                            <div class="face f-back">
                                <svg viewBox="0 0 190 251" width="190" height="251"><polygon class="p" points="0,0 190,0 165,251 25,251"/></svg>
                            </div>
                            <div class="face f-left">
                                <svg viewBox="0 0 150 251" width="150" height="251"><polygon class="p" points="0,0 150,0 130,251 20,251"/></svg>
                            </div>
                            <div class="face f-right">
                                <svg viewBox="0 0 150 251" width="150" height="251"><polygon class="p" points="0,0 150,0 130,251 20,251"/></svg>
                            </div>
                            <div class="face f-front">
                                <svg viewBox="0 0 190 251" width="190" height="251">
                                    <polygon class="p" points="0,0 190,0 165,251 25,251"/>
                                    <g class="groove">
                                        <line x1="60" y1="28" x2="70" y2="222"/>
                                        <line x1="95" y1="28" x2="95" y2="222"/>
                                        <line x1="130" y1="28" x2="120" y2="222"/>
                                    </g>
                                </svg>

                                {{-- lambang di badan tong --}}
                                <div class="emblem">
                                    @if($b['key'] === 'organik')
                                        <svg viewBox="0 0 56 56"><circle cx="28" cy="28" r="26" fill="#E4EB9C" stroke="#1E3011" stroke-width="4"/><path d="M28 11C41 11 45 24 41 34C37 42 28 46 28 46C28 46 19 42 15 34C11 24 15 11 28 11Z" fill="#537B2F" stroke="#1E3011" stroke-width="3"/><line x1="28" y1="16" x2="28" y2="40" stroke="#E4EB9C" stroke-width="2.5" stroke-linecap="round"/></svg>
                                    @elseif($b['key'] === 'daurulang')
                                        <svg viewBox="0 0 56 56"><circle cx="28" cy="28" r="26" fill="#FFFFFF" stroke="#1E3011" stroke-width="4"/><g transform="translate(13.6,13.6) scale(1.2)"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0 0 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 0 0 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z" fill="#1E3011"/></g></svg>
                                    @else
                                        <svg viewBox="0 0 56 56"><circle cx="28" cy="28" r="26" fill="#FFFFFF" stroke="#1E3011" stroke-width="4"/><path d="M28 11L46 41H10Z" fill="#FFBF00" stroke="#1E3011" stroke-width="3" stroke-linejoin="round"/><line x1="28" y1="21" x2="28" y2="31" stroke="#1E3011" stroke-width="3" stroke-linecap="round"/><circle cx="28" cy="36" r="2" fill="#1E3011"/></svg>
                                    @endif
                                </div>
                            </div>

                            {{-- lubang tong (gelap) --}}
                            <div class="bin-hole"></div>

                            {{-- roda --}}
                            <div class="wheel w-l"><svg viewBox="0 0 38 38"><circle cx="19" cy="19" r="16" fill="#1E3011"/><circle cx="19" cy="19" r="6" fill="var(--hub)"/></svg></div>
                            <div class="wheel w-r"><svg viewBox="0 0 38 38"><circle cx="19" cy="19" r="16" fill="#1E3011"/><circle cx="19" cy="19" r="6" fill="var(--hub)"/></svg></div>

                            {{-- tutup (berengsel di belakang) --}}
                            <div class="lid">
                                <div class="lp lid-back"></div>
                                <div class="lp lid-left"></div>
                                <div class="lp lid-right"></div>
                                <div class="lp lid-top"></div>
                                <div class="lp lid-front"></div>
                            </div>
                        </div>

                        {{-- benda yang melompat keluar saat tutup terbuka --}}
                        <div class="bin-fly" aria-hidden="true">
                            @if($b['key'] === 'organik')
                                <span class="fly" style="--x:-100px; --y:-100px; --r:-18deg; --d:.05s">
                                    <svg viewBox="0 0 48 48"><path d="M8 40C8 18 22 8 42 6c0 22-10 34-30 34z" fill="#8DA750" stroke="#1E3011" stroke-width="3" stroke-linejoin="round"/><path d="M10 38C20 28 28 22 36 14" stroke="#1E3011" stroke-width="3" stroke-linecap="round" fill="none"/></svg>
                                </span>
                                <span class="fly" style="--x:0px; --y:-136px; --r:8deg; --d:.12s">
                                    <svg viewBox="0 0 48 48"><circle cx="24" cy="28" r="15" fill="#E11D48" stroke="#1E3011" stroke-width="3"/><path d="M24 14c0-5 3-8 8-9" stroke="#1E3011" stroke-width="3" stroke-linecap="round" fill="none"/><path d="M30 8c4-1 7 1 8 4-4 1-7-1-8-4z" fill="#8DA750" stroke="#1E3011" stroke-width="2.5" stroke-linejoin="round"/></svg>
                                </span>
                                <span class="fly" style="--x:100px; --y:-100px; --r:20deg; --d:.19s">
                                    <svg viewBox="0 0 48 48"><path d="M8 40C8 18 22 8 42 6c0 22-10 34-30 34z" fill="#537B2F" stroke="#1E3011" stroke-width="3" stroke-linejoin="round"/><path d="M10 38C20 28 28 22 36 14" stroke="#E4EB9C" stroke-width="3" stroke-linecap="round" fill="none"/></svg>
                                </span>
                            @elseif($b['key'] === 'daurulang')
                                <span class="fly" style="--x:-100px; --y:-100px; --r:-14deg; --d:.05s">
                                    <svg viewBox="0 0 48 48"><rect x="17" y="3" width="14" height="8" rx="2" fill="#1E3011"/><path d="M18 11h12l4 11v20a4 4 0 0 1-4 4H18a4 4 0 0 1-4-4V22z" fill="#BFE9FF" stroke="#1E3011" stroke-width="3" stroke-linejoin="round"/><rect x="14" y="27" width="20" height="9" fill="#FFFFFF" stroke="#1E3011" stroke-width="2.5"/></svg>
                                </span>
                                <span class="fly" style="--x:0px; --y:-136px; --r:6deg; --d:.12s">
                                    <svg viewBox="0 0 48 48"><rect x="12" y="6" width="24" height="36" rx="4" fill="#E5E7EB" stroke="#1E3011" stroke-width="3"/><rect x="12" y="18" width="24" height="12" fill="#FF772A" stroke="#1E3011" stroke-width="3"/><line x1="17" y1="11" x2="31" y2="11" stroke="#1E3011" stroke-width="3" stroke-linecap="round"/></svg>
                                </span>
                                <span class="fly" style="--x:100px; --y:-100px; --r:16deg; --d:.19s">
                                    <svg viewBox="0 0 48 48"><rect x="7" y="14" width="34" height="26" rx="3" fill="#D6A56B" stroke="#1E3011" stroke-width="3"/><path d="M7 23h34" stroke="#1E3011" stroke-width="3"/><rect x="19" y="14" width="10" height="9" fill="#F3D9A8" stroke="#1E3011" stroke-width="2.5"/></svg>
                                </span>
                            @else
                                <span class="fly" style="--x:-100px; --y:-100px; --r:-16deg; --d:.05s">
                                    <svg viewBox="0 0 48 48"><rect x="5" y="14" width="33" height="22" rx="4" fill="#FFBF00" stroke="#1E3011" stroke-width="3"/><rect x="38" y="21" width="5" height="8" rx="1" fill="#1E3011"/><path d="M21 18l-5 8h6l-3 8 10-11h-6l4-5z" fill="#1E3011"/></svg>
                                </span>
                                <span class="fly" style="--x:0px; --y:-136px; --r:8deg; --d:.12s">
                                    <svg viewBox="0 0 48 48"><circle cx="24" cy="19" r="13" fill="#FDE68A" stroke="#1E3011" stroke-width="3"/><rect x="18" y="31" width="12" height="10" rx="2" fill="#9CA3AF" stroke="#1E3011" stroke-width="3"/><path d="M20 18c2 3 6 3 8 0" stroke="#1E3011" stroke-width="2.5" stroke-linecap="round" fill="none"/></svg>
                                </span>
                                <span class="fly" style="--x:100px; --y:-100px; --r:18deg; --d:.19s">
                                    <svg viewBox="0 0 48 48"><path d="M24 5L44 40H4z" fill="#FFBF00" stroke="#1E3011" stroke-width="3" stroke-linejoin="round"/><line x1="24" y1="16" x2="24" y2="28" stroke="#1E3011" stroke-width="3.5" stroke-linecap="round"/><circle cx="24" cy="34" r="2.2" fill="#1E3011"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- ---------- INFO: petunjuk ringkas (default) -> pop up melayang (saat dibuka) ---------- --}}
                    <div class="bin-info">
                        <div class="bin-hint text-center pt-1">
                            <div class="inline-flex items-center gap-2">
                                <span class="{{ $b['tagClass'] }} font-fun font-bold text-xs uppercase px-3.5 py-1.5 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs">{{ $b['tag'] }}</span>
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono">{{ $b['cat'] }}</span>
                            </div>
                            <h3 class="font-fun text-xl sm:text-2xl font-extrabold text-angkut-deep mt-2">{{ $b['title'] }}</h3>
                            <p class="text-[11px] font-bold {{ $b['subClass'] }} uppercase tracking-wider mt-0.5 max-w-[16rem] mx-auto">{{ $b['sub'] }}</p>
                            <p class="mt-3 inline-flex items-center gap-2 bg-white border-2 border-dashed border-angkut-deep rounded-full px-3.5 py-1.5 text-[11px] font-bold text-angkut-deep animate-pulse">
                                <span class="hidden md:inline">Arahkan kursor ke tong</span>
                                <span class="md:hidden">Ketuk tong untuk membuka</span>
                            </p>
                        </div>

                        <div class="bin-pop" role="region" aria-label="Penjelasan {{ $b['title'] }}">
                            <div class="relative mt-3 w-full max-w-[22rem] mx-auto">
                                <div class="bg-white border-4 border-angkut-deep rounded-3xl p-4 shadow-cartoon-xl text-left">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="{{ $b['tagClass'] }} font-fun font-bold text-xs uppercase px-3 py-1 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs">{{ $b['tag'] }}</span>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono">{{ $b['cat'] }}</span>
                                    </div>
                                    <h3 class="font-fun text-lg font-extrabold text-angkut-deep mt-2">{{ $b['title'] }}</h3>

                                    <p class="mt-2 text-[11px] font-black uppercase tracking-widest text-gray-500">Pengertian</p>
                                    <p class="mt-0.5 text-[13px] font-semibold text-gray-700 leading-snug">{{ $b['def'] }}</p>

                                    <p class="mt-3 text-[11px] font-black uppercase tracking-widest text-gray-500">Contoh</p>
                                    <div class="mt-1.5 space-y-1.5">
                                        @foreach($b['examples'] as $ex)
                                            <div class="flex items-center gap-2 {{ $b['exBg'] }} px-2.5 py-1.5 border-2 border-angkut-deep rounded-xl text-[11px] leading-tight font-bold text-angkut-deep">
                                                <span class="w-3.5 h-3.5 {{ $b['checkClass'] }} shrink-0"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></span>
                                                <span>{{ $ex }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- panah kecil menunjuk ke tong --}}
                                <span class="bin-arrow" aria-hidden="true"></span>
                            </div>
                        </div>

                        {{-- ====== BARU: dekorasi pengisi ruang kosong ====== --}}
                        <div class="bin-decor" aria-hidden="true">
                            <span class="bin-decor-spark bin-decor-spark-1">✦</span>
                            <span class="bin-decor-spark bin-decor-spark-2">✦</span>
                            <span class="bin-decor-spark bin-decor-spark-3">✦</span>

                            <div class="bin-tip-card">
                                <div class="bin-tip-icon">
                                    @if($b['key'] === 'organik')
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C19 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5s1.75 3.75 1.75 3.75C7 8 17 8 17 8z"/></svg>
                                    @elseif($b['key'] === 'daurulang')
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0 0 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 0 0 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                                    @else
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                                    @endif
                                </div>
                                <div class="bin-tip-content">
                                    <p class="bin-tip-label">{{ $b['tipLabel'] }}</p>
                                    <p class="bin-tip-text">{{ $b['tip'] }}</p>
                                </div>
                            </div>
                        </div>
                        {{-- ====== /BARU ====== --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ====== STYLE TONG 3D ====== --}}
    <style>
        /* warna tiap tong */
        .bin-organik   { --bin:#537B2F; --groove:#3D5B21; --lid:#3D5B21; --lid-top:#8DA750; --hub:#E4EB9C; }
        .bin-daurulang { --bin:#FFBF00; --groove:#D97706; --lid:#D97706; --lid-top:#FDE68A; --hub:#FDE68A; }
        .bin-b3        { --bin:#E11D48; --groove:#9F1239; --lid:#9F1239; --lid-top:#FDA4AF; --hub:#FDA4AF; }

        /* tiga tong sebaris (tablet & desktop), menumpuk di HP */
        .bin-row { display: grid; grid-template-columns: minmax(0, 1fr); gap: 2.5rem 1rem; padding-top: 1.5rem; max-width: 72rem; margin: 0 auto; align-items: start; }
        @media (min-width: 768px)  { .bin-row { grid-template-columns: repeat(3, minmax(0, 1fr)); column-gap: 1.5rem; padding-top: 2.5rem; padding-bottom: 2rem; } }
        @media (min-width: 1024px) { .bin-row { column-gap: 2.5rem; } }

        .bin-item.is-open { z-index: 20; }
        .bin-item { position: relative; cursor: pointer; outline: none; -webkit-tap-highlight-color: transparent; }
        .bin-item:focus-visible { outline: 4px dashed #FFBF00; outline-offset: 6px; border-radius: 28px; }

        /* panggung */
        .bin-figure { position: relative; height: 300px; }
        .bin-shadow {
            position: absolute; left: 50%; bottom: 20px; width: 170px; height: 26px; margin-left: -85px;
            border-radius: 50%;
            background: radial-gradient(ellipse at center, rgba(30,48,17,.38) 0%, rgba(30,48,17,0) 70%);
            transition: transform .6s ease, opacity .6s ease;
        }
        .bin-item.is-open .bin-shadow { transform: scale(1.18); opacity: .9; }

        /* objek 3D: pusat rotasi = tengah tong */
        .bin-rot {
            position: absolute; left: 50%; top: 34px; width: 0; height: 251px;
            transform-style: preserve-3d;
            transform-origin: 0 125px;
            transform: perspective(1100px) translateY(0px) rotateX(var(--rx)) rotateY(var(--ry)) scale(var(--s));
            transition: transform .75s cubic-bezier(.34, 1.4, .64, 1);
            animation: binBob 4.2s ease-in-out infinite;
            animation-delay: var(--bob-delay);
        }
        .bin-item.is-open .bin-rot {
            transform: perspective(1100px) translateY(-6px) rotateX(-22deg) rotateY(var(--ry-open)) scale(calc(var(--s) * 1.08));
            animation-play-state: paused;
        }
        @keyframes binBob { 0%, 100% { translate: 0 0; } 50% { translate: 0 -9px; } }

        /* dinding tong (frustum: atas 190x150, bawah 140x110, tinggi 251) */
        .face { position: absolute; top: 0; left: 0; transform-origin: 50% 0; }
        .face svg { display: block; overflow: visible; }
        .face .p { fill: var(--bin); stroke: #1E3011; stroke-width: 6; stroke-linejoin: round; }
        .face .groove line { stroke: var(--groove); stroke-width: 4; stroke-linecap: round; }

        .f-front { width: 190px; margin-left: -95px; transform: translateZ(75px) rotateX(-4.57deg); }
        .f-back  { width: 190px; margin-left: -95px; transform: rotateY(180deg) translateZ(75px) rotateX(-4.57deg); filter: brightness(.6); }
        .f-left  { width: 150px; margin-left: -75px; transform: rotateY(-90deg) translateZ(95px) rotateX(-5.71deg); filter: brightness(.82); }
        .f-right { width: 150px; margin-left: -75px; transform: rotateY(90deg)  translateZ(95px) rotateX(-5.71deg); filter: brightness(.68); }

        .emblem { position: absolute; left: 50%; top: 42%; width: 68px; height: 68px; margin: -34px 0 0 -34px; }
        .emblem svg { width: 100%; height: 100%; display: block; }

        /* lubang gelap di dalam tong */
        .bin-hole {
            position: absolute; top: 10px; left: 0; width: 168px; height: 130px; margin-left: -84px;
            transform-origin: 50% 0; transform: translateZ(-65px) rotateX(90deg);
            background: radial-gradient(ellipse at 50% 45%, #060b03 0%, #1E3011 85%);
            border: 4px solid #1E3011; border-radius: 12px; box-sizing: border-box;
        }

        /* roda */
        .wheel { position: absolute; top: 0; left: 0; width: 38px; height: 38px; margin: -19px 0 0 -19px; }
        .wheel svg { display: block; width: 100%; height: 100%; }
        .w-l { transform: translate3d(-74px, 240px, -34px) rotateY(90deg); }
        .w-r { transform: translate3d(74px, 240px, -34px) rotateY(90deg); }

        /* tutup: berengsel di tepi belakang (z = -82) */
        .lid {
            position: absolute; left: 0; top: 0; width: 0; height: 0;
            transform-style: preserve-3d;
            transform-origin: 0 0 -82px;
            transition: transform .8s cubic-bezier(.34, 1.56, .64, 1);
        }
        .bin-item.is-open .lid { transform: rotateX(150deg); }

        .lp { position: absolute; top: 0; left: 0; transform-origin: 50% 0; box-sizing: border-box; border: 5px solid #1E3011; }
        .lid-top   { width: 204px; height: 164px; margin-left: -102px; background: var(--lid-top); border-radius: 12px;
                     transform: translate3d(0, -4px, -82px) rotateX(90deg); }
        .lid-top::after { content: ""; position: absolute; left: 50%; bottom: 16px; width: 72px; height: 14px; margin-left: -36px;
                          border-radius: 99px; background: #1E3011; }
        .lid-front { width: 204px; height: 22px; margin-left: -102px; background: var(--lid); border-radius: 0 0 8px 8px;
                     transform: translate3d(0, -4px, 82px); }
        .lid-back  { width: 204px; height: 22px; margin-left: -102px; background: var(--lid); filter: brightness(.6);
                     transform: translate3d(0, -4px, -82px); }
        .lid-left  { width: 164px; height: 22px; margin-left: -82px; background: var(--lid); filter: brightness(.82);
                     transform: translate3d(-102px, -4px, 0) rotateY(-90deg); }
        .lid-right { width: 164px; height: 22px; margin-left: -82px; background: var(--lid); filter: brightness(.68);
                     transform: translate3d(102px, -4px, 0) rotateY(90deg); }

        /* benda yang keluar dari tong */
        .bin-fly { position: absolute; left: 50%; top: 52px; width: 0; height: 0; z-index: 6; pointer-events: none; transform: scale(.8); }
        .fly {
            position: absolute; left: 0; top: 0; width: 46px; height: 46px; margin: -23px 0 0 -23px;
            opacity: 0; transform: translate(0, 40px) scale(.2) rotate(0deg);
            transition: transform .6s cubic-bezier(.34, 1.56, .64, 1) var(--d), opacity .25s ease var(--d);
        }
        .fly svg { display: block; width: 100%; height: 100%; animation: flyBob 2.4s ease-in-out infinite; filter: drop-shadow(2px 2px 0 rgba(30,48,17,.35)); }
        .bin-item.is-open .fly { opacity: 1; transform: translate(var(--x), var(--y)) rotate(var(--r)) scale(1); }
        @keyframes flyBob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-7px); } }

        /* area info: petunjuk ringkas; pop up MELAYANG (tidak menambah tinggi section) */
        .bin-info { position: relative; margin-top: 4px; }
        .bin-hint { transition: opacity .25s ease, transform .25s ease; }
        .bin-item.is-open .bin-hint { opacity: 0; transform: translateY(-8px); pointer-events: none; }

        .bin-pop {
            position: absolute; left: 0; right: 0; top: -34px; z-index: 30;
            opacity: 0; visibility: hidden; pointer-events: none;
            transform: translateY(22px) scale(.92); transform-origin: 50% 0;
            transition: opacity .25s ease, transform .5s cubic-bezier(.34, 1.56, .64, 1), visibility 0s linear .5s;
        }
        .bin-item.is-open .bin-pop {
            opacity: 1; visibility: visible; pointer-events: auto; transform: none;
            transition-delay: .12s, .12s, 0s;
        }

        /* panah penunjuk kartu */
        .bin-arrow {
            position: absolute; top: -13px; left: 50%; margin-left: -12px;
            width: 24px; height: 24px; background: #fff;
            border-top: 4px solid #1E3011; border-left: 4px solid #1E3011;
            border-top-left-radius: 6px; transform: rotate(45deg); z-index: 10;
        }

        /* tablet & desktop: kartu ikut menentukan tinggi section (tidak lagi meluber ke section bawah).
           Petunjuk ringkas dan kartu ditumpuk di satu sel grid, jadi tinggi area = yang tertinggi. */
        /* ====== BARU: tambahkan .bin-decor ke grid-area agar ikut ditumpuk ====== */
        @media (min-width: 768px) {
            .bin-info { display: grid; }
            .bin-hint, .bin-pop, .bin-decor { grid-area: 1 / 1; }
            .bin-pop { position: relative; align-self: start; }
        }

        /* layar kecil: kartu muncul di bawah tong hanya saat dibuka */
        @media (max-width: 767px) {
            .bin-pop { position: static; display: none; }
            .bin-item.is-open .bin-pop { display: block; animation: binPopIn .4s cubic-bezier(.34, 1.56, .64, 1); }
            .bin-item.is-open .bin-hint { display: none; }
        }
        @keyframes binPopIn { from { opacity: 0; transform: translateY(18px) scale(.94); } to { opacity: 1; transform: none; } }

        /* ================================================================
           BARU: DEKORASI PENGISI RUANG KOSONG DI BAWAH KARTU HINT
           (aktif hanya di tablet & desktop, karena di HP tidak ada ruang kosong)
           ================================================================ */
        @media (min-width: 768px) {
            .bin-decor {
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-end;
                padding-bottom: .75rem;
                pointer-events: none;
                transition: opacity .3s ease, transform .3s ease;
            }

            /* garis titik-titik penghubung dari hint ke tip card */
            .bin-decor::before {
                content: "";
                position: absolute;
                top: 58%;
                left: 50%;
                width: 2px;
                height: 34%;
                transform: translateX(-50%);
                background-image: linear-gradient(to bottom, #8DA750 50%, transparent 50%);
                background-size: 2px 9px;
                opacity: .55;
            }

            .bin-item.is-open .bin-decor {
                opacity: 0;
                transform: translateY(10px);
                transition-delay: 0s;
            }
        }

        /* bintang-bintang dekoratif */
        .bin-decor-spark {
            position: absolute;
            color: #FFBF00;
            font-size: 1rem;
            line-height: 1;
            filter: drop-shadow(1px 1px 0 #1E3011);
            animation: sparkPulse 2.4s ease-in-out infinite;
        }
        .bin-decor-spark-1 { top: 60%; left: 12%; animation-delay: 0s; }
        .bin-decor-spark-2 { top: 74%; right: 14%; animation-delay: .7s; }
        .bin-decor-spark-3 { top: 52%; right: 28%; font-size: .7rem; animation-delay: 1.3s; }

        @keyframes sparkPulse {
            0%, 100% { opacity: .35; transform: scale(.85) rotate(0deg); }
            50%      { opacity: 1;   transform: scale(1.15) rotate(25deg); }
        }

        /* kartu tips kecil di dasar kolom */
        .bin-tip-card {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: .65rem;
            width: 100%;
            max-width: 260px;
            padding: .7rem .9rem;
            background: #FAFDE8;
            border: 2.5px solid #1E3011;
            border-radius: .9rem;
            box-shadow: 3px 3px 0 #1E3011;
            text-align: left;
            transform: rotate(-1deg);
        }

        .bin-tip-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 1.9rem;
            height: 1.9rem;
            color: #1E3011;
            background: #FFBF00;
            border: 2px solid #1E3011;
            border-radius: .5rem;
        }
        .bin-tip-icon svg { width: 1rem; height: 1rem; }

        .bin-tip-label {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            font-size: .6rem;
            font-weight: 800;
            line-height: 1;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: #537B2F;
        }
        .bin-tip-text {
            margin: .25rem 0 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .72rem;
            font-weight: 700;
            line-height: 1.35;
            color: #1E3011;
        }

        /* di HP tidak perlu dekorasi karena tidak ada ruang kosong */
        @media (max-width: 767px) {
            .bin-decor { display: none; }
        }

        @media (prefers-reduced-motion: reduce) {
            .bin-rot, .fly svg { animation: none; }
            .bin-rot, .lid, .fly, .bin-pop, .bin-hint { transition-duration: .01s; transition-delay: 0s; }
            /* ====== BARU ====== */
            .bin-decor-spark { animation: none; opacity: .7; }
            .bin-decor { transition-duration: .01s; }
        }
    </style>

    {{-- ====== INTERAKSI: hover (mouse), ketuk (layar sentuh), keyboard ====== --}}
    <script>
        (function () {
            var items = document.querySelectorAll('#pemilahan .bin-item');
            if (!items.length) return;

            function setOpen(el, open) {
                el.classList.toggle('is-open', open);
                el.setAttribute('aria-expanded', open ? 'true' : 'false');
            }
            function closeAll(except) {
                items.forEach(function (i) { if (i !== except) setOpen(i, false); });
            }

            items.forEach(function (el) {
                // Mouse: buka saat kursor masuk, tutup saat keluar
                el.addEventListener('pointerenter', function (e) {
                    if (e.pointerType === 'mouse') { closeAll(el); setOpen(el, true); }
                });
                el.addEventListener('pointerleave', function (e) {
                    if (e.pointerType === 'mouse') setOpen(el, false);
                });

                // Sentuh / pen: ketuk untuk buka-tutup
                el.addEventListener('click', function (e) {
                    if (e.pointerType === 'mouse') return;
                    var willOpen = !el.classList.contains('is-open');
                    closeAll(el);
                    setOpen(el, willOpen);
                });

                // Keyboard
                el.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        var willOpen = !el.classList.contains('is-open');
                        closeAll(el);
                        setOpen(el, willOpen);
                    } else if (e.key === 'Escape') {
                        setOpen(el, false);
                    }
                });
                el.addEventListener('focus', function () {
                    if (el.matches(':focus-visible')) { closeAll(el); setOpen(el, true); }
                });
                el.addEventListener('blur', function () { setOpen(el, false); });
            });

            // Ketuk di luar tong = tutup semua
            document.addEventListener('click', function (e) {
                if (!e.target.closest('#pemilahan .bin-item')) closeAll(null);
            });
        })();
    </script>
</section>

    <!-- ============================================================== -->
    <!-- SECTION: CARA KERJA (4-STEP) -->
    <!-- ============================================================== -->
    <section id="alur" class="alur bg-angkut-soft border-b-4 border-angkut-deep relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

            <div class="alur-head">
                <span class="alur-badge font-fun">Alur Mudah & Transparan</span>
                <h2 class="alur-title font-fun">
                    Cara Kerja
                    <span class="alur-accent">ANGKUT<svg class="alur-squiggle" viewBox="0 0 200 12" preserveAspectRatio="none" fill="none" aria-hidden="true"><path d="M2 8C50 2 150 2 198 8" stroke="#FFBF00" stroke-width="5" stroke-linecap="round"/></svg></span>
                </h2>
                <p class="alur-sub">Empat tahapan terstruktur mulai dari laporan masyarakat hingga lokasi bersih kembali.</p>
            </div>

            <ol class="alur-steps">
                <li class="alur-step" style="--bg:#FFBF00; --fg:#1E3011;">
                    <div class="alur-card">
                        <div class="alur-top">
                            <span class="alur-num font-fun" aria-hidden="true">01</span>
                            <span class="alur-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            </span>
                        </div>
                        <h3 class="alur-card-title font-fun">Foto & Titik Lokasi</h3>
                        <p>Ambil foto sampah di lapangan. Alamat dan titik GPS lokasi akan terdeteksi otomatis dari perangkat ponsel.</p>
                    </div>
                    <span class="alur-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="#1E3011" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                </li>
                <li class="alur-step" style="--bg:#8DA750; --fg:#1E3011;">
                    <div class="alur-card">
                        <div class="alur-top">
                            <span class="alur-num font-fun" aria-hidden="true">02</span>
                            <span class="alur-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            </span>
                        </div>
                        <h3 class="alur-card-title font-fun">Kode Tracking Terbit</h3>
                        <p>Sistem menerbitkan kode unik pelacakan secara instan untuk memantau status pengerjaan laporan.</p>
                    </div>
                    <span class="alur-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="#1E3011" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                </li>
                <li class="alur-step" style="--bg:#FF772A; --fg:#1E3011;">
                    <div class="alur-card">
                        <div class="alur-top">
                            <span class="alur-num font-fun" aria-hidden="true">03</span>
                            <span class="alur-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                            </span>
                        </div>
                        <h3 class="alur-card-title font-fun">Disposisi Armada</h3>
                        <p>Admin memverifikasi laporan lalu mendisposisikan tugas ke tim armada kebersihan di kecamatan terdekat.</p>
                    </div>
                    <span class="alur-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="#1E3011" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                </li>
                <li class="alur-step" style="--bg:#537B2F; --fg:#FFFFFF;">
                    <div class="alur-card">
                        <div class="alur-top">
                            <span class="alur-num font-fun" aria-hidden="true">04</span>
                            <span class="alur-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </span>
                        </div>
                        <h3 class="alur-card-title font-fun">Angkut & Bukti Selesai</h3>
                        <p>Sampah diangkut menuju TPA dan petugas mengunggah foto bukti penyelesaian kerja di lapangan.</p>
                    </div>
                </li>
            </ol>

            <div class="alur-cta-wrap">
                <a href="{{ route('public.report.create') }}" class="alur-cta font-fun">
                    <span>Mulai Lapor Sekarang</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        <style>
            .alur { padding: 4.5rem 0 5rem; overflow: hidden; }
            @media (min-width: 1024px) { .alur { padding: 6rem 0 6.5rem; } }

            /* pola titik: tipis, dan memudar di area judul supaya teks tetap terbaca */
            .alur::before {
                content: ""; position: absolute; inset: 0; pointer-events: none;
                background-image: radial-gradient(rgba(30,48,17,.13) 1.5px, transparent 1.5px);
                background-size: 24px 24px;
                -webkit-mask-image: linear-gradient(to bottom, transparent 0, transparent 22%, #000 55%);
                        mask-image: linear-gradient(to bottom, transparent 0, transparent 22%, #000 55%);
            }

            .alur-head { text-align: center; max-width: 52rem; margin: 0 auto 3.5rem; }
            .alur-badge {
                display: inline-block; background: #fff; color: #537B2F; border: 3px solid #1E3011; border-radius: 999px;
                padding: .4rem 1rem; font-size: .75rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
                box-shadow: 3px 3px 0 #1E3011; transform: rotate(-2deg); margin-bottom: 1.1rem;
            }
            .alur-title { font-size: clamp(2.25rem, 6vw, 3.75rem); line-height: 1.08; font-weight: 900; letter-spacing: .02em; text-transform: uppercase; color: #1E3011; }
            .alur-accent { position: relative; display: inline-block; color: #537B2F; }
            .alur-squiggle { position: absolute; left: 0; bottom: -.3em; width: 100%; height: .3em; }
            .alur-sub { margin: 1.5rem auto 0; max-width: 34rem; font-size: 1.0625rem; font-weight: 600; line-height: 1.6; color: #374151; text-wrap: balance; }

            .alur-steps { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: minmax(0, 1fr); gap: 1.75rem; }
            @media (min-width: 640px)  { .alur-steps { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 2rem; } }
            @media (min-width: 1024px) { .alur-steps { grid-template-columns: repeat(4, minmax(0, 1fr)); } }

            .alur-step { position: relative; display: flex; }
            .alur-card {
                flex: 1; display: flex; flex-direction: column; background: #fff; border: 4px solid #1E3011; border-radius: 1.75rem;
                padding: 1.5rem; box-shadow: 6px 6px 0 #1E3011; transition: transform .25s ease, box-shadow .25s ease;
            }
            .alur-card:hover { transform: translateY(-6px); box-shadow: 10px 10px 0 #1E3011; }

            .alur-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
            .alur-num {
                width: 3.5rem; height: 3.5rem; display: flex; align-items: center; justify-content: center;
                background: var(--bg); color: var(--fg); border: 3px solid #1E3011; border-radius: 1rem;
                font-size: 1.5rem; font-weight: 900; box-shadow: 3px 3px 0 #1E3011;
            }
            .alur-icon {
                width: 3.5rem; height: 3.5rem; display: flex; align-items: center; justify-content: center;
                background: #F4F8D8; color: #537B2F; border: 3px solid #1E3011; border-radius: 1rem;
            }
            .alur-icon svg { width: 1.75rem; height: 1.75rem; }
            .alur-card-title { font-size: 1.375rem; line-height: 1.2; font-weight: 700; color: #1E3011; margin-bottom: .5rem; text-wrap: balance; }
            @media (min-width: 1024px) { .alur-card-title { min-height: 2.4em; } }
            .alur-card p { font-size: .9rem; line-height: 1.65; font-weight: 500; color: #4B5563; }

            /* panah penghubung antar langkah (desktop) */
            .alur-arrow { display: none; }
            @media (min-width: 1024px) {
                .alur-arrow {
                    display: flex; align-items: center; justify-content: center; position: absolute; z-index: 2;
                    right: -2rem; top: 2.5rem; width: 2rem; height: 2rem;
                    background: #FFBF00; border: 3px solid #1E3011; border-radius: 50%;
                }
                .alur-arrow svg { width: .85rem; height: .85rem; }
            }

            .alur-cta-wrap { margin-top: 3.5rem; text-align: center; }
            .alur-cta {
                display: inline-flex; align-items: center; gap: .75rem; min-height: 3rem; background: #537B2F; color: #fff;
                font-weight: 700; font-size: 1.125rem; padding: .875rem 2rem; border: 4px solid #1E3011; border-radius: .875rem;
                box-shadow: 4px 4px 0 #1E3011; transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease;
            }
            .alur-cta:hover { background: #3D5B21; transform: translate(-2px, -2px); box-shadow: 6px 6px 0 #1E3011; }
            .alur-cta:active { transform: translate(3px, 3px); box-shadow: 1px 1px 0 #1E3011; }
            .alur-cta svg { width: 1.25rem; height: 1.25rem; }
        </style>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION: CAKUPAN 18 KECAMATAN -->
    <!-- ============================================================== -->
    <section id="wilayah" class="py-16 bg-white border-b-4 border-angkut-deep text-angkut-deep">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="inline-block bg-angkut-light text-angkut-dark font-fun font-bold px-4 py-1.5 border-2 border-angkut-deep rounded-full shadow-cartoon-xs text-xs uppercase tracking-widest mb-3">
                Jangkauan Wilayah
            </div>
            <h2 class="font-fun text-3xl sm:text-4xl font-extrabold uppercase text-angkut-deep mb-4">
                Melayani 18 Kecamatan Kota Palembang
            </h2>
            <p class="text-gray-600 font-semibold max-w-2xl mx-auto mb-10 text-sm sm:text-base">
                Setiap kecamatan didukung oleh posko dan armada kebersihan aktif untuk menjaga kebersihan lingkungan warga.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-2.5 max-w-5xl mx-auto">
                @forelse($regions as $r)
                    <div class="bg-white border-2 border-angkut-deep px-4 py-2 rounded-2xl font-fun font-bold text-sm text-angkut-deep shadow-cartoon-xs flex items-center gap-2 hover:bg-angkut-light transition-colors">
                        <span class="w-2 h-2 bg-angkut-dark rounded-full"></span>
                        <span>{{ $r->name }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 font-semibold text-sm">Daftar kecamatan belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>
    </main>

    <!-- ============================================================== -->
    <!-- FOOTER -->
    <!-- ============================================================== -->
    <footer class="relative bg-angkut-deep text-white pt-16 pb-12 overflow-hidden border-t-4 border-angkut-deep">
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-angkut-dark/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-angkut-medium/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- MAIN FOOTER CONTENT (4 COLUMNS) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-white/15">
                
                <div class="lg:col-span-4">
                    <div class="flex items-center gap-3 mb-4">
                        <!-- LOGO FOOTER: Latar belakang dihapus, warna logo dibuat terang (putih) agar menyatu dengan footer gelap -->
                        <img src="{{ asset('images/logo.png') }}" alt="ANGKUT Logo" loading="lazy" decoding="async" class="h-10 sm:h-12 w-auto object-contain drop-shadow-md" style="filter: brightness(0) invert(1);">
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-6 font-medium">
                        Sistem terpadu pelayanan pengaduan, edukasi pemilahan, dan pengangkutan sampah mandiri yang menghubungkan warga Palembang dengan posko kebersihan di 18 kecamatan.
                    </p>
                    <div class="inline-flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-xl border border-white/20 text-xs font-semibold text-angkut-light">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></span>
                        <span>Sistem Aktif & Terpantau DLHK</span>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <h4 class="font-fun text-lg font-bold text-angkut-light mb-4 uppercase tracking-wider">Pilah Berdasarkan Warna</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="#pemilahan" class="hover:text-white transition-colors flex items-center gap-2.5"><span class="w-3 h-3 bg-angkut-medium rounded-full border border-white/50"></span><span>Kotak Hijau — Sampah Organik</span></a></li>
                        <li><a href="#pemilahan" class="hover:text-white transition-colors flex items-center gap-2.5"><span class="w-3 h-3 bg-angkut-pop rounded-full border border-white/50"></span><span>Kotak Kuning — Sampah Daur Ulang</span></a></li>
                        <li><a href="#pemilahan" class="hover:text-white transition-colors flex items-center gap-2.5"><span class="w-3 h-3 bg-rose-500 rounded-full border border-white/50"></span><span>Kotak Merah — B3 & Residu Khusus</span></a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="font-fun text-lg font-bold text-angkut-light mb-4 uppercase tracking-wider">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm text-gray-300 font-medium">
                        <li><a href="#hero" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#pemilahan" class="hover:text-white transition-colors">Jenis Sampah</a></li>
                        <li><a href="#alur" class="hover:text-white transition-colors">Cara Kerja</a></li>
                        <li><a href="#wilayah" class="hover:text-white transition-colors">18 Kecamatan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Portal Petugas</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-3">
                    <h4 class="font-fun text-lg font-bold text-angkut-light mb-4 uppercase tracking-wider">Pusat Informasi</h4>
                    <div class="space-y-3 text-sm text-gray-300">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-angkut-pop shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Dinas Lingkungan Hidup & Kebersihan (DLHK) Kota Palembang</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-angkut-pop shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>Operasional Armada: 06.00 - 18.00 WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTTOM COPYRIGHT BAR -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} ANGKUT Palembang. Sistem Pelayanan Pengangkutan & Kebersihan Kota.</p>
                <div class="flex items-center gap-2 font-fun text-sm text-angkut-light">
                    <span class="w-2.5 h-2.5 bg-angkut-pop rounded-full border border-white/50"></span>
                    <span>Bersih Kotaku, Sehat Wargaku</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- TOMBOL KEMBALI KE ATAS -->
    <button type="button" id="to-top" class="to-top" aria-label="Kembali ke atas">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
    </button>

    <script>
        (function () {
            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            /* ---- menu mobile ---- */
            var toggle = document.getElementById('menu-toggle');
            var menu = document.getElementById('mobile-menu');
            function setMenu(open) {
                menu.hidden = !open;
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
                toggle.querySelector('.menu-icon-open').classList.toggle('hidden', open);
                toggle.querySelector('.menu-icon-close').classList.toggle('hidden', !open);
            }
            toggle.addEventListener('click', function () { setMenu(menu.hidden); });
            menu.addEventListener('click', function (e) { if (e.target.closest('a')) setMenu(false); });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !menu.hidden) { setMenu(false); toggle.focus(); }
            });
            document.addEventListener('click', function (e) {
                if (!menu.hidden && !e.target.closest('header')) setMenu(false);
            });
            window.matchMedia('(min-width: 1100px)').addEventListener('change', function (e) { if (e.matches) setMenu(false); });

            /* ---- penanda section aktif di navbar ---- */
            var links = document.querySelectorAll('.nav-link, .mobile-link');
            function activate(id) {
                links.forEach(function (a) {
                    var on = a.getAttribute('href') === '#' + id;
                    a.classList.toggle('is-active', on);
                    if (on) a.setAttribute('aria-current', 'true'); else a.removeAttribute('aria-current');
                });
            }
            if ('IntersectionObserver' in window) {
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (en) { if (en.isIntersecting) activate(en.target.id); });
                }, { rootMargin: '-40% 0px -55% 0px' });
                ['hero', 'pemilahan', 'alur', 'wilayah'].forEach(function (id) {
                    var el = document.getElementById(id);
                    if (el) io.observe(el);
                });
            }

            /* ---- tombol kembali ke atas ---- */
            var topBtn = document.getElementById('to-top');
            function onScroll() { topBtn.classList.toggle('is-visible', window.scrollY > 600); }
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
            topBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
            });
        })();
    </script>
</body>
</html>