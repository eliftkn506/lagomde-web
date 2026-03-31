<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lagomde')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ════════════════════════════════════════
            DESIGN TOKENS
        ════════════════════════════════════════ */
        :root {
            --teal:        #2A6B69;
            --teal-dk:     #1D4F4D;
            --teal-lt:     #E8F4F3;
            --copper:      #C07A4F;
            --copper-lt:   #F5EBE2;
            --ivory:       #FAF8F5;
            --ivory-dk:    #F2EDE6;
            --ink:         #18201F;
            --ink-60:      rgba(24,32,31,.6);
            --ink-30:      rgba(24,32,31,.3);
            --white:       #FFFFFF;
            --border:      #E4DDD4;
            --border-lt:   #EDE9E3;
            --radius-xl:   2rem;
            --radius-2xl:  3rem;
            --shadow-sm:   0 2px 12px rgba(24,32,31,.06);
            --shadow-md:   0 8px 32px rgba(24,32,31,.10);
            --shadow-lg:   0 24px 60px rgba(24,32,31,.14);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--ivory);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        .font-display { font-family: 'Playfair Display', serif; }

        [x-cloak] { display: none !important; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--ivory); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--teal); }

        /* ════════════════════════════════════════
            ANNOUNCEMENT BAR
        ════════════════════════════════════════ */
        #announcement-bar {
            background: var(--teal-dk);
            color: rgba(255,255,255,.85);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 8px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        #announcement-bar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                90deg,
                transparent 0px,
                transparent 60px,
                rgba(255,255,255,.03) 60px,
                rgba(255,255,255,.03) 61px
            );
        }
        #announcement-bar span { position: relative; z-index: 1; }
        #announcement-bar strong { color: var(--copper); font-weight: 700; }

        /* ════════════════════════════════════════
            HEADER
        ════════════════════════════════════════ */
        #site-header {
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-lt);
            transition: box-shadow .3s ease, background .3s ease;
            position: sticky;
            top: 0;
            z-index: 500;
        }
        #site-header.scrolled {
            box-shadow: 0 4px 30px rgba(24,32,31,.08);
            background: rgba(255,255,255,.99);
        }

        /* ── Search ── */
        .search-wrap {
            position: relative;
            flex: 1;
            max-width: 440px;
        }
        .search-input {
            width: 100%;
            background: var(--ivory-dk);
            border: 1.5px solid var(--border);
            border-radius: 999px;
            padding: 10px 44px 10px 18px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            color: var(--ink);
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .search-input::placeholder { color: var(--ink-30); }
        .search-input:focus {
            border-color: var(--teal);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(42,107,105,.1);
        }
        .search-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-30);
            font-size: 13px;
            pointer-events: none;
            transition: color .2s;
        }
        .search-wrap:focus-within .search-icon { color: var(--teal); }

        /* ── Action buttons ── */
        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            color: var(--ink);
            transition: background .2s, color .2s, transform .2s;
            cursor: pointer;
            border: none;
            position: relative;
        }
        .action-btn:hover {
            background: var(--teal-lt);
            color: var(--teal);
            transform: translateY(-1px);
        }
        .action-btn .badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--copper);
            color: white;
            font-size: 9px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        /* ── Auth button ── */
        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--teal);
            color: white;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .04em;
            padding: 9px 20px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
        }
        .btn-login:hover {
            background: var(--teal-dk);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(42,107,105,.3);
        }

        /* ── Order tracking pill ── */
        .pill-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .04em;
            color: var(--ink-60);
            padding: 7px 16px;
            border: 1.5px solid var(--border);
            border-radius: 999px;
            transition: border-color .2s, color .2s;
        }
        .pill-outline:hover { border-color: var(--teal); color: var(--teal); }

        /* ════════════════════════════════════════
            NAV BAR
        ════════════════════════════════════════ */
        #site-nav {
            background: var(--white);
            border-bottom: 1px solid var(--border-lt);
            position: relative;
            z-index: 400;
            overflow: visible;
        }

        #nav-list {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            padding: 0;
            overflow: visible;
            list-style: none;
        }

        .nav-item {
            position: static;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: .04em;
            color: var(--ink);
            padding: 14px 16px;
            transition: color .2s;
            cursor: pointer;
            white-space: nowrap;
            position: relative;
            text-decoration: none;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 16px;
            right: 16px;
            height: 2px;
            background: var(--teal);
            border-radius: 2px 2px 0 0;
            transform: scaleX(0);
            transition: transform .25s cubic-bezier(.4,0,.2,1);
        }
        .nav-link:hover { color: var(--teal); }
        .nav-link:hover::after { transform: scaleX(1); }

        /* Special CTA nav item */
        .nav-special {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: white !important;
            background: linear-gradient(135deg, var(--copper) 0%, #A86940 100%);
            padding: 8px 22px !important;
            border-radius: 999px;
            margin: 6px 8px;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 16px rgba(192,122,79,.35);
        }
        .nav-special:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(192,122,79,.45);
        }
        .nav-special::after { display: none !important; }

        .nav-chevron {
            font-size: 9px;
            opacity: .4;
            transition: transform .25s ease, opacity .2s;
        }
        .nav-link:hover .nav-chevron { opacity: .8; }

        /* ════════════════════════════════════════
            MEGA MENU
        ════════════════════════════════════════ */
        .mega-panel {
            position: fixed;
            left: 0;
            right: 0;
            top: 0; /* set via JS */
            background: var(--white);
            border-top: 1px solid var(--border-lt);
            border-bottom: 1px solid var(--border-lt);
            box-shadow: 0 20px 60px rgba(24,32,31,.12);
            padding: 36px 60px 40px;
            display: none;
            z-index: 9999;
            gap: 0;
        }
        .mega-panel.is-open {
            display: flex;
            flex-wrap: wrap;
            gap: 48px;
            animation: megaFadeIn .18s ease both;
        }

        @keyframes megaFadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Arrow tip */
        .mega-panel::before {
            content: '';
            position: absolute;
            top: -6px;
            left: var(--arrow-left, 100px);
            width: 12px;
            height: 12px;
            background: var(--white);
            border-left: 1px solid var(--border-lt);
            border-top: 1px solid var(--border-lt);
            transform: rotate(45deg);
        }

        .mega-col { min-width: 160px; max-width: 210px; }

        .mega-col-title {
            display: block;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1.5px solid var(--teal-lt);
            transition: color 0.2s;
        }
        .mega-col-title:hover {
            color: var(--teal-dk);
        }

        .mega-link {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 400;
            color: var(--ink-60);
            margin-bottom: 10px;
            text-decoration: none;
            transition: color .15s, gap .2s;
        }
        .mega-link::before {
            content: '';
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--copper);
            opacity: 0;
            flex-shrink: 0;
            transition: opacity .15s;
        }
        .mega-link:hover { color: var(--teal); }
        .mega-link:hover::before { opacity: 1; }

        /* ════════════════════════════════════════
            ADVANTAGE BAR
        ════════════════════════════════════════ */
        #advantage-bar {
            background: var(--white);
            border-bottom: 1px solid var(--border-lt);
        }
        .advantage-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--ink-60);
        }
        .advantage-item .adv-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--teal-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--teal);
            flex-shrink: 0;
        }
        .advantage-item strong { color: var(--ink); font-weight: 700; }

        /* Stars */
        .star-row { color: var(--copper); font-size: 10px; display: flex; gap: 1px; margin-top: 1px; }

        /* ════════════════════════════════════════
            USER DROPDOWN
        ════════════════════════════════════════ */
        .user-dropdown {
            border: 1px solid var(--border-lt);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            background: var(--white);
        }
        .user-dropdown-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-lt);
            background: var(--ivory);
        }
        .dropdown-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 18px;
            font-size: 13px;
            color: var(--ink-60);
            transition: background .15s, color .15s;
            text-decoration: none;
        }
        .dropdown-link:hover { background: var(--ivory); color: var(--teal); }
        .dropdown-link .di {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--teal-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: var(--teal);
            flex-shrink: 0;
        }
        .dropdown-link.danger { color: #C0392B; }
        .dropdown-link.danger:hover { background: #FFF5F5; }
        .dropdown-link.danger .di { background: #FFF5F5; color: #C0392B; }

        /* ════════════════════════════════════════
            ANIMATIONS
        ════════════════════════════════════════ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .6s cubic-bezier(.4,0,.2,1) both; }
        .delay-1 { animation-delay: .1s; }
        .delay-2 { animation-delay: .2s; }
        .delay-3 { animation-delay: .3s; }
        .delay-4 { animation-delay: .4s; }

        /* ── Card lift ── */
        .card-lift {
            transition: transform .4s cubic-bezier(.22,1,.36,1), box-shadow .4s ease;
        }
        .card-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 28px 56px rgba(24,32,31,.15);
        }

        /* ════════════════════════════════════════
            SECTION HEADING STYLE
        ════════════════════════════════════════ */
        .section-tag {
            display: inline-block;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--copper);
            margin-bottom: 8px;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 600;
            color: var(--ink);
            line-height: 1.25;
        }

        /* ════════════════════════════════════════
            FOOTER RESET (overrides below)
        ════════════════════════════════════════ */
        footer {
            --f-teal: var(--teal);
            --f-teal-lt: var(--teal-lt);
        }

        /* ════════════════════════════════════════
            TICKER
        ════════════════════════════════════════ */
        .ticker-wrap { overflow: hidden; }
        .ticker-track {
            display: flex; gap: 80px;
            animation: ticker 28s linear infinite;
            width: max-content;
        }
        @keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }

        /* ════════════════════════════════════════
            MISC
        ════════════════════════════════════════ */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Grain texture overlay on images */
        .img-grain::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 2;
            opacity: .35;
        }

        /* Smooth hover on all anchor tags */
        a { text-decoration: none; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    {{-- ═══════════════ ANNOUNCEMENT BAR ═══════════════ --}}
    <div id="announcement-bar">
        <span>✦ &nbsp;Ücretsiz Kargo — 500₺ ve üzeri siparişlerde &nbsp;✦&nbsp; &nbsp;<strong>YENİ KOLEKSİYON</strong> — Yaz Hediyeleri Geldi &nbsp;✦&nbsp; &nbsp;Güvenli Ödeme &nbsp;✦</span>
    </div>

    {{-- ═══════════════ HEADER ═══════════════ --}}
    <header id="site-header" class="py-2">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10 flex items-center gap-5">

            {{-- Logo --}}
            <a href="/" class="flex-shrink-0 mr-2">
                <img src="{{ asset('logo.svg') }}" alt="Lagomde"
                     class="h-16 md:h-20 w-auto object-contain transition-transform hover:scale-[1.02] duration-300">
            </a>

            {{-- Search --}}
            <div class="flex-1 max-w-md hidden md:block">
                <div class="search-wrap">
                    <input type="text"
                           placeholder="Hediye ara..."
                           class="search-input">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 ml-auto">

                {{-- Order tracking --}}
                <a href="#" class="pill-outline hidden lg:inline-flex">
                    <i class="fa-regular fa-clock text-xs"></i>
                    Sipariş Takibi
                </a>

                {{-- Help --}}
                <a href="#" class="action-btn" title="Yardım">
                    <i class="fa-regular fa-circle-question text-lg"></i>
                </a>

                {{-- Auth --}}
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="action-btn" title="Hesabım" style="width:auto;padding:0 14px;gap:8px;border-radius:999px;background:var(--teal-lt);color:var(--teal);font-weight:600;font-size:13px;">
                        <i class="fa-regular fa-user text-base"></i>
                        <span class="hidden lg:block">{{ Auth::user()->ad }}</span>
                        <i class="fa-solid fa-chevron-down text-[9px] opacity-60" :class="open && 'rotate-180'" style="transition:transform .2s"></i>
                    </button>

                    <div x-show="open" x-cloak @click.outside="open = false"
                         class="user-dropdown absolute right-0 mt-3 w-56 z-50"
                         style="animation: megaFadeIn .15s ease both;">

                        <div class="user-dropdown-header">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->ad }} {{ Auth::user()->soyad }}</p>
                            <p class="text-[11px] text-gray-400 truncate mt-0.5">{{ Auth::user()->eposta }}</p>
                        </div>

                        <a href="{{ route('profil') }}" class="dropdown-link">
                            <span class="di"><i class="fa-regular fa-user"></i></span> Profilim
                        </a>
                        <a href="{{ route('profil.siparisler') }}" class="dropdown-link">
                            <span class="di"><i class="fa-solid fa-box-open"></i></span> Siparişlerim
                        </a>
                        <a href="{{ route('profil.favoriler') }}" class="dropdown-link">
                            <span class="di"><i class="fa-regular fa-heart"></i></span> Favorilerim
                        </a>

                        <div class="border-t border-gray-100">
                            <form method="POST" action="{{ route('cikis') }}">
                                @csrf
                                <button type="submit" class="dropdown-link danger w-full text-left">
                                    <span class="di"><i class="fa-solid fa-right-from-bracket"></i></span> Çıkış Yap
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <button onclick="openAuthModal('giris')" class="btn-login">
                    <i class="fa-regular fa-user text-sm"></i>
                    <span class="hidden lg:block">Giriş Yap</span>
                </button>
                @endauth

                {{-- Cart --}}
                <a href="#" class="action-btn" title="Sepetim">
                    <i class="fa-regular fa-bag-shopping text-lg"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </header>

    {{-- ═══════════════ NAV ═══════════════ --}}
    <nav id="site-nav">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10" style="overflow:visible">
            <ul id="nav-list" class="hide-scrollbar" style="overflow:visible">

                @if(isset($anaMenuler) && $anaMenuler->count() > 0)
                    @foreach($anaMenuler as $menu)
                        <li class="nav-item" data-has-mega="{{ $menu->altKategoriler->count() > 0 ? 'true' : 'false' }}">

                            @if($menu->slug === 'kendi-kutunu-yap' || mb_strtolower($menu->ad) === 'kendi kutunu yap')
                                <a href="{{ route('kategori.goster', $menu->slug) }}" class="nav-special">
                                    <i class="fa-solid fa-gift text-[11px]"></i>
                                    {{ $menu->ad }}
                                </a>
                            @else
                                <a href="{{ route('kategori.goster', $menu->slug) }}" class="nav-link">
                                    {{ $menu->ad }}
                                    @if($menu->altKategoriler->count() > 0)
                                        <i class="fa-solid fa-chevron-down nav-chevron"></i>
                                    @endif
                                </a>
                            @endif

                            @if($menu->altKategoriler->count() > 0)
                                <div class="mega-panel">
                                    @foreach($menu->altKategoriler as $alt)
                                        <div class="mega-col">
                                            <a href="{{ route('kategori.goster', $alt->slug) }}" class="mega-col-title">
                                                {{ $alt->ad }}
                                            </a>
                                            @if($alt->altKategoriler->count() > 0)
                                                @foreach($alt->altKategoriler as $sub)
                                                    <a href="{{ route('kategori.goster', $sub->slug) }}" class="mega-link">{{ $sub->ad }}</a>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </li>
                    @endforeach
                @endif

            </ul>
        </div>
    </nav>

    {{-- ═══════════════ ADVANTAGE BAR ═══════════════ --}}
    <div id="advantage-bar" class="hidden md:block py-3">
        <div class="max-w-[1440px] mx-auto px-10 flex justify-between items-center">
            <div class="advantage-item">
                <span class="adv-icon"><i class="fa-solid fa-truck-fast"></i></span>
                <div>
                    <strong>Hızlı Teslimat</strong>
                    <div style="font-size:11px;color:var(--ink-30)">Aynı gün kargoya verilir</div>
                </div>
            </div>
            <div class="advantage-item">
                <span class="adv-icon"><i class="fa-solid fa-star"></i></span>
                <div>
                    <strong>1.000.000+ Mutlu Müşteri</strong>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
            </div>
            <div class="advantage-item">
                <span class="adv-icon"><i class="fa-solid fa-shield-halved"></i></span>
                <div>
                    <strong>256-Bit SSL Güvenliği</strong>
                    <div style="font-size:11px;color:var(--ink-30)">Güvenli ödeme altyapısı</div>
                </div>
            </div>
            <div class="advantage-item">
                <span class="adv-icon"><i class="fa-solid fa-rotate-left"></i></span>
                <div>
                    <strong>Koşulsuz İade</strong>
                    <div style="font-size:11px;color:var(--ink-30)">30 gün içinde zahmetsiz</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════ CONTENT ═══════════════ --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- ═══════════════ FOOTER ═══════════════ --}}
    @include('partials.footer')

    {{-- AUTH MODAL --}}
    @include('partials.auth-modal')

    {{-- ALPINE.JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        /* ── Header scroll shadow ── */
        const header = document.getElementById('site-header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 20);
        }, { passive: true });

        /* ── Mega Menu ── */
        (function () {
            const navItems = document.querySelectorAll('.nav-item[data-has-mega="true"]');
            let activePanel = null;
            let closeTimer = null;

            function getNavBottom() {
                const nav = document.getElementById('site-nav');
                return nav ? nav.getBoundingClientRect().bottom : 80;
            }

            function openPanel(item) {
                if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
                const panel = item.querySelector('.mega-panel');
                if (!panel) return;
                document.querySelectorAll('.mega-panel.is-open').forEach(p => {
                    p.classList.remove('is-open');
                    p.style.top = '';
                });
                document.querySelectorAll('.nav-chevron').forEach(c => c.style.transform = '');
                const navBottom = getNavBottom();
                panel.style.top = navBottom + 'px';
                const rect = item.getBoundingClientRect();
                const arrowLeft = rect.left + rect.width / 2 - 6;
                panel.style.setProperty('--arrow-left', arrowLeft + 'px');
                panel.classList.add('is-open');
                const chev = item.querySelector('.nav-chevron');
                if (chev) chev.style.transform = 'rotate(180deg)';
                activePanel = panel;
            }

            function closePanel(panel) {
                if (!panel) return;
                panel.classList.remove('is-open');
                panel.style.top = '';
                const item = panel.closest('.nav-item');
                if (item) {
                    const chev = item.querySelector('.nav-chevron');
                    if (chev) chev.style.transform = '';
                }
                activePanel = null;
            }

            function scheduleClose(panel) {
                closeTimer = setTimeout(() => closePanel(panel), 120);
            }

            navItems.forEach(item => {
                const panel = item.querySelector('.mega-panel');
                if (!panel) return;
                item.addEventListener('mouseenter', () => openPanel(item));
                item.addEventListener('mouseleave', () => scheduleClose(panel));
                panel.addEventListener('mouseenter', () => {
                    if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
                });
                panel.addEventListener('mouseleave', () => scheduleClose(panel));
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.nav-item') && !e.target.closest('.mega-panel')) {
                    document.querySelectorAll('.mega-panel.is-open').forEach(p => closePanel(p));
                }
            });

            window.addEventListener('resize', () => {
                if (activePanel) activePanel.style.top = getNavBottom() + 'px';
            }, { passive: true });
        })();
    </script>

</body>
</html>