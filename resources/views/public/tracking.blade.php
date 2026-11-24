<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lacak Laporan - ANGKUT Palembang</title>
    <meta name="description" content="Pantau status laporan sampah Anda di ANGKUT Palembang cukup dengan nomor HP pelapor.">
    <meta name="theme-color" content="#1E3011">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --deep: #1E3011; --green: #537B2F; --green-d: #3D5B21; --pop: #FFBF00; --orange: #FF772A; --soft: #F4F8D8; --light: #E4EB9C; }

        .trk-body {
            margin: 0; min-height: 100vh; display: flex; flex-direction: column; color: var(--deep);
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #F8FBEA;
            background-image: radial-gradient(rgba(30,48,17,.07) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }
        .trk-body a { text-decoration: none; }
        .trk-body a:focus-visible, .trk-body button:focus-visible { outline: 3px solid var(--deep); outline-offset: 3px; }

        /* ---------- header ---------- */
        .trk-header { position: sticky; top: 0; z-index: 40; background: rgba(255,255,255,.95); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); border-bottom: 4px solid var(--deep); }
        .trk-header-in { max-width: 72rem; margin: 0 auto; padding: 0 1rem; height: 4.5rem; display: flex; align-items: center; justify-content: space-between; gap: .75rem; }
        @media (min-width: 640px) { .trk-header-in { padding: 0 1.5rem; height: 5rem; } }
        .trk-logo img { display: block; height: 2.5rem; width: auto; object-fit: contain; transition: transform .2s ease; }
        .trk-logo:hover img { transform: translateY(-2px) scale(1.04); }
        @media (min-width: 640px) { .trk-logo img { height: 3.25rem; } }
        .trk-actions { display: flex; align-items: center; gap: .625rem; }
        .trk-link { display: none; padding: .5rem .25rem; font-weight: 700; font-size: .875rem; color: var(--deep); }
        .trk-link:hover { color: var(--green); }
        @media (min-width: 640px) { .trk-link { display: inline-block; } }
        .trk-btn {
            display: inline-flex; align-items: center; justify-content: center; min-height: 2.75rem; padding: .5rem 1rem;
            font-weight: 800; font-size: .875rem; color: var(--deep); background: #fff;
            border: 3px solid var(--deep); border-radius: .75rem; box-shadow: 3px 3px 0 var(--deep);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .trk-btn:hover { transform: translate(-1px, -1px); box-shadow: 5px 5px 0 var(--deep); }
        .trk-btn:active { transform: translate(2px, 2px); box-shadow: 1px 1px 0 var(--deep); }
        .trk-btn--orange { background: var(--orange); color: #fff; }
        .trk-btn--green { background: var(--green); color: #fff; }

        /* ---------- konten ---------- */
        .trk-main { flex: 1; padding: 2.5rem 1rem 4rem; }
        @media (min-width: 640px) { .trk-main { padding-top: 3.5rem; } }
        .trk-wrap { max-width: 44rem; margin: 0 auto; }

        .trk-intro { text-align: center; margin-bottom: 1.75rem; }
        .trk-pill {
            display: inline-block; margin-bottom: .9rem; padding: .3rem .9rem; background: var(--light); color: var(--green);
            font-size: .7rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            border: 2px solid var(--deep); border-radius: 999px; box-shadow: 2px 2px 0 var(--deep);
        }
        .trk-title { margin: 0; font-size: clamp(2rem, 6vw, 3rem); line-height: 1.1; font-weight: 800; }
        .trk-title span { position: relative; display: inline-block; color: var(--green); }
        .trk-title svg { position: absolute; left: 0; bottom: -.22em; width: 100%; height: .28em; }
        .trk-lead { margin: 1rem auto 0; max-width: 30rem; font-size: 1rem; font-weight: 600; line-height: 1.6; color: #4B5563; }

        /* notifikasi sukses */
        .trk-flash {
            display: flex; align-items: center; gap: .75rem; margin-bottom: 1.25rem; padding: .9rem 1.1rem;
            background: #ECFDF3; color: #14532D; font-weight: 700;
            border: 3px solid var(--deep); border-radius: 1rem; box-shadow: 4px 4px 0 var(--deep);
        }
        .trk-flash svg { flex: none; width: 1.5rem; height: 1.5rem; }

        /* form pencarian */
        .trk-search { background: #fff; border: 4px solid var(--deep); border-radius: 1.5rem; box-shadow: 6px 6px 0 var(--deep); padding: 1.25rem; }
        @media (min-width: 640px) { .trk-search { padding: 1.75rem; } }
        .trk-label { display: block; margin-bottom: .5rem; font-weight: 700; }
        .trk-row { display: flex; flex-direction: column; gap: .75rem; }
        @media (min-width: 640px) { .trk-row { flex-direction: row; } }
        .trk-field { position: relative; flex: 1; }
        .trk-field svg { position: absolute; left: 1rem; top: 50%; width: 1.25rem; height: 1.25rem; transform: translateY(-50%); color: var(--green); pointer-events: none; }
        input.trk-input {
            display: block; width: 100%; height: 3.25rem; box-sizing: border-box; padding: 0 1rem 0 2.9rem;
            font: 700 1.0625rem/1 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: var(--deep); background: #fff;
            border: 3px solid var(--deep); border-radius: .75rem; box-shadow: none;
        }
        input.trk-input::placeholder { color: #9CA3AF; font-weight: 600; }
        input.trk-input:focus { outline: 3px solid var(--pop); outline-offset: 2px; border-color: var(--green); box-shadow: none; }
        input.trk-input.has-error { border-color: #DC2626; }
        .trk-submit {
            display: inline-flex; align-items: center; justify-content: center; gap: .5rem; height: 3.25rem; padding: 0 1.5rem;
            font-weight: 700; font-size: 1.0625rem; color: #fff; background: var(--green); cursor: pointer;
            border: 3px solid var(--deep); border-radius: .75rem; box-shadow: 3px 3px 0 var(--deep);
            transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease;
        }
        .trk-submit:hover { background: var(--green-d); transform: translate(-1px, -1px); box-shadow: 5px 5px 0 var(--deep); }
        .trk-submit:active { transform: translate(2px, 2px); box-shadow: 1px 1px 0 var(--deep); }
        .trk-submit[disabled] { opacity: .75; cursor: progress; transform: none; box-shadow: 3px 3px 0 var(--deep); }
        .trk-submit svg { width: 1.25rem; height: 1.25rem; }
        .trk-error { display: flex; align-items: center; gap: .4rem; margin: .6rem 0 0; font-size: .875rem; font-weight: 700; color: #B91C1C; }
        .trk-error svg { flex: none; width: 1.1rem; height: 1.1rem; }
        .trk-hint { margin: .75rem 0 0; font-size: .8125rem; font-weight: 600; color: #6B7280; }

        /* hasil */
        .trk-results { display: grid; gap: 1.25rem; margin-top: 2rem; }
        .trk-results-title { display: flex; align-items: center; gap: .6rem; margin: 0 0 .25rem; font-size: 1.25rem; font-weight: 700; }
        .trk-count {
            display: inline-flex; align-items: center; justify-content: center; min-width: 1.9rem; height: 1.9rem; padding: 0 .5rem;
            font-size: .95rem; font-weight: 800; background: var(--pop); border: 2px solid var(--deep); border-radius: .6rem;
        }
        .trk-card { overflow: hidden; background: #fff; border: 4px solid var(--deep); border-radius: 1.5rem; box-shadow: 5px 5px 0 var(--deep); }
        .trk-card-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: .75rem; padding: .9rem 1.1rem; background: var(--soft); border-bottom: 4px solid var(--deep); }
        .trk-code-row { display: flex; align-items: center; gap: .5rem; }
        .trk-code { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: .9rem; font-weight: 800; letter-spacing: .02em; }
        .trk-copy {
            display: inline-flex; align-items: center; gap: .3rem; min-height: 1.75rem; padding: 0 .55rem; cursor: pointer;
            font: 800 .7rem/1 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: var(--deep); background: #fff;
            border: 2px solid var(--deep); border-radius: .5rem;
        }
        .trk-copy svg { width: .85rem; height: .85rem; }
        .trk-copy.is-copied { background: #DCFCE7; }
        .trk-date { margin: .15rem 0 0; font-size: .75rem; font-weight: 600; color: #6B7280; }

        .trk-status { display: inline-flex; align-items: center; gap: .4rem; padding: .3rem .75rem; font-size: .75rem; font-weight: 800; border: 2px solid; border-radius: .75rem; }
        .trk-status::before { content: ""; width: .5rem; height: .5rem; border-radius: 50%; background: currentColor; }
        .trk-st-yellow { background: #FEF9C3; color: #854D0E; border-color: #FDE047; }
        .trk-st-blue   { background: #DBEAFE; color: #1E40AF; border-color: #93C5FD; }
        .trk-st-red    { background: #FEE2E2; color: #991B1B; border-color: #FCA5A5; }
        .trk-st-indigo { background: #E0E7FF; color: #3730A3; border-color: #A5B4FC; }
        .trk-st-orange { background: #FFEDD5; color: #9A3412; border-color: #FDBA74; }
        .trk-st-green  { background: #DCFCE7; color: #166534; border-color: #86EFAC; }
        .trk-st-gray   { background: #F1F5F9; color: #1E293B; border-color: #CBD5E1; }

        .trk-card-body { display: grid; gap: 1rem; padding: 1.25rem 1.1rem 1.4rem; }
        .trk-card-title { margin: 0; font-size: 1.25rem; font-weight: 700; line-height: 1.25; }
        .trk-desc {
            margin: .35rem 0 0; font-size: .9rem; line-height: 1.6; color: #4B5563;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        }
        .trk-meta { display: grid; grid-template-columns: minmax(0, 1fr); gap: .6rem; margin: 0; padding: .75rem .9rem; background: #F8FAFC; border: 2px solid #E2E8F0; border-radius: .9rem; }
        @media (min-width: 640px) { .trk-meta { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        .trk-meta dt { font-size: .68rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: #6B7280; }
        .trk-meta dd { margin: .1rem 0 0; font-size: .9rem; font-weight: 700; }

        .trk-tl-label { margin: 0; font-size: .68rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: #6B7280; }
        .trk-timeline { display: grid; gap: .85rem; margin: .6rem 0 0 .4rem; padding: 0 0 0 1.1rem; list-style: none; border-left: 4px solid var(--light); }
        .trk-timeline li { position: relative; }
        .trk-timeline li::before {
            content: ""; position: absolute; left: calc(-1.1rem - 9px); top: .15rem; width: 14px; height: 14px;
            background: #fff; border: 3px solid var(--deep); border-radius: 50%;
        }
        .trk-timeline li:first-child::before { background: var(--pop); }
        .trk-tl-status { margin: 0; font-size: .85rem; font-weight: 800; color: var(--green-d); }
        .trk-tl-time { margin: .1rem 0 0; font-size: .72rem; font-weight: 600; color: #6B7280; }

        /* kosong */
        .trk-empty { margin-top: 2rem; padding: 2rem 1.25rem; text-align: center; background: #fff; border: 4px solid var(--deep); border-radius: 1.5rem; box-shadow: 5px 5px 0 var(--deep); }
        .trk-empty-icon { display: flex; align-items: center; justify-content: center; width: 3.5rem; height: 3.5rem; margin: 0 auto 1rem; color: var(--green); background: var(--soft); border: 3px solid var(--deep); border-radius: 1rem; }
        .trk-empty-icon svg { width: 1.75rem; height: 1.75rem; }
        .trk-empty h2 { margin: 0; font-size: 1.35rem; font-weight: 700; }
        .trk-empty p { margin: .5rem auto 1.25rem; max-width: 24rem; font-size: .9rem; font-weight: 600; line-height: 1.6; color: #4B5563; }

        /* footer */
        .trk-footer { padding: 1.25rem 1rem; text-align: center; font-size: .8125rem; font-weight: 600; color: #4B5563; background: #fff; border-top: 4px solid var(--deep); }
        .trk-footer a { color: var(--green); font-weight: 800; text-decoration: underline !important; text-underline-offset: 3px; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body class="trk-body">

    <!-- ========== HEADER ========== -->
    <header class="trk-header">
        <div class="trk-header-in">
            <a href="{{ url('/') }}" class="trk-logo" aria-label="ANGKUT - Beranda">
                <img src="{{ asset('images/logo.png') }}" alt="ANGKUT Logo" decoding="async">
            </a>

            <div class="trk-actions">
                <a href="{{ url('/') }}" class="trk-link font-fun">Beranda</a>
                <a href="{{ route('public.report.create') }}" class="trk-btn trk-btn--orange font-fun">Lapor</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="trk-btn trk-btn--green font-fun">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="trk-btn font-fun">Masuk</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ========== KONTEN ========== -->
    <main class="trk-main">
        <div class="trk-wrap">

            <div class="trk-intro">
                <span class="trk-pill font-fun">Pantau Status Laporan</span>
                <h1 class="trk-title font-fun">
                    Lacak <span>Laporan<svg viewBox="0 0 200 12" preserveAspectRatio="none" fill="none" aria-hidden="true"><path d="M2 8C50 2 150 2 198 8" stroke="#FFBF00" stroke-width="5" stroke-linecap="round"/></svg></span> Anda
                </h1>
                <p class="trk-lead">Masukkan nomor HP yang Anda gunakan saat melapor untuk melihat perkembangan laporan Anda.</p>
            </div>

            @if(session('success'))
                <div class="trk-flash font-fun" role="status">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M8 12.5l3 3 5-6"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form Pencarian -->
            <form action="{{ route('public.tracking.track') }}" method="POST" class="trk-search" id="trk-form">
                @csrf
                <label for="phone" class="trk-label font-fun">Nomor HP Pelapor</label>
                <div class="trk-row">
                    <div class="trk-field">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>
                        <input type="tel" inputmode="tel" autocomplete="tel" name="phone" id="phone" value="{{ $phone }}" required
                               class="trk-input @if($errors->has('phone')) has-error @endif"
                               placeholder="0812xxxxxxxx"
                               aria-describedby="phone-hint @if($errors->has('phone')) phone-error @endif"
                               @if($errors->has('phone')) aria-invalid="true" @endif>
                    </div>
                    <button type="submit" class="trk-submit font-fun" id="trk-submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                        <span>Cari Laporan</span>
                    </button>
                </div>
                @if($errors->has('phone'))
                    <p class="trk-error" id="phone-error" role="alert">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 7v6M12 16.5v.5"/></svg>
                        <span>{{ $errors->first('phone') }}</span>
                    </p>
                @endif
                <p class="trk-hint" id="phone-hint">Gunakan nomor yang sama seperti saat membuat laporan.</p>
            </form>

            <!-- Hasil Pencarian (Daftar Laporan) -->
            @if($reports->count() > 0)
                <section class="trk-results" aria-live="polite">
                    <h2 class="trk-results-title font-fun">
                        Ditemukan <span class="trk-count">{{ $reports->count() }}</span> Laporan
                    </h2>

                    @foreach($reports as $report)
                        @php
                            $statusKey = $report->status->color();
                            $statusKey = in_array($statusKey, ['yellow', 'blue', 'red', 'indigo', 'orange', 'green', 'gray'], true) ? $statusKey : 'gray';
                        @endphp
                        <article class="trk-card">
                            <div class="trk-card-head">
                                <div>
                                    <div class="trk-code-row">
                                        <span class="trk-code">{{ $report->tracking_code }}</span>
                                        <button type="button" class="trk-copy" data-code="{{ $report->tracking_code }}" aria-label="Salin kode {{ $report->tracking_code }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 0 1 2-2h9"/></svg>
                                            <span class="trk-copy-text">Salin</span>
                                        </button>
                                    </div>
                                    <p class="trk-date">{{ $report->created_at->format('d M Y, H:i') }} WIB</p>
                                </div>
                                <span class="trk-status trk-st-{{ $statusKey }}">{{ $report->status->label() }}</span>
                            </div>

                            <div class="trk-card-body">
                                <div>
                                    <h3 class="trk-card-title font-fun">{{ $report->title }}</h3>
                                    <p class="trk-desc">{{ $report->description }}</p>
                                </div>

                                <dl class="trk-meta">
                                    <div>
                                        <dt>Kategori</dt>
                                        <dd>{{ $report->category->name }}</dd>
                                    </div>
                                    <div>
                                        <dt>Tim Penanganan</dt>
                                        <dd>{{ $report->activeAssignment?->team?->name ?? 'Belum Ditugaskan' }}</dd>
                                    </div>
                                </dl>

                                <!-- Timeline ringkas: 3 status terbaru -->
                                <div>
                                    <p class="trk-tl-label">Riwayat Status</p>
                                    <ol class="trk-timeline">
                                        @foreach($report->statusHistories->sortByDesc('created_at')->take(3) as $history)
                                            <li>
                                                <p class="trk-tl-status">{{ $history->status->label() }}</p>
                                                <p class="trk-tl-time">{{ $history->created_at->format('d M Y, H:i') }}</p>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </section>
            @elseif(filled($phone) && $reports->isEmpty() && ! $errors->has('phone'))
                <!-- Tidak ada hasil -->
                <section class="trk-empty" aria-live="polite">
                    <div class="trk-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3M8.5 8.5l5 5M13.5 8.5l-5 5"/></svg>
                    </div>
                    <h2 class="font-fun">Laporan tidak ditemukan</h2>
                    <p>Belum ada laporan dengan nomor tersebut. Periksa kembali nomornya (tanpa spasi atau tanda hubung), atau buat laporan baru.</p>
                    <a href="{{ route('public.report.create') }}" class="trk-btn trk-btn--orange font-fun">Buat Laporan Baru</a>
                </section>
            @endif
        </div>
    </main>

    <!-- ========== FOOTER ========== -->
    <footer class="trk-footer">
        &copy; {{ date('Y') }} ANGKUT Palembang. <a href="{{ url('/') }}">Kembali ke Beranda</a>
    </footer>

    <script>
        (function () {
            /* salin kode tracking */
            document.querySelectorAll('.trk-copy').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var code = btn.getAttribute('data-code');
                    var label = btn.querySelector('.trk-copy-text');
                    function done() {
                        btn.classList.add('is-copied');
                        label.textContent = 'Tersalin';
                        setTimeout(function () { btn.classList.remove('is-copied'); label.textContent = 'Salin'; }, 1800);
                    }
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(code).then(done, done);
                    } else {
                        var t = document.createElement('textarea');
                        t.value = code; document.body.appendChild(t); t.select();
                        try { document.execCommand('copy'); } catch (e) {}
                        t.remove(); done();
                    }
                });
            });

            /* umpan balik saat mencari */
            var form = document.getElementById('trk-form');
            var submit = document.getElementById('trk-submit');
            if (form && submit) {
                var label = submit.querySelector('span');
                form.addEventListener('submit', function () {
                    if (!form.checkValidity()) return;
                    submit.disabled = true;
                    label.textContent = 'Mencari...';
                });
                window.addEventListener('pageshow', function () {
                    submit.disabled = false;
                    label.textContent = 'Cari Laporan';
                });
            }
        })();
    </script>
</body>
</html>