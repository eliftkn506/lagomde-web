<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lagomde')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream:      #F8F4EE;
            --warm-white: #FDFAF6;
            --ink:        #1A1612;
            --muted:      #8A8075;
            --accent:     #C9956A;
            --accent-dk:  #A8714A;
            --border:     #E8E1D8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            color: var(--ink);
        }

        .font-display { font-family: 'Cormorant Garamond', serif; }

        /* Alpine.js yanıp sönmeyi engelleme */
        [x-cloak] { display: none !important; }

        /* ─── SCROLLBAR ─── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* ─── HEADER ─── */
        #site-header {
            background: #FFFFFF;
            border-bottom: 1px solid var(--border);
            transition: box-shadow 0.3s ease;
        }

        #site-header.scrolled { box-shadow: 0 4px 24px rgba(26,22,18,.08); }

        /* ─── SEARCH ─── */
        .search-pill {
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 999px;
            transition: border-color .2s, box-shadow .2s;
        }
        .search-pill:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(201,149,106,.12);
        }

        /* ─── NAV ─── */
        .nav-link {
            position: relative;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: .02em;
            color: var(--ink);
            transition: color .2s;
            padding-bottom: 2px;
            white-space: nowrap;
            cursor: pointer;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            left: 0; bottom: -2px;
            width: 0; height: 1.5px;
            background: var(--accent);
            transition: width .25s ease;
        }
        .nav-link:hover { color: var(--accent); }
        .nav-link:hover::after { width: 100%; }

        .nav-special {
            background: var(--ink);
            color: var(--warm-white) !important;
            border-radius: 999px;
            padding: 6px 18px !important;
            font-size: 12px;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-weight: 600;
            transition: background .2s, transform .15s;
            display: inline-block;
        }
        .nav-special:hover { background: var(--accent) !important; transform: translateY(-1px); }
        .nav-special::after { display: none !important; }

        /* ─── MEGA MENU ─── */
        #site-nav { overflow: visible; }
        #site-nav > div { overflow: visible; }
        #site-nav ul { overflow: visible; }
        .nav-item { position: static; }

        .mega-panel {
            position: fixed;
            left: 0; right: 0; top: 0;
            background: #FFFFFF;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 16px 48px rgba(26,22,18,.10);
            padding: 32px 40px;
            display: none;
            z-index: 9999;
        }
        .mega-panel.is-open { display: flex; gap: 40px; flex-wrap: wrap; }

        .mega-panel::before {
            content: '';
            position: absolute;
            top: -5px;
            left: var(--arrow-left, 100px);
            width: 10px; height: 10px;
            background: #FFFFFF;
            border-left: 1px solid var(--border);
            border-top: 1px solid var(--border);
            transform: rotate(45deg);
        }

        .mega-col { min-width: 150px; max-width: 200px; }
        .mega-col-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .mega-link {
            display: block;
            font-size: 13px;
            font-weight: 400;
            color: var(--ink);
            margin-bottom: 9px;
            transition: color .15s, padding-left .15s;
            white-space: nowrap;
            text-decoration: none;
        }
        .mega-link:hover { color: var(--accent); padding-left: 5px; }

        /* ─── TICKER ─── */
        .ticker-wrap { overflow: hidden; }
        .ticker-track {
            display: flex; gap: 80px;
            animation: ticker 28s linear infinite;
            width: max-content;
        }
        @keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    {{-- ═══════════════ HEADER ═══════════════ --}}
    <header id="site-header" class="sticky top-0 z-50 py-3">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10 flex items-center gap-6">

            {{-- Logo --}}
            <a href="/" class="flex-shrink-0 mr-2">
                <img src="{{ asset('logo.png') }}" alt="Lagomde" class="h-14 md:h-16 w-auto object-contain">
            </a>

            {{-- Search --}}
            <div class="flex-1 max-w-xl hidden md:block">
                <div class="search-pill flex items-center gap-3 px-5 py-2.5">
                    <i class="fa-solid fa-magnifying-glass text-sm" style="color:var(--muted)"></i>
                    <input
                        type="text"
                        placeholder="Ne aramak istersiniz?"
                        class="flex-1 bg-transparent text-sm outline-none placeholder-[var(--muted)]"
                        style="color:var(--ink)"
                    >
                    <kbd class="hidden lg:inline-flex text-[10px] font-medium px-1.5 py-0.5 rounded-md" style="background:var(--border);color:var(--muted)">⌘K</kbd>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 ml-auto" style="color:var(--ink)">
                <a href="#" class="hidden lg:flex items-center gap-2 text-xs font-medium px-4 py-2 rounded-full border transition hover:border-[var(--accent)] hover:text-[var(--accent)]" style="border-color:var(--border)">
                    <i class="fa-regular fa-clock text-sm"></i> Sipariş Takibi
                </a>
                <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-[var(--border)] transition" title="Destek">
                    <i class="fa-regular fa-circle-question text-lg"></i>
                </a>
                
                {{-- GÖNDERDİĞİN YENİ GİRİŞ KONTROLÜ VE DROPDOWN --}}
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-[var(--border)] transition" title="Hesabım">
                        <i class="fa-regular fa-user text-lg"></i>
                        <span class="text-sm font-medium hidden lg:block">{{ Auth::user()->ad }}</span>
                    </button>

                    <div x-show="open" x-cloak @click.outside="open = false"
                        class="absolute right-0 mt-3 w-52 bg-white border border-gray-100 rounded-2xl shadow-xl z-50 py-2 overflow-hidden text-left">

                        <div class="px-4 py-3 border-b border-gray-50">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->ad }} {{ Auth::user()->soyad }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->eposta }}</p>
                        </div>

                        <a href="{{ route('profil') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition">
                            <i class="fa-regular fa-user w-4"></i> Profilim
                        </a>
                        <a href="{{ route('profil.siparisler') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition">
                            <i class="fa-solid fa-box-open w-4"></i> Siparişlerim
                        </a>
                        <a href="{{ route('profil.favoriler') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition">
                            <i class="fa-regular fa-heart w-4"></i> Favorilerim
                        </a>

                        <div class="border-t border-gray-50 mt-1">
                            <form method="POST" action="{{ route('cikis') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition">
                                    <i class="fa-solid fa-right-from-bracket w-4"></i> Çıkış Yap
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <button onclick="openAuthModal('giris')"
                    class="flex items-center gap-2 text-sm font-semibold px-5 py-2 rounded-full transition-all duration-200" style="background:var(--ink); color:var(--warm-white);">
                    <i class="fa-regular fa-user text-sm"></i>
                    <span class="hidden lg:block">Giriş Yap</span>
                </button>
                @endauth
                {{-- BİTİŞ --}}

                <a href="#" class="relative w-9 h-9 flex items-center justify-center rounded-full hover:bg-[var(--border)] transition" title="Sepetim">
                    <i class="fa-regular fa-bag-shopping text-lg"></i>
                    <span class="absolute top-0.5 right-0.5 w-4 h-4 flex items-center justify-center rounded-full text-[10px] font-bold text-white" style="background:var(--accent)">0</span>
                </a>
            </div>
        </div>
    </header>

    {{-- ═══════════════ NAV (DİNAMİK MENÜ) ═══════════════ --}}
    <nav id="site-nav" class="border-b" style="background:#fff;border-color:var(--border);position:relative;z-index:400;overflow:visible">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10" style="overflow:visible">
            <ul id="nav-list" class="flex items-center justify-center gap-4 lg:gap-6 xl:gap-8 py-3 hide-scrollbar" style="overflow:visible">

                @if(isset($anaMenuler) && $anaMenuler->count() > 0)
                    @foreach($anaMenuler as $menu)
                        <li class="nav-item py-1" data-has-mega="{{ $menu->altKategoriler->count() > 0 ? 'true' : 'false' }}">

                            @if($menu->slug === 'kendi-kutunu-yap' || mb_strtolower($menu->ad) === 'kendi kutunu yap')
                                <a href="#" class="nav-link nav-special">{{ $menu->ad }}</a>
                            @else
                                <a href="#" class="nav-link flex items-center gap-1">
                                    {{ $menu->ad }}
                                    @if($menu->altKategoriler->count() > 0)
                                        <i class="fa-solid fa-chevron-down nav-chevron text-[9px] opacity-40" style="transition:transform .2s"></i>
                                    @endif
                                </a>
                            @endif

                            @if($menu->altKategoriler->count() > 0)
                                <div class="mega-panel">
                                    @foreach($menu->altKategoriler as $alt)
                                        <div class="mega-col">
                                            <div class="mega-col-title">{{ $alt->ad }}</div>
                                            @if($alt->altKategoriler->count() > 0)
                                                @foreach($alt->altKategoriler as $sub)
                                                    <a href="#" class="mega-link">{{ $sub->ad }}</a>
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

    {{-- ═══════════════ AVANTAJLAR (TICKER YERİNE SABİT) ═══════════════ --}}
    <div class="bg-white py-3 border-b border-gray-100 shadow-sm hidden md:block">
        <div class="max-w-[80rem] mx-auto px-6 flex justify-between items-center text-sm font-medium text-gray-700">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-truck-fast text-lg text-[var(--accent)]"></i>
                <span>Hızlı Gönderim</span>
            </div>
            <div class="flex items-center space-x-2">
                <span>1.000.000+ Mutlu Kişi</span>
                <div class="text-[var(--accent)] text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-box-archive text-lg text-[var(--accent)]"></i>
                <span>Koşulsuz İade</span>
            </div>
        </div>
    </div>

    {{-- ═══════════════ CONTENT ═══════════════ --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- ═══════════════ FOOTER ═══════════════ --}}
    <footer class="pt-16 pb-10 mt-20" style="background:var(--ink); color:rgba(255,255,255,.55)">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 pb-12 border-b" style="border-color:rgba(255,255,255,.08)">
                <div class="col-span-2 md:col-span-1">
                    <img src="{{ asset('logo.png') }}" alt="Lagomde" class="h-12 w-auto object-contain brightness-0 invert mb-5">
                    <p class="text-xs leading-relaxed" style="color:rgba(255,255,255,.4)">Sevdiklerinize anlamlı hediyeler. Her an, her duygu için.</p>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-[.1em] uppercase mb-5 text-white">Keşfet</p>
                    @foreach(['Yeni Gelenler', 'Çok Satanlar', 'Kişiselleştirilmiş', 'Deneyim Hediyeleri'] as $link)
                        <a href="#" class="block text-xs mb-3 hover:text-white transition" style="color:rgba(255,255,255,.45)">{{ $link }}</a>
                    @endforeach
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-[.1em] uppercase mb-5 text-white">Yardım</p>
                    @foreach(['Sipariş Takibi', 'İade & Değişim', 'S.S.S.', 'Bize Ulaşın'] as $link)
                        <a href="#" class="block text-xs mb-3 hover:text-white transition" style="color:rgba(255,255,255,.45)">{{ $link }}</a>
                    @endforeach
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-[.1em] uppercase mb-5 text-white">Sosyal</p>
                    <div class="flex gap-4">
                        @foreach([['fa-instagram','#'],['fa-pinterest','#'],['fa-tiktok','#']] as [$icon, $href])
                            <a href="{{ $href }}" class="w-9 h-9 flex items-center justify-center rounded-full text-sm transition hover:bg-white hover:text-[var(--ink)]" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.6)">
                                <i class="fa-brands {{ $icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-[11px]" style="color:rgba(255,255,255,.25)">
                <span>&copy; {{ date('Y') }} Lagomde. Tüm hakları saklıdır.</span>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition">Gizlilik</a>
                    <a href="#" class="hover:text-white transition">Kullanım Koşulları</a>
                    <a href="#" class="hover:text-white transition">Çerezler</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- AUTH MODAL --}}
    @include('partials.auth-modal')

    {{-- ALPINE.JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        /* ── Header scroll gölgesi ── */
        const header = document.getElementById('site-header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 20);
        });

        /* ── Mega Menu ── */
        (function() {
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
                const arrowLeft = rect.left + rect.width / 2 - 5;
                panel.style.setProperty('--arrow-left', arrowLeft + 'px');
                panel.style.cssText += `; --arrow-left: ${arrowLeft}px`;

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
                if (activePanel) {
                    activePanel.style.top = getNavBottom() + 'px';
                }
            });
        })();
    </script>

</body>
</html>