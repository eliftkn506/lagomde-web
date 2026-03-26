<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lagomde | @yield('page_title', 'Admin Paneli')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Figtree', sans-serif; }
        body { background: #f5f5f0; min-height: 100vh; }

        .top-header {
            background: #fff;
            border-bottom: 1px solid #e8e4de;
            padding: 0 40px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-bar {
            background: #fff;
            border-bottom: 2px solid #f0ece6;
            padding: 0 40px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 15px 15px;
            font-size: 13.5px;
            font-weight: 500;
            color: #6b7280;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .nav-link:hover { color: #111827; }
        .nav-link.active { color: #1e293b; font-weight: 600; border-bottom-color: #1e293b; }
        .nav-link i { font-size: 11px; }

        .nav-dropdown { position: relative; }
        .nav-dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            border: 1px solid #e8e4de;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            min-width: 190px;
            padding: 6px;
            z-index: 100;
        }
        .dropdown-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 13px; font-size: 13px; color: #374151;
            text-decoration: none; border-radius: 8px; transition: background 0.1s;
        }
        .dropdown-item:hover { background: #f7f4f0; }
        .dropdown-item i { width: 14px; color: #9ca3af; font-size: 11px; }

        .page-content {
            max-width: 1300px;
            margin: 0 auto;
            padding: 36px 40px;
        }

        .card {
            background: #fff;
            border: 1px solid #e8e4de;
            border-radius: 14px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e8e4de;
            border-radius: 14px;
            padding: 26px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .stat-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.07);
            transform: translateY(-1px);
        }

        table.clean th {
            font-size: 10px; font-weight: 700;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: #9ca3af; padding: 12px 20px;
            border-bottom: 1px solid #f0ece6; text-align: left;
        }
        table.clean td {
            padding: 14px 20px; font-size: 13.5px;
            color: #374151; border-bottom: 1px solid #f7f4f0;
        }
        table.clean tbody tr:last-child td { border: none; }
        table.clean tbody tr:hover td { background: #faf8f5; }

        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge-green  { background: #f0fdf4; color: #16a34a; }
        .badge-amber  { background: #fffbeb; color: #d97706; }
        .badge-blue   { background: #eff6ff; color: #2563eb; }
        .badge-red    { background: #fef2f2; color: #dc2626; }
        .badge-slate  { background: #f8fafc; color: #64748b; }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open {
            display: flex;
            animation: fadeIn 0.2s ease;
        }
        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 36px 32px 28px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.15);
            animation: slideUp 0.25s ease;
            text-align: center;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(16px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-thumb { background: #d1cdc6; border-radius: 10px; }
    </style>
</head>
<body>

{{-- ÜST HEADER --}}
<div class="top-header">
    <a href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('logo.png') }}" alt="Lagomde" class="h-10 w-auto object-contain">
    </a>

    <div class="flex items-center gap-3">
        {{-- Bildirim --}}
        <button class="relative w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-gray-50 transition">
            <i class="fa-solid fa-bell text-sm"></i>
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
        </button>

        {{-- Kullanıcı --}}
        <div class="flex items-center gap-2.5 pl-3 border-l border-gray-100">
            <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->ad ?? 'A', 0, 1)) }}
            </div>
            <div class="hidden md:block leading-tight">
                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->ad ?? '' }} {{ Auth::user()->soyad ?? '' }}</p>
                <p class="text-[11px] text-gray-400">Yönetici</p>
            </div>
        </div>

        {{-- Çıkış butonu - modal açar --}}
        <button onclick="document.getElementById('logoutModal').classList.add('open')"
            class="flex items-center gap-1.5 text-xs text-gray-400 hover:text-red-500 transition px-3 py-2 rounded-lg hover:bg-red-50">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="hidden md:inline">Çıkış</span>
        </button>
    </div>
</div>

{{-- NAVİGASYON --}}
<nav class="nav-bar">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-pie"></i> Anasayfa
    </a>

    <div class="nav-dropdown">
        {{-- Aktiflik kontrolü düzeltildi (admin.urunler* ve admin.kategoriler*) --}}
        <a href="#" class="nav-link {{ request()->routeIs('admin.urunler*', 'admin.kategoriler*') ? 'active' : '' }}">
            <i class="fa-solid fa-box"></i> Ürün Yönetimi <i class="fa-solid fa-chevron-down text-[9px] ml-0.5"></i>
        </a>
        <div class="dropdown-menu">
            {{-- Linkler route() fonksiyonu ile bağlandı --}}
            <a href="{{ route('admin.urunler.index') }}" class="dropdown-item"><i class="fa-solid fa-list"></i> Tüm Ürünler</a>
            <a href="{{ route('admin.urunler.create') }}" class="dropdown-item"><i class="fa-solid fa-plus"></i> Yeni Ürün Ekle</a>
            <a href="{{ route('admin.kategoriler.index') }}" class="dropdown-item"><i class="fa-solid fa-layer-group"></i> Kategoriler & Filtreler</a>
            <a href="#" class="dropdown-item"><i class="fa-solid fa-tags"></i> Markalar</a>
        </div>
    </div>

    <a href="#" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <i class="fa-solid fa-cart-shopping"></i> Siparişler
    </a>

    <a href="#" class="nav-link {{ request()->routeIs('admin.boxes*') ? 'active' : '' }}">
        <i class="fa-solid fa-gift"></i> Kutu Tasarımı
    </a>

    <a href="#" class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
        <i class="fa-solid fa-users"></i> Müşteriler
    </a>

    <div class="nav-dropdown">
        <a href="#" class="nav-link">
            <i class="fa-solid fa-bullhorn"></i> Pazarlama <i class="fa-solid fa-chevron-down text-[9px] ml-0.5"></i>
        </a>
        <div class="dropdown-menu">
            <a href="#" class="dropdown-item"><i class="fa-solid fa-percent"></i> Kuponlar</a>
            <a href="#" class="dropdown-item"><i class="fa-solid fa-star"></i> Yorumlar</a>
        </div>
    </div>

    <a href="#" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <i class="fa-solid fa-gear"></i> Ayarlar
    </a>

    <a href="/" target="_blank" class="nav-link ml-auto text-gray-400">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Siteye Git
    </a>
</nav>

{{-- SAYFA İÇERİĞİ --}}
<main>
    <div class="page-content">
        @yield('admin_content')
    </div>
</main>

<footer class="border-t border-gray-100 py-5 text-center text-[11px] text-gray-300">
    &copy; {{ date('Y') }} Lagomde — Tüm hakları saklıdır.
</footer>

{{-- ÇIKIŞ MODAL --}}
<div id="logoutModal" class="modal-overlay" onclick="if(event.target===this) this.classList.remove('open')">
    <div class="modal-box">
        {{-- İkon --}}
        <div class="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-5">
            <i class="fa-solid fa-right-from-bracket text-red-400 text-2xl"></i>
        </div>

        {{-- Başlık --}}
        <h3 class="text-lg font-bold text-gray-900 mb-2">Çıkış Yap</h3>
        <p class="text-sm text-gray-400 mb-7 leading-relaxed">
            Yönetim panelinden çıkmak istediğinize<br>emin misiniz?
        </p>

        {{-- Butonlar --}}
        <div class="flex gap-3">
            <button onclick="document.getElementById('logoutModal').classList.remove('open')"
                class="flex-1 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                İptal
            </button>
            <a href="{{ route('admin.logout') }}"
                class="flex-1 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition text-center">
                Evet, Çıkış Yap
            </a>
        </div>
    </div>
</div>

</body>
</html>