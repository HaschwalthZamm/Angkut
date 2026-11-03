<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ANGKUT - Sistem Pengaduan & Pengangkutan Sampah Palembang</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-angkut-deep font-sans selection:bg-angkut-light selection:text-angkut-deep overflow-x-hidden">

    <!-- ========================================== -->
    <!-- NAVBAR (WHITE BG + BOLD OUTLINES) -->
    <!-- ========================================== -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b-4 border-angkut-deep transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- BRAND LOGO -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="relative w-12 h-12 bg-angkut-light border-3 border-angkut-deep rounded-2xl flex items-center justify-center shadow-cartoon transform group-hover:rotate-6 transition-transform">
                    <svg class="w-7 h-7 text-angkut-dark" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 8h-2V5a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h1a3 3 0 0 0 6 0h4a3 3 0 0 0 6 0h1a1 1 0 0 0 1-1v-5a3 3 0 0 0-3-3zm-12 9a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm10 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm2-4h-2V9.5a.5.5 0 0 1 .5-.5h1.76a1.5 1.5 0 0 1 1.44 1.08L20.8 13z"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-angkut-pop border-2 border-angkut-deep rounded-full"></span>
                </div>
                <div>
                    <div class="flex items-baseline">
                        <span class="font-fun text-3xl sm:text-4xl font-extrabold text-angkut-dark tracking-wider drop-shadow-[2px_2px_0px_#1E3011]">
                            ANGKUT
                        </span>
                        <div class="ml-1 w-2.5 h-2.5 bg-angkut-pop border-2 border-angkut-deep rounded-full inline-block animate-bounce"></div>
                    </div>
                    <div class="h-1.5 w-full bg-angkut-pop border border-angkut-deep rounded-full -mt-1"></div>
                </div>
            </a>

            <!-- NAVIGATION LINKS -->
            <nav class="hidden md:flex items-center gap-6 font-fun font-bold text-angkut-deep text-sm">
                <a href="#hero" class="hover:text-angkut-dark transition-colors">Beranda</a>
                <a href="#alur" class="hover:text-angkut-dark transition-colors">Cara Kerja</a>
                <a href="#pemilahan" class="hover:text-angkut-dark transition-colors">Pilah Sampah</a>
                <a href="#wilayah" class="hover:text-angkut-dark transition-colors">Wilayah Layanan</a>
            </nav>

            <!-- ACTION BUTTONS -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" 
                        class="bg-angkut-medium text-white font-fun font-bold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm flex items-center gap-2">
                        <span>Dashboard</span>
                        <span class="w-2 h-2 bg-angkut-light rounded-full border border-angkut-deep"></span>
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                        class="bg-white hover:bg-slate-100 text-angkut-deep font-fun font-bold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" 
                        class="hidden sm:inline-flex bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun font-extrabold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 text-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- HERO SECTION (WHITE BG + PLAYFUL ACCENTS) -->
    <!-- ========================================== -->
    <section id="hero" class="relative pt-10 pb-16 lg:py-20 bg-white border-b-4 border-angkut-deep overflow-hidden">
        
        <!-- Subtle Pattern Grid Background -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#1E3011 2px, transparent 2px); background-size: 24px 24px;"></div>

        <!-- Floating Cartoon Vector Confetti & Shapes (NO EMOJIS) -->
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden">
            <!-- Cartoon Vector Donut (Yellow & Brown Ring like Image 2) -->
            <div class="absolute top-10 right-[15%] w-14 h-14 bg-angkut-pop border-3 border-angkut-deep rounded-full flex items-center justify-center shadow-cartoon-xs animate-donut-spin">
                <div class="w-5 h-5 bg-white border-2 border-angkut-deep rounded-full"></div>
            </div>
            <!-- Floating Bean Shapes -->
            <div class="absolute top-24 left-[6%] w-9 h-4 bg-angkut-orange border-2 border-angkut-deep rounded-full rotate-45 animate-float"></div>
            <div class="absolute top-48 left-[12%] w-7 h-3 bg-angkut-light border-2 border-angkut-deep rounded-full -rotate-12 animate-float-reverse"></div>
            <div class="absolute bottom-12 left-[4%] w-11 h-5 bg-angkut-pop border-2 border-angkut-deep rounded-full rotate-12 animate-float"></div>
            <div class="absolute top-1/2 right-[4%] w-10 h-4 bg-angkut-medium border-2 border-angkut-deep rounded-full -rotate-45 animate-float-slow"></div>
            <div class="absolute bottom-20 right-[24%] w-8 h-4 bg-angkut-light border-2 border-angkut-deep rounded-full rotate-12 animate-float-reverse"></div>
            
            <!-- Sparkle Stars Vector -->
            <svg class="absolute top-16 left-[28%] w-6 h-6 text-angkut-pop animate-pulse" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/>
            </svg>
            <svg class="absolute bottom-28 left-[45%] w-5 h-5 text-angkut-medium animate-bounce" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- LEFT COLUMN: PLAYFUL HEADLINE & CTAS -->
                <div class="lg:col-span-7 text-center lg:text-left">
                    
                    <!-- Sub-badge Pill -->
                    <div class="inline-flex items-center gap-2 bg-angkut-light border-2 border-angkut-deep px-4 py-1.5 rounded-full shadow-cartoon-xs mb-6">
                        <span class="w-2.5 h-2.5 bg-angkut-dark rounded-full animate-ping"></span>
                        <span class="font-fun font-bold text-xs uppercase tracking-widest text-angkut-dark">
                            SISTEM PENGADUAN & PENGANGKUTAN SAMPAH KOTA
                        </span>
                    </div>

                    <!-- GIANT PLAYFUL HEADLINE -->
                    <h1 class="font-fun text-4xl sm:text-6xl xl:text-7xl font-extrabold text-angkut-deep tracking-wide leading-none uppercase">
                        SAMPAH NUMPUK?<br>
                        <span class="relative inline-block text-angkut-dark">
                            KITA ANGKUT
                            <!-- Cartoon Underline -->
                            <svg class="absolute -bottom-2 left-0 w-full h-4 text-angkut-pop" viewBox="0 0 200 12" fill="none">
                                <path d="M2 8C50 2 150 2 198 8" stroke="currentColor" stroke-width="5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        SAMPAI BERSIH!
                    </h1>

                    <!-- SUBTITLE -->
                    <p class="mt-6 text-base sm:text-xl text-gray-700 font-medium max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Layanan responsif pengangkutan sampah terpadu untuk 18 Kecamatan Palembang. Pilah sampah dari rumah, biarkan armada kebersihan mengangkut dengan cepat, rapi, dan terpercaya.
                    </p>

                    <!-- BADGES ROW (NO EMOJIS, USING CLEAN VECTOR ICONS) -->
                    <div class="mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                        <div class="inline-flex items-center gap-2 bg-angkut-soft text-angkut-deep font-fun font-semibold px-3.5 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs text-xs sm:text-sm">
                            <span class="w-5 h-5 bg-angkut-dark text-white rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                                </svg>
                            </span>
                            <span>Respon Cepat</span>
                        </div>
                        <div class="inline-flex items-center gap-2 bg-angkut-soft text-angkut-deep font-fun font-semibold px-3.5 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs text-xs sm:text-sm">
                            <span class="w-5 h-5 bg-angkut-pop text-angkut-deep rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"/>
                                </svg>
                            </span>
                            <span>18 Kecamatan Palembang</span>
                        </div>
                        <div class="inline-flex items-center gap-2 bg-angkut-soft text-angkut-deep font-fun font-semibold px-3.5 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs text-xs sm:text-sm">
                            <span class="w-5 h-5 bg-angkut-light text-angkut-dark rounded-full flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                            </span>
                            <span>100% Bebas Biaya</span>
                        </div>
                    </div>

                    <!-- BIG CTA BUTTONS -->
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="#pemilahan" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun text-lg sm:text-xl font-extrabold px-8 py-4 border-4 border-angkut-deep rounded-2xl shadow-cartoon-lg transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-1 active:translate-y-1 active:shadow-cartoon-xs uppercase tracking-wider text-center">
                            <span>Kenali Jenis Sampah</span>
                            <svg class="w-5 h-5 text-angkut-deep" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>

                        <a href="#alur"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-angkut-light hover:bg-white text-angkut-deep font-fun text-base sm:text-lg font-bold px-6 py-4 border-4 border-angkut-deep rounded-2xl shadow-cartoon-lg transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-1 active:translate-y-1 active:shadow-cartoon-xs text-center">
                            <svg class="w-5 h-5 text-angkut-dark" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polygon points="5 3 19 12 5 21 5 3"/>
                            </svg>
                            <span>Pelajari Cara Kerja</span>
                        </a>
                    </div>

                    <!-- GUEST STATS NOTE -->
                    <div class="mt-8 pt-6 border-t-2 border-slate-200 flex items-center justify-center lg:justify-start gap-6 text-gray-700 text-xs sm:text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-angkut-dark rounded-full"></span>
                            <span>Pemilahan Sampah Terpadu</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-angkut-pop rounded-full border border-angkut-deep"></span>
                            <span>Armada Kebersihan Siaga 18 Kecamatan</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: PLAYFUL CARTOON ILLUSTRATION (NO EMOJIS, PURE VECTOR) -->
                <div class="lg:col-span-5 relative flex justify-center items-center">
                    
                    <!-- Decorative Behind Circle -->
                    <div class="absolute w-80 h-80 sm:w-96 sm:h-96 bg-angkut-light border-4 border-angkut-deep rounded-full -z-0 shadow-cartoon-xl"></div>
                    
                    <!-- CARTOON COMPOSITION CONTAINER -->
                    <div class="relative z-10 w-full max-w-md animate-float">
                        
                        <!-- SVG CARTOON HERO -->
                        <svg class="w-full h-auto drop-shadow-[6px_6px_0px_#1E3011]" viewBox="0 0 500 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                            
                            <!-- Cartoon Arm & White Glove coming from top right -->
                            <path d="M370 0 C370 50 350 90 320 120" stroke="#8DA750" stroke-width="36" stroke-linecap="round"/>
                            <path d="M370 0 C370 50 350 90 320 120" stroke="#1E3011" stroke-width="44" stroke-linecap="round" style="z-index:-1"/>
                            
                            <!-- Glove Cuff -->
                            <ellipse cx="320" cy="120" rx="30" ry="16" fill="#FFFFFF" stroke="#1E3011" stroke-width="6" transform="rotate(-20 320 120)"/>
                            
                            <!-- Big White Cartoon Glove -->
                            <path d="M320 115 C300 130 270 145 265 170 C260 190 280 205 305 195 C315 210 335 210 345 190 C360 200 375 190 375 175 C385 160 375 140 355 130 Z" fill="#FFFFFF" stroke="#1E3011" stroke-width="6"/>
                            <path d="M310 155 C315 165 320 175 322 185" stroke="#1E3011" stroke-width="4" stroke-linecap="round"/>
                            <path d="M335 155 C340 165 345 175 345 185" stroke="#1E3011" stroke-width="4" stroke-linecap="round"/>

                            <!-- Bag Handle -->
                            <path d="M220 220 C220 160 310 160 310 220" stroke="#FFFFFF" stroke-width="14" stroke-linecap="round"/>
                            <path d="M220 220 C220 160 310 160 310 220" stroke="#1E3011" stroke-width="20" stroke-linecap="round" style="z-index:-1"/>
                            
                            <!-- 1. Cool Plastic Bottle with Sunglasses & Cap -->
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

                            <!-- 2. Happy Soda Can with Bendy Straw -->
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

                            <!-- 3. Cute Cardboard Box Smiling -->
                            <g transform="translate(260, 160) rotate(15)">
                                <rect x="0" y="0" width="70" height="70" rx="10" fill="#8DA750" stroke="#1E3011" stroke-width="6"/>
                                <rect x="25" y="0" width="20" height="70" fill="#E4EB9C" stroke="#1E3011" stroke-width="3"/>
                                <path d="M15 30 Q22 24 28 30" stroke="#1E3011" stroke-width="4" stroke-linecap="round" fill="none"/>
                                <circle cx="50" cy="28" r="5" fill="#1E3011"/>
                                <circle cx="52" cy="26" r="1.5" fill="#FFFFFF"/>
                                <path d="M28 45 Q36 52 44 45" stroke="#1E3011" stroke-width="4" stroke-linecap="round" fill="none"/>
                            </g>

                            <!-- THE BIG CARTOON BAG -->
                            <path d="M140 210 L350 200 L380 430 C380 445 365 455 345 455 L160 455 C140 455 125 440 122 420 Z" fill="#FFFFFF" stroke="#1E3011" stroke-width="7"/>
                            <path d="M140 210 L105 240 L122 420 L145 280 Z" fill="#E4EB9C" stroke="#1E3011" stroke-width="6"/>
                            
                            <!-- Front Panel Stripes Pattern -->
                            <g>
                                <rect x="150" y="230" width="190" height="190" rx="16" fill="#8DA750" stroke="#1E3011" stroke-width="5"/>
                                <path d="M140 250 L190 200 M170 280 L230 220 M200 310 L270 240 M230 340 L310 260 M260 370 L340 290 M290 400 L360 330" stroke="#E4EB9C" stroke-width="16" stroke-linecap="round"/>
                            </g>

                            <!-- Donut Vector -->
                            <g transform="translate(380, 260) rotate(25)">
                                <circle cx="20" cy="20" r="16" fill="#FFBF00" stroke="#1E3011" stroke-width="4"/>
                                <circle cx="20" cy="20" r="6" fill="#537B2F" stroke="#1E3011" stroke-width="3"/>
                            </g>

                            <!-- Stars -->
                            <path d="M80 180 L85 195 L100 200 L85 205 L80 220 L75 205 L60 200 L75 195 Z" fill="#FFBF00" stroke="#1E3011" stroke-width="3"/>
                            <path d="M410 180 L413 190 L425 193 L413 197 L410 208 L407 197 L395 193 L407 190 Z" fill="#E4EB9C" stroke="#1E3011" stroke-width="3"/>
                        </svg>

                        <!-- Floating Badge on Illustration -->
                        <div class="absolute -bottom-6 -left-4 sm:-left-6 bg-angkut-cream text-angkut-deep p-3 border-3 border-angkut-deep rounded-2xl shadow-cartoon rotate-[-3deg] flex items-center gap-3">
                            <div class="w-10 h-10 bg-angkut-pop border-2 border-angkut-deep rounded-xl flex items-center justify-center font-bold text-angkut-deep">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 8h-2V5a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h1a3 3 0 0 0 6 0h4a3 3 0 0 0 6 0h1a1 1 0 0 0 1-1v-5a3 3 0 0 0-3-3zm-12 9a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm10 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"/>
                                </svg>
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
    <!-- PLAYFUL RIBBON SECTION (PALETTE LIME ACCENT) -->
    <!-- ============================================================== -->
    <div class="relative bg-angkut-light border-b-4 border-angkut-deep py-8 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
            
            <div class="flex items-center gap-4 text-center md:text-left">
                <div class="w-14 h-14 bg-angkut-pop border-3 border-angkut-deep rounded-2xl flex items-center justify-center text-angkut-deep shadow-cartoon transform -rotate-3">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                        <line x1="12" y1="22.08" x2="12" y2="12"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-fun text-xl sm:text-2xl font-extrabold text-angkut-deep uppercase">
                        Sistem Pengangkutan Terintegrasi Kota Palembang
                    </h3>
                    <p class="text-gray-800 font-medium text-xs sm:text-sm">
                        Pilah dari sumbernya, angkut sesuai kategorinya, wujudkan lingkungan asri bersama.
                    </p>
                </div>
            </div>

            <!-- Stats Counter Pills -->
            <div class="flex flex-wrap items-center justify-center gap-3">
                <div class="bg-white border-3 border-angkut-deep px-5 py-2.5 rounded-2xl shadow-cartoon text-center">
                    <span class="block font-fun text-2xl font-black text-angkut-dark">18</span>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-angkut-deep">Kecamatan</span>
                </div>
                <div class="bg-angkut-cream border-3 border-angkut-deep px-5 py-2.5 rounded-2xl shadow-cartoon text-center">
                    <span class="block font-fun text-2xl font-black text-angkut-orange">< 24 Jam</span>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-angkut-deep">Target SLA</span>
                </div>
                <div class="bg-angkut-pop border-3 border-angkut-deep px-5 py-2.5 rounded-2xl shadow-cartoon text-center">
                    <span class="block font-fun text-2xl font-black text-angkut-deep">100%</span>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-angkut-deep">Gratis</span>
                </div>
            </div>

        </div>
    </div>

    <!-- ============================================================== -->
    <!-- SECTION: 3 KOTAK SAMPAH BERDASARKAN WARNA (REQUEST USER) -->
    <!-- ============================================================== -->
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

            <!-- 3 PLAYFUL CARTOON DUSTBINS GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- ========================================== -->
                <!-- 1. KOTAK HIJAU: SAMPAH ORGANIK -->
                <!-- ========================================== -->
                <div class="bg-white border-4 border-angkut-deep rounded-3xl p-6 sm:p-8 shadow-cartoon-xl hover:-translate-y-2 transition-transform relative flex flex-col justify-between">
                    
                    <div>
                        <!-- Header Pill & Bin Visual -->
                        <div class="flex items-center justify-between mb-6">
                            <span class="bg-angkut-dark text-white font-fun font-bold text-xs uppercase px-3.5 py-1.5 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs">
                                Kotak Hijau
                            </span>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono">Kategori 01</span>
                        </div>

                        <!-- CARTOON GREEN DUSTBIN SVG -->
                        <div class="w-full flex justify-center py-4 bg-angkut-soft/60 border-3 border-angkut-deep rounded-2xl mb-6 shadow-inner">
                            <svg class="w-40 h-44 drop-shadow-[4px_4px_0px_#1E3011]" viewBox="0 0 200 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Bin Lid Handle -->
                                <rect x="85" y="8" width="30" height="12" rx="4" fill="#3D5B21" stroke="#1E3011" stroke-width="4"/>
                                <!-- Bin Lid -->
                                <path d="M20 34 C20 26 35 22 100 22 C165 22 180 26 180 34 L185 44 C185 47 180 50 100 50 C20 50 15 47 15 44 Z" fill="#537B2F" stroke="#1E3011" stroke-width="5"/>
                                <!-- Lid Rim Accent -->
                                <ellipse cx="100" cy="46" rx="80" ry="6" fill="#8DA750" stroke="#1E3011" stroke-width="3"/>
                                <!-- Bin Main Body (Tapered) -->
                                <path d="M30 48 L45 190 C47 200 58 208 70 208 L130 208 C142 208 153 200 155 190 L170 48 Z" fill="#537B2F" stroke="#1E3011" stroke-width="5"/>
                                <!-- Bin Rib Lines for 3D look -->
                                <line x1="68" y1="65" x2="78" y2="185" stroke="#3D5B21" stroke-width="4" stroke-linecap="round"/>
                                <line x1="100" y1="65" x2="100" y2="185" stroke="#3D5B21" stroke-width="4" stroke-linecap="round"/>
                                <line x1="132" y1="65" x2="122" y2="185" stroke="#3D5B21" stroke-width="4" stroke-linecap="round"/>
                                <!-- Cartoon Organic Leaf Badge -->
                                <circle cx="100" cy="120" r="28" fill="#E4EB9C" stroke="#1E3011" stroke-width="4"/>
                                <path d="M100 102 C115 102 120 115 116 128 C112 138 100 142 100 142 C100 142 88 138 84 128 C80 115 85 102 100 102 Z" fill="#537B2F" stroke="#1E3011" stroke-width="3"/>
                                <line x1="100" y1="106" x2="100" y2="136" stroke="#E4EB9C" stroke-width="2.5" stroke-linecap="round"/>
                                <!-- Bin Wheels -->
                                <circle cx="48" cy="202" r="14" fill="#1E3011" stroke="#1E3011" stroke-width="2"/>
                                <circle cx="48" cy="202" r="6" fill="#E4EB9C"/>
                                <circle cx="152" cy="202" r="14" fill="#1E3011" stroke="#1E3011" stroke-width="2"/>
                                <circle cx="152" cy="202" r="6" fill="#E4EB9C"/>
                            </svg>
                        </div>

                        <!-- Title & Description -->
                        <h3 class="font-fun text-2xl font-extrabold text-angkut-deep mb-2">
                            Sampah Organik
                        </h3>
                        <p class="text-xs font-bold text-angkut-dark uppercase tracking-wider mb-4">
                            Mudah Membusuk & Terurai Alami
                        </p>

                        <!-- Items List -->
                        <div class="space-y-2.5 mb-6">
                            <div class="flex items-start gap-2.5 bg-angkut-soft p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-angkut-dark shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Sisa makanan, nasi, sayur & lauk</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-angkut-soft p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-angkut-dark shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Kulit buah, biji & sayuran busuk</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-angkut-soft p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-angkut-dark shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Dedaunan kering, ranting & rumput</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-angkut-soft p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-angkut-dark shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Ampas kopi, serbuk teh & cangkang telur</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Tag -->
                    <div class="p-3 bg-angkut-light border-2 border-angkut-deep rounded-xl text-center">
                        <span class="text-[11px] font-fun font-bold text-angkut-dark">Bisa Diolah Menjadi Kompos & Pupuk Cair</span>
                    </div>

                </div>

                <!-- ========================================== -->
                <!-- 2. KOTAK KUNING: SAMPAH ANORGANIK -->
                <!-- ========================================== -->
                <div class="bg-white border-4 border-angkut-deep rounded-3xl p-6 sm:p-8 shadow-cartoon-xl hover:-translate-y-2 transition-transform relative flex flex-col justify-between">
                    
                    <div>
                        <!-- Header Pill & Bin Visual -->
                        <div class="flex items-center justify-between mb-6">
                            <span class="bg-angkut-pop text-angkut-deep font-fun font-bold text-xs uppercase px-3.5 py-1.5 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs">
                                Kotak Kuning
                            </span>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono">Kategori 02</span>
                        </div>

                        <!-- CARTOON YELLOW DUSTBIN SVG -->
                        <div class="w-full flex justify-center py-4 bg-yellow-50 border-3 border-angkut-deep rounded-2xl mb-6 shadow-inner">
                            <svg class="w-40 h-44 drop-shadow-[4px_4px_0px_#1E3011]" viewBox="0 0 200 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Bin Lid Handle -->
                                <rect x="85" y="8" width="30" height="12" rx="4" fill="#D97706" stroke="#1E3011" stroke-width="4"/>
                                <!-- Bin Lid -->
                                <path d="M20 34 C20 26 35 22 100 22 C165 22 180 26 180 34 L185 44 C185 47 180 50 100 50 C20 50 15 47 15 44 Z" fill="#FFBF00" stroke="#1E3011" stroke-width="5"/>
                                <!-- Lid Rim Accent -->
                                <ellipse cx="100" cy="46" rx="80" ry="6" fill="#FDE68A" stroke="#1E3011" stroke-width="3"/>
                                <!-- Bin Main Body (Tapered) -->
                                <path d="M30 48 L45 190 C47 200 58 208 70 208 L130 208 C142 208 153 200 155 190 L170 48 Z" fill="#FFBF00" stroke="#1E3011" stroke-width="5"/>
                                <!-- Bin Rib Lines -->
                                <line x1="68" y1="65" x2="78" y2="185" stroke="#D97706" stroke-width="4" stroke-linecap="round"/>
                                <line x1="100" y1="65" x2="100" y2="185" stroke="#D97706" stroke-width="4" stroke-linecap="round"/>
                                <line x1="132" y1="65" x2="122" y2="185" stroke="#D97706" stroke-width="4" stroke-linecap="round"/>
                                <!-- Cartoon Recycle Arrow Badge -->
                                <circle cx="100" cy="120" r="28" fill="#FFFFFF" stroke="#1E3011" stroke-width="4"/>
                                <g transform="translate(85, 105) scale(0.7)">
                                    <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0 0 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 0 0 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z" fill="#1E3011"/>
                                </g>
                                <!-- Bin Wheels -->
                                <circle cx="48" cy="202" r="14" fill="#1E3011" stroke="#1E3011" stroke-width="2"/>
                                <circle cx="48" cy="202" r="6" fill="#FDE68A"/>
                                <circle cx="152" cy="202" r="14" fill="#1E3011" stroke="#1E3011" stroke-width="2"/>
                                <circle cx="152" cy="202" r="6" fill="#FDE68A"/>
                            </svg>
                        </div>

                        <!-- Title & Description -->
                        <h3 class="font-fun text-2xl font-extrabold text-angkut-deep mb-2">
                            Sampah Daur Ulang
                        </h3>
                        <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-4">
                            Dapat Diolah & Bernilai Ekonomi
                        </p>

                        <!-- Items List -->
                        <div class="space-y-2.5 mb-6">
                            <div class="flex items-start gap-2.5 bg-amber-50 p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-amber-600 shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Botol plastik, gelas kemasan & galon</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-amber-50 p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-amber-600 shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Kaleng minuman, kaleng biskuit & seng</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-amber-50 p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-amber-600 shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Kardus, kertas buku & koran bekas</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-amber-50 p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-amber-600 shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Botol kaca bening & wadah toples bersih</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Tag -->
                    <div class="p-3 bg-angkut-pop/40 border-2 border-angkut-deep rounded-xl text-center">
                        <span class="text-[11px] font-fun font-bold text-amber-900">Dapat Dijual Kembali ke Bank Sampah Unit</span>
                    </div>

                </div>

                <!-- ========================================== -->
                <!-- 3. KOTAK MERAH: SAMPAH B3 & RESIDU KHUSUS -->
                <!-- ========================================== -->
                <div class="bg-white border-4 border-angkut-deep rounded-3xl p-6 sm:p-8 shadow-cartoon-xl hover:-translate-y-2 transition-transform relative flex flex-col justify-between">
                    
                    <div>
                        <!-- Header Pill & Bin Visual -->
                        <div class="flex items-center justify-between mb-6">
                            <span class="bg-rose-500 text-white font-fun font-bold text-xs uppercase px-3.5 py-1.5 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs">
                                Kotak Merah
                            </span>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider font-mono">Kategori 03</span>
                        </div>

                        <!-- CARTOON RED DUSTBIN SVG -->
                        <div class="w-full flex justify-center py-4 bg-rose-50 border-3 border-angkut-deep rounded-2xl mb-6 shadow-inner">
                            <svg class="w-40 h-44 drop-shadow-[4px_4px_0px_#1E3011]" viewBox="0 0 200 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Bin Lid Handle -->
                                <rect x="85" y="8" width="30" height="12" rx="4" fill="#9F1239" stroke="#1E3011" stroke-width="4"/>
                                <!-- Bin Lid -->
                                <path d="M20 34 C20 26 35 22 100 22 C165 22 180 26 180 34 L185 44 C185 47 180 50 100 50 C20 50 15 47 15 44 Z" fill="#E11D48" stroke="#1E3011" stroke-width="5"/>
                                <!-- Lid Rim Accent -->
                                <ellipse cx="100" cy="46" rx="80" ry="6" fill="#FDA4AF" stroke="#1E3011" stroke-width="3"/>
                                <!-- Bin Main Body (Tapered) -->
                                <path d="M30 48 L45 190 C47 200 58 208 70 208 L130 208 C142 208 153 200 155 190 L170 48 Z" fill="#E11D48" stroke="#1E3011" stroke-width="5"/>
                                <!-- Bin Rib Lines -->
                                <line x1="68" y1="65" x2="78" y2="185" stroke="#9F1239" stroke-width="4" stroke-linecap="round"/>
                                <line x1="100" y1="65" x2="100" y2="185" stroke="#9F1239" stroke-width="4" stroke-linecap="round"/>
                                <line x1="132" y1="65" x2="122" y2="185" stroke="#9F1239" stroke-width="4" stroke-linecap="round"/>
                                <!-- Cartoon Hazard / Warning Badge -->
                                <circle cx="100" cy="120" r="28" fill="#FFFFFF" stroke="#1E3011" stroke-width="4"/>
                                <path d="M100 104 L118 134 H82 Z" fill="#FFBF00" stroke="#1E3011" stroke-width="3" stroke-linejoin="round"/>
                                <circle cx="100" cy="128" r="2" fill="#1E3011"/>
                                <line x1="100" y1="114" x2="100" y2="123" stroke="#1E3011" stroke-width="2.5" stroke-linecap="round"/>
                                <!-- Bin Wheels -->
                                <circle cx="48" cy="202" r="14" fill="#1E3011" stroke="#1E3011" stroke-width="2"/>
                                <circle cx="48" cy="202" r="6" fill="#FDA4AF"/>
                                <circle cx="152" cy="202" r="14" fill="#1E3011" stroke="#1E3011" stroke-width="2"/>
                                <circle cx="152" cy="202" r="6" fill="#FDA4AF"/>
                            </svg>
                        </div>

                        <!-- Title & Description -->
                        <h3 class="font-fun text-2xl font-extrabold text-angkut-deep mb-2">
                            B3 & Residu Khusus
                        </h3>
                        <p class="text-xs font-bold text-rose-600 uppercase tracking-wider mb-4">
                            Limbah Berbahaya & Butuh Penanganan Khusus
                        </p>

                        <!-- Items List -->
                        <div class="space-y-2.5 mb-6">
                            <div class="flex items-start gap-2.5 bg-rose-50 p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-rose-600 shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Baterai bekas, aki & limbah elektronik</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-rose-50 p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-rose-600 shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Lampu neon, bohlam pecah & kaca runcing</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-rose-50 p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-rose-600 shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Kaleng aerosol obat nyamuk & cat semprot</span>
                            </div>
                            <div class="flex items-start gap-2.5 bg-rose-50 p-2.5 border-2 border-angkut-deep rounded-xl text-xs font-bold text-angkut-deep">
                                <span class="w-4 h-4 mt-0.5 text-rose-600 shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                                <span>Popok bekas, pembalut & jarum medis</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Tag -->
                    <div class="p-3 bg-rose-100 border-2 border-angkut-deep rounded-xl text-center">
                        <span class="text-[11px] font-fun font-bold text-rose-800">Jangan Dicampur Dengan Sampah Rumah Tangga Lain</span>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION: CARA KERJA (4-STEP PLAYFUL INFOGRAPHIC - LIGHT BG) -->
    <!-- ============================================================== -->
    <section id="alur" class="py-16 lg:py-24 bg-slate-50 border-b-4 border-angkut-deep relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="inline-block bg-angkut-light text-angkut-dark font-fun font-bold px-4 py-1.5 border-2 border-angkut-deep rounded-full shadow-cartoon-xs text-xs uppercase tracking-widest mb-3">
                    Alur Mudah & Transparan
                </div>
                <h2 class="font-fun text-3xl sm:text-5xl font-black text-angkut-deep tracking-wide uppercase">
                    Cara Kerja ANGKUT
                </h2>
                <p class="mt-3 text-gray-600 font-semibold text-base sm:text-lg">
                    Empat tahapan terstruktur mulai dari laporan masyarakat hingga lokasi bersih kembali.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- STEP 1 -->
                <div class="bg-white border-3 border-angkut-deep rounded-3xl p-6 shadow-cartoon-lg hover:-translate-y-1.5 transition-transform relative group">
                    <div class="absolute -top-5 left-6 bg-angkut-pop border-3 border-angkut-deep w-11 h-11 rounded-2xl font-fun font-black text-xl flex items-center justify-center text-angkut-deep shadow-cartoon-xs">
                        01
                    </div>
                    <div class="mt-4 mb-4 w-12 h-12 bg-angkut-soft border-2 border-angkut-deep rounded-2xl flex items-center justify-center text-angkut-dark shadow-cartoon-xs">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                            <circle cx="12" cy="13" r="4"/>
                        </svg>
                    </div>
                    <h3 class="font-fun text-xl font-bold text-angkut-deep mb-2">Foto & Titik Lokasi</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Ambil foto sampah di lapangan. Alamat dan titik GPS lokasi akan terdeteksi otomatis dari perangkat ponsel.
                    </p>
                </div>

                <!-- STEP 2 -->
                <div class="bg-white border-3 border-angkut-deep rounded-3xl p-6 shadow-cartoon-lg hover:-translate-y-1.5 transition-transform relative group">
                    <div class="absolute -top-5 left-6 bg-angkut-medium border-3 border-angkut-deep w-11 h-11 rounded-2xl font-fun font-black text-xl flex items-center justify-center text-white shadow-cartoon-xs">
                        02
                    </div>
                    <div class="mt-4 mb-4 w-12 h-12 bg-angkut-soft border-2 border-angkut-deep rounded-2xl flex items-center justify-center text-angkut-dark shadow-cartoon-xs">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <h3 class="font-fun text-xl font-bold text-angkut-deep mb-2">Kode Tracking Terbit</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Sistem menerbitkan kode unik pelacakan secara instan untuk memantau status pengerjaan laporan.
                    </p>
                </div>

                <!-- STEP 3 -->
                <div class="bg-white border-3 border-angkut-deep rounded-3xl p-6 shadow-cartoon-lg hover:-translate-y-1.5 transition-transform relative group">
                    <div class="absolute -top-5 left-6 bg-angkut-orange border-3 border-angkut-deep w-11 h-11 rounded-2xl font-fun font-black text-xl flex items-center justify-center text-white shadow-cartoon-xs">
                        03
                    </div>
                    <div class="mt-4 mb-4 w-12 h-12 bg-angkut-soft border-2 border-angkut-deep rounded-2xl flex items-center justify-center text-angkut-dark shadow-cartoon-xs">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect x="1" y="3" width="15" height="13"/>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                            <circle cx="5.5" cy="18.5" r="2.5"/>
                            <circle cx="18.5" cy="18.5" r="2.5"/>
                        </svg>
                    </div>
                    <h3 class="font-fun text-xl font-bold text-angkut-deep mb-2">Disposisi Armada</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Admin memverifikasi laporan lalu mendisposisikan tugas ke tim armada kebersihan di kecamatan terdekat.
                    </p>
                </div>

                <!-- STEP 4 -->
                <div class="bg-white border-3 border-angkut-deep rounded-3xl p-6 shadow-cartoon-lg hover:-translate-y-1.5 transition-transform relative group">
                    <div class="absolute -top-5 left-6 bg-angkut-dark border-3 border-angkut-deep w-11 h-11 rounded-2xl font-fun font-black text-xl flex items-center justify-center text-white shadow-cartoon-xs">
                        04
                    </div>
                    <div class="mt-4 mb-4 w-12 h-12 bg-angkut-soft border-2 border-angkut-deep rounded-2xl flex items-center justify-center text-angkut-dark shadow-cartoon-xs">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <h3 class="font-fun text-xl font-bold text-angkut-deep mb-2">Angkut & Bukti Selesai</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Sampah diangkut menuju TPA dan petugas mengunggah foto bukti penyelesaian kerja di lapangan.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION: CAKUPAN 18 KECAMATAN (PALEMBANG) -->
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
                @foreach($regions as $r)
                    <div class="bg-white border-2 border-angkut-deep px-4 py-2 rounded-2xl font-fun font-bold text-sm text-angkut-deep shadow-cartoon-xs flex items-center gap-2 hover:bg-angkut-light transition-colors">
                        <span class="w-2 h-2 bg-angkut-dark rounded-full"></span>
                        <span>{{ $r->name }}</span>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- BEAUTIFIED PLAYFUL FOOTER (PERCANTIK SESUAI PERMINTAAN USER) -->
    <!-- ============================================================== -->
    <footer class="relative bg-angkut-deep text-white pt-16 pb-12 overflow-hidden border-t-4 border-angkut-deep">
        
        <!-- Subtle Background Decorative Graphic -->
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-angkut-dark/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-angkut-medium/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- TOP CTA BANNER INSIDE FOOTER -->
            <div class="bg-gradient-to-r from-angkut-dark to-angkut-medium border-4 border-white/90 rounded-3xl p-6 sm:p-10 mb-16 shadow-cartoon-xl flex flex-col lg:flex-row items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-2 bg-angkut-pop text-angkut-deep font-fun text-xs font-black uppercase px-3.5 py-1 rounded-full border-2 border-angkut-deep shadow-cartoon-xs mb-3">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2zm0-6h2v4h-2z"/>
                        </svg>
                        Peduli Lingkungan Sejak Dini
                    </span>
                    <h3 class="font-fun text-2xl sm:text-4xl font-extrabold text-white tracking-wide uppercase drop-shadow-[2px_2px_0px_#1E3011]">
                        Mulai Pilah Sampah Dari Rumahmu Sekarang!
                    </h3>
                    <p class="mt-2 text-angkut-cream text-sm sm:text-base max-w-xl font-medium">
                        Satu langkah kecil memilah sampah organik, anorganik, dan B3 berdampak besar bagi kelestarian Kota Palembang.
                    </p>
                </div>
                <div class="shrink-0 flex items-center gap-3">
                    <a href="#pemilahan" class="inline-flex items-center gap-2 bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun text-base font-extrabold px-6 py-3.5 border-3 border-angkut-deep rounded-2xl shadow-cartoon transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 active:translate-x-0.5 active:translate-y-0.5 whitespace-nowrap">
                        <span>Lihat Panduan Warna</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- MAIN FOOTER CONTENT (4 COLUMNS) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-white/15">
                
                <!-- COLUMN 1: BRAND & MISSION (4 COLS) -->
                <div class="lg:col-span-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-angkut-light border-3 border-white rounded-2xl flex items-center justify-center text-angkut-dark shadow-cartoon-xs">
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 8h-2V5a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h1a3 3 0 0 0 6 0h4a3 3 0 0 0 6 0h1a1 1 0 0 0 1-1v-5a3 3 0 0 0-3-3zm-12 9a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm10 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-fun text-3xl font-extrabold tracking-wider text-white">ANGKUT</span>
                            <div class="h-1 w-full bg-angkut-pop rounded-full mt-0.5"></div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-6 font-medium">
                        Sistem terpadu pelayanan pengaduan, edukasi pemilahan, dan pengangkutan sampah mandiri yang menghubungkan warga Palembang dengan posko kebersihan di 18 kecamatan.
                    </p>
                    <div class="inline-flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-xl border border-white/20 text-xs font-semibold text-angkut-light">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></span>
                        <span>Sistem Aktif & Terpantau DLHK</span>
                    </div>
                </div>

                <!-- COLUMN 2: PANDUAN WARNA KOTAK (3 COLS) -->
                <div class="lg:col-span-3">
                    <h4 class="font-fun text-lg font-bold text-angkut-light mb-4 uppercase tracking-wider">
                        Pilah Berdasarkan Warna
                    </h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li>
                            <a href="#pemilahan" class="hover:text-white transition-colors flex items-center gap-2.5">
                                <span class="w-3 h-3 bg-angkut-medium rounded-full border border-white/50"></span>
                                <span>Kotak Hijau — Sampah Organik</span>
                            </a>
                        </li>
                        <li>
                            <a href="#pemilahan" class="hover:text-white transition-colors flex items-center gap-2.5">
                                <span class="w-3 h-3 bg-angkut-pop rounded-full border border-white/50"></span>
                                <span>Kotak Kuning — Sampah Daur Ulang</span>
                            </a>
                        </li>
                        <li>
                            <a href="#pemilahan" class="hover:text-white transition-colors flex items-center gap-2.5">
                                <span class="w-3 h-3 bg-rose-500 rounded-full border border-white/50"></span>
                                <span>Kotak Merah — B3 & Residu Khusus</span>
                            </a>
                        </li>
                        <li>
                            <a href="#alur" class="hover:text-white transition-colors flex items-center gap-2.5">
                                <span class="w-3 h-3 bg-sky-400 rounded-full border border-white/50"></span>
                                <span>Alur 4 Langkah Pengangkutan</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- COLUMN 3: TAUTAN KILAT (2 COLS) -->
                <div class="lg:col-span-2">
                    <h4 class="font-fun text-lg font-bold text-angkut-light mb-4 uppercase tracking-wider">
                        Navigasi
                    </h4>
                    <ul class="space-y-2.5 text-sm text-gray-300 font-medium">
                        <li><a href="#hero" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#pemilahan" class="hover:text-white transition-colors">Jenis Sampah</a></li>
                        <li><a href="#alur" class="hover:text-white transition-colors">Cara Kerja</a></li>
                        <li><a href="#wilayah" class="hover:text-white transition-colors">18 Kecamatan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Portal Petugas</a></li>
                    </ul>
                </div>

                <!-- COLUMN 4: INFO LAYANAN & POSKO (3 COLS) -->
                <div class="lg:col-span-3">
                    <h4 class="font-fun text-lg font-bold text-angkut-light mb-4 uppercase tracking-wider">
                        Pusat Informasi
                    </h4>
                    <div class="space-y-3 text-sm text-gray-300">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-angkut-pop shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Dinas Lingkungan Hidup & Kebersihan (DLHK) Kota Palembang</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-angkut-pop shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span>Operasional Armada: 06.00 - 18.00 WIB</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-angkut-pop shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Posko Pengaduan: (0711) 351234</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- BOTTOM COPYRIGHT BAR -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400">
                <p>© {{ date('Y') }} ANGKUT Palembang. Sistem Pelayanan Pengangkutan & Kebersihan Kota.</p>
                <div class="flex items-center gap-2 font-fun text-sm text-angkut-light">
                    <span class="w-2.5 h-2.5 bg-angkut-pop rounded-full border border-white/50"></span>
                    <span>Bersih Kotaku, Sehat Wargaku</span>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
