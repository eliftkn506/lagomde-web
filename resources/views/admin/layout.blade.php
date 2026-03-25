<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lagomde | Admin Paneli</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        
        :root {
            --nav-bg: #0f172a;
            --nav-hover: #1e293b;
            --accent: #e2a96f;
            --accent-light: #fdf3e7;
            --sidebar-w: 260px;
        }

        body { background: #f8f7f4; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--nav-bg);
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: transform 0.3s ease;
        }

        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .nav-section-title {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.18em;
            color: rgba(255,255,255,0.25);
            text-transform: uppercase;
            padding: 20px 24px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 24px;
            color: rgba(255,255,255,0.55);
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.18s;
            text-decoration: none;
            position: relative;
            margin: 1px 12px;
            border-radius: 10px;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.9);
        }

        .nav-item.active {
            background: rgba(226,169,111,0.12);
            color: var(--accent);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }

        .nav-item .nav-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
            font-size: 13px;
            flex-shrink: 0;
        }

        .nav-item.active .nav-icon {
            background: rgba(226,169,111,0.15);
        }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #ede9e3;
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        /* Cards */
        .stat-card {
            background: #fff;
            border: 1px solid #ede9e3;
            border-radius: 16px;
            padding: 24px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.06);
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Table */
        .data-table th {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #94a3b8;
            padding: 12px 16px;
            border-bottom: 1px solid #f1ede8;
        }

        .data-table td {
            padding: 14px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid #f8f5f0;
            color: #374151;
        }

        .data-table tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover td { background: #fdf8f3; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1c9bc; border-radius: 10px; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('logo.png') }}" alt="Lagomde" class="h-10 w-auto brightness-0 invert opacity-90">
            <p class="text-[10px] text-white/25 font-semibold tracking-widest uppercase mt-2">Yönetim Paneli</p>
        </div>

        <nav class="flex-1 py-4 overflow-y-auto">
            <p class="nav-section-title">Genel</p>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
                Dashboard
            </a>

            <p class="nav-section-title">Katalog</p>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-box"></i></span>
                Ürünler
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-layer-group"></i></span>
                Kategoriler
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-tags"></i></span>
                Markalar
            </a>

            <p class="nav-section-title">Satış</p>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-cart-shopping"></i></span>
                Siparişler
                <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">5</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-gift"></i></span>
                Kutu Tasarımı
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-percent"></i></span>
                İndirim & Kuponlar
            </a>

            <p class="nav-section-title">Kullanıcılar</p>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                Müşteriler
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-star"></i></span>
                Yorumlar
            </a>

            <p class="nav-section-title">Sistem</p>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-gear"></i></span>
                Ayarlar
            </a>
            <a href="/" target="_blank" class="nav-item">
                <span class="nav-icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                Siteye Git
            </a>
        </nav>

        <!-- User info bottom -->
        <div class="p-4 border-t border-white/6">
            <div class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-white/5 transition cursor-pointer group">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->ad ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white/80 text-xs font-semibold truncate">{{ Auth::user()->ad ?? 'Admin' }} {{ Auth::user()->soyad ?? '' }}</p>
                    <p class="text-white/30 text-[10px] truncate">{{ Auth::user()->eposta ?? '' }}</p>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-white/20 hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">
            <div>
                <h1 class="text-[15px] font-bold text-slate-800">@yield('page_title', 'Dashboard')</h1>
                <p class="text-[11px] text-slate-400 mt-0.5">@yield('page_subtitle', 'Mağazanızın genel durumu')</p>
            </div>
            <div class="flex items-center gap-4">
                <!-- Bildirim -->
                <button class="relative w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition">
                    <i class="fa-solid fa-bell text-sm"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <!-- Tarih -->
                <div class="hidden md:flex items-center gap-2 text-xs text-slate-400 bg-slate-50 border border-slate-200 px-3 py-2 rounded-xl">
                    <i class="fa-solid fa-calendar-days text-slate-300"></i>
                    <span>{{ now()->locale('tr')->isoFormat('D MMMM YYYY') }}</span>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-grow p-8">
            @yield('admin_content')
        </main>

        <footer class="px-8 py-4 border-t border-slate-100 text-center text-xs text-slate-300">
            &copy; {{ date('Y') }} Lagomde — Tüm hakları saklıdır.
        </footer>
    </div>

</body>
</html>