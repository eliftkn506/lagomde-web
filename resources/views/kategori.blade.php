@extends('layouts.app')

@section('title', ($kategori->ad ?? 'Tüm Ürünler') . ' — Lagomde')

@section('content')

<style>
    /* ════════════ KATEGORİ SAYFA ÖZEL STİLLER - GÜNCELLENDİ ════════════ */

    /* Hero banner */
    .cat-hero {
        position: relative;
        overflow: hidden;
        min-height: 240px;
        display: flex;
        align-items: flex-end;
        background: var(--teal-dk);
    }
    .cat-hero-img {
        position: absolute; inset: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        opacity: .35;
        transition: transform 8s ease;
    }
    .cat-hero:hover .cat-hero-img { transform: scale(1.05); }
    .cat-hero-grain {
        position: absolute; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.06'/%3E%3C/svg%3E");
        pointer-events: none;
    }
    .cat-hero-content {
        position: relative; z-index: 2;
        padding: 40px 60px 44px;
        width: 100%;
    }
    .cat-hero-breadcrumb {
        display: flex; align-items: center; gap: 8px;
        font-size: 11px; font-weight: 600;
        letter-spacing: .08em; text-transform: uppercase;
        color: rgba(255,255,255,.45);
        margin-bottom: 14px;
    }
    .cat-hero-breadcrumb a { color: inherit; transition: color .2s; }
    .cat-hero-breadcrumb a:hover { color: rgba(255,255,255,.8); }
    .cat-hero-breadcrumb span { color: rgba(255,255,255,.25); }
    .cat-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 700; color: white;
        line-height: 1.15; margin-bottom: 10px;
    }
    .cat-hero-meta {
        font-size: 12px; font-weight: 500;
        color: rgba(255,255,255,.45);
        display: flex; align-items: center; gap: 16px;
    }
    .cat-hero-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.1);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 999px;
        padding: 5px 14px;
        font-size: 11px; font-weight: 700;
        color: rgba(255,255,255,.7);
    }

    /* ── Alt kategoriler scroll ── */
    .sub-cat-bar {
        background: white;
        border-bottom: 1px solid var(--border-lt);
        overflow-x: auto;
        -ms-overflow-style: none; scrollbar-width: none;
    }
    .sub-cat-bar::-webkit-scrollbar { display: none; }
    .sub-cat-inner {
        display: flex; align-items: center; gap: 8px;
        padding: 14px 24px;
        width: max-content;
        min-width: 100%;
    }
    .sub-cat-chip {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 12px; font-weight: 600;
        border: 1.5px solid var(--border);
        color: var(--ink-60);
        background: white;
        transition: all .2s; cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
    }
    .sub-cat-chip:hover, .sub-cat-chip.active {
        background: var(--teal); color: white;
        border-color: var(--teal);
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(42,107,105,.3);
    }
    .sub-cat-chip img {
        width: 22px; height: 22px;
        border-radius: 50%; object-fit: cover;
        opacity: .75;
    }
    .sub-cat-chip.active img, .sub-cat-chip:hover img { opacity: 1; filter: brightness(10); }

    /* ── Layout wrapper ── */
    .shop-layout {
        display: grid;
        grid-template-columns: 320px 1fr; /* Sidebar genişletildi */
        gap: 0;
        max-width: 1440px;
        margin: 0 auto;
        align-items: start;
        background: #F8F9F8; /* Genel arka plan tonu */
    }
    @media (max-width: 1024px) {
        .shop-layout { grid-template-columns: 1fr; }
        .shop-sidebar { display: none; }
        .shop-sidebar.mobile-open { display: block; }
    }

    /* ── Sidebar - DÜZELTİLDİ VE UZATILDI ── */
    .shop-sidebar {
        padding: 40px 30px; /* Kenar boşlukları arttırıldı */
        border-right: 1px solid var(--border-lt);
        position: sticky;
        top: 80px; /* Header yüksekliğine göre ayarlandı */
        background-color: white; /* Sidebar arka planı */
        /* Paneli aşağıya doğru doğal bir şekilde uzatmak için: */
        min-height: calc(100vh - 80px); /* Ekran yüksekliğine sığdır */
        overflow-y: auto; /* İçerik taşarsa kaydır */
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
        z-index: 10;
        border-radius: 0 20px 20px 0; /* Modern köşe */
        box-shadow: 5px 0 15px rgba(0,0,0,0.02); /* Hafif gölge */
    }
    .shop-sidebar::-webkit-scrollbar { width: 3px; }
    .shop-sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }

    .filter-section { margin-bottom: 35px; } /* Bölümler arası boşluk arttırıldı */
    .filter-title {
        font-size: 12px; font-weight: 800;
        letter-spacing: .16em; text-transform: uppercase;
        color: var(--ink); margin-bottom: 18px; /* Yazı rengi ve alt boşluk */
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer;
    }
    .filter-title i { font-size: 11px; opacity: .5; transition: transform .2s; }
    .filter-title.collapsed i { transform: rotate(-90deg); }

    /* Fiyat slider */
    .price-range-wrap { padding: 4px 2px; }
    .price-inputs {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 14px;
    }
    .price-input {
        flex: 1;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 13px; font-weight: 600;
        color: var(--ink);
        outline: none;
        transition: border-color .2s;
        font-family: 'Outfit', sans-serif;
        background: var(--ivory);
    }
    .price-input:focus { border-color: var(--teal); background: white; }
    .price-sep { font-size: 11px; color: var(--ink-30); font-weight: 600; }

    .range-track {
        position: relative; height: 4px;
        background: var(--border); border-radius: 2px;
        margin: 18px 0 8px;
    }
    .range-fill {
        position: absolute; height: 100%;
        background: var(--teal); border-radius: 2px;
        transition: left .1s, width .1s;
    }
    input[type="range"].price-slider {
        position: absolute; top: -8px;
        width: 100%; pointer-events: none;
        -webkit-appearance: none; background: transparent;
        height: 20px;
    }
    input[type="range"].price-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: white;
        border: 3px solid var(--teal);
        cursor: pointer; pointer-events: all;
        box-shadow: 0 2px 8px rgba(42,107,105,.3);
        transition: transform .15s;
    }
    input[type="range"].price-slider::-webkit-slider-thumb:hover { transform: scale(1.2); }

    /* Checkbox filtre - Simetri ve Düzen Düzeltildi */
    .filter-check-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 9px 0; cursor: pointer;
        transition: color .15s;
    }
    .filter-check-item:hover { color: var(--teal); }
    .filter-check-label {
        display: flex; align-items: center; gap: 12px; /* Boşluk arttırıldı */
        font-size: 13px; font-weight: 500; color: inherit;
        cursor: pointer;
    }
    .filter-check-input {
        width: 16px; height: 16px; /* Boyut arttırıldı */
        border-radius: 4px;
        accent-color: var(--teal);
        cursor: pointer;
    }
    /* Renk kutucukları simetrisi */
    .color-chip {
        width: 18px; height: 18px;
        border-radius: 4px;
        border: 1px solid rgba(0,0,0,0.1);
        margin-right: -4px; /* Hizalama için */
    }
    .filter-count {
        font-size: 11px; font-weight: 700;
        color: var(--teal); /* Sayı rengi */
        background: var(--teal-lt); /* Arka plan tonu */
        padding: 3px 9px; border-radius: 999px;
    }

    /* Aktif filtre temizle */
    .active-filters {
        display: flex; flex-wrap: wrap; gap: 6px;
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-lt);
        background: var(--ivory);
    }
    .active-filter-tag {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11px; font-weight: 600;
        padding: 5px 12px;
        background: var(--teal-lt);
        color: var(--teal);
        border-radius: 999px;
        border: 1px solid rgba(42,107,105,0.1);
    }
    .active-filter-tag button {
        background: none; border: none;
        color: var(--teal); cursor: pointer;
        font-size: 10px; padding: 0; line-height: 1;
        opacity: .6; transition: opacity .15s;
    }
    .active-filter-tag button:hover { opacity: 1; }

    /* ── Toolbar ── */
    .shop-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-lt);
        background: white;
        gap: 12px; flex-wrap: wrap;
    }
    .toolbar-left { display: flex; align-items: center; gap: 12px; }
    .toolbar-result {
        font-size: 13px; font-weight: 600; color: var(--ink-60);
    }
    .toolbar-result strong { color: var(--ink); }

    .view-toggle { display: flex; gap: 4px; }
    .view-btn {
        width: 34px; height: 34px;
        border-radius: 10px; border: 1.5px solid var(--border);
        background: transparent; color: var(--ink-30);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .2s; font-size: 13px;
    }
    .view-btn.active, .view-btn:hover {
        background: var(--teal); color: white;
        border-color: var(--teal);
    }

    .sort-select {
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 8px 32px 8px 14px;
        font-size: 12px; font-weight: 600;
        color: var(--ink); background: white;
        outline: none; cursor: pointer;
        font-family: 'Outfit', sans-serif;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2318201f' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        transition: border-color .2s;
    }
    .sort-select:focus { border-color: var(--teal); }

    /* Mobil filtre butonu */
    .mobile-filter-btn {
        display: none;
        align-items: center; gap: 8px;
        padding: 8px 18px;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        font-size: 12px; font-weight: 700;
        background: white; color: var(--ink);
        cursor: pointer; transition: all .2s;
    }
    .mobile-filter-btn:hover { border-color: var(--teal); color: var(--teal); }
    @media (max-width: 1024px) { .mobile-filter-btn { display: flex; } }

    /* ── Ürün Grid ── */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        background: var(--border-lt);
    }
    .product-grid.col-2 { grid-template-columns: repeat(2, 1fr); }
    .product-grid.col-4 { grid-template-columns: repeat(4, 1fr); }
    .product-grid.list-view {
        grid-template-columns: 1fr;
        background: white;
        gap: 0;
    }

    @media (max-width: 768px) {
        .product-grid { grid-template-columns: repeat(2, 1fr); }
        .product-grid.col-4 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .product-grid { grid-template-columns: 1fr; }
    }

    /* ── Ürün Kartı ── */
    .product-card {
        background: white;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: box-shadow .3s ease;
        display: flex; flex-direction: column;
    }
    .product-card:hover {
        z-index: 2;
        box-shadow: 0 20px 60px rgba(24,32,31,.15);
    }

    .product-card-img {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1 / 1.1;
        background: var(--ivory-dk);
        flex-shrink: 0;
    }
    .product-card-img img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .7s cubic-bezier(.22,1,.36,1);
    }
    .product-card:hover .product-card-img img { transform: scale(1.08); }

    /* İkinci görsel hover efekti */
    .product-card-img .img-second {
        position: absolute; inset: 0;
        opacity: 0; transition: opacity .5s ease;
    }
    .product-card:hover .product-card-img .img-second { opacity: 1; }

    .product-badge {
        position: absolute; top: 12px; left: 12px;
        z-index: 2;
        display: flex; flex-direction: column; gap: 6px;
    }
    .badge-tag {
        display: inline-block;
        font-size: 9px; font-weight: 800;
        letter-spacing: .1em; text-transform: uppercase;
        padding: 4px 10px; border-radius: 6px;
    }
    .badge-new { background: var(--teal); color: white; }
    .badge-sale { background: #C0392B; color: white; }
    .badge-hot { background: var(--copper); color: white; }

    .product-actions {
        position: absolute; top: 12px; right: 12px;
        z-index: 2;
        display: flex; flex-direction: column; gap: 6px;
        opacity: 0; transform: translateX(8px);
        transition: opacity .25s, transform .25s;
    }
    .product-card:hover .product-actions {
        opacity: 1; transform: translateX(0);
    }
    .product-action-btn {
        width: 36px; height: 36px;
        border-radius: 12px;
        background: white; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; color: var(--ink);
        cursor: pointer; transition: all .2s;
        box-shadow: 0 4px 12px rgba(24,32,31,.12);
    }
    .product-action-btn:hover { background: var(--teal); color: white; transform: scale(1.1); }
    .product-action-btn.fav-active { color: #e74c3c; }

    /* Sepete ekle overlay */
    .product-add-btn {
        position: absolute; bottom: 0; left: 0; right: 0;
        padding: 14px;
        background: var(--teal);
        color: white;
        font-size: 12px; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transform: translateY(100%);
        transition: transform .3s cubic-bezier(.22,1,.36,1);
    }
    .product-card:hover .product-add-btn { transform: translateY(0); }

    .product-card-body {
        padding: 16px 16px 20px;
        flex: 1; display: flex; flex-direction: column;
    }
    .product-cat-label {
        font-size: 9px; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: var(--copper); margin-bottom: 6px;
    }
    .product-name {
        font-size: 14px; font-weight: 600;
        color: var(--ink); line-height: 1.4;
        margin-bottom: 6px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .product-desc {
        font-size: 11px; color: var(--ink-60);
        line-height: 1.5; margin-bottom: 10px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .product-price-row {
        display: flex; align-items: center; gap: 8px;
        margin-top: auto;
    }
    .price-normal {
        font-size: 18px; font-weight: 800;
        color: var(--ink);
        font-family: 'Playfair Display', serif;
    }
    .price-discounted {
        font-size: 18px; font-weight: 800;
        color: #C0392B;
        font-family: 'Playfair Display', serif;
    }
    .price-old {
        font-size: 12px; font-weight: 500;
        color: var(--ink-30); text-decoration: line-through;
    }
    .price-save {
        font-size: 10px; font-weight: 700;
        color: #27AE60; background: #EAFAF1;
        padding: 2px 8px; border-radius: 6px;
    }

    /* Liste görünümü kart */
    .product-grid.list-view .product-card {
        flex-direction: row;
        border-bottom: 1px solid var(--border-lt);
    }
    .product-grid.list-view .product-card-img {
        width: 180px; min-width: 180px;
        aspect-ratio: 1 / 1;
    }
    .product-grid.list-view .product-add-btn {
        bottom: auto; top: 0; left: auto; right: 0;
        width: 56px; height: 100%;
        transform: translateX(100%);
        flex-direction: column; gap: 4px;
        font-size: 9px;
        writing-mode: vertical-rl;
    }
    .product-grid.list-view .product-card:hover .product-add-btn {
        transform: translateX(0);
    }

    /* Yok mesajı */
    .empty-state {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        padding: 80px 40px; text-align: center;
        background: white;
    }

    /* Pagination */
    .pagination-wrap {
        display: flex; align-items: center; justify-content: center;
        gap: 6px; padding: 32px 24px;
        background: white;
        border-top: 1px solid var(--border-lt);
    }
    .page-btn {
        width: 40px; height: 40px;
        border-radius: 12px; border: 1.5px solid var(--border);
        background: white; color: var(--ink-60);
        font-size: 13px; font-weight: 600;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .2s;
        font-family: 'Outfit', sans-serif;
    }
    .page-btn:hover, .page-btn.active {
        background: var(--teal); color: white;
        border-color: var(--teal);
    }
    .page-btn:disabled { opacity: .35; cursor: not-allowed; }

    /* Loading skeleton */
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.4s ease infinite;
        border-radius: 8px;
    }

    /* Mobil filtre drawer */
    .filter-drawer {
        position: fixed; inset: 0; z-index: 900;
        display: none;
    }
    .filter-drawer.open { display: flex; }
    .filter-drawer-overlay {
        position: absolute; inset: 0;
        background: rgba(24,32,31,.5); backdrop-filter: blur(4px);
    }
    .filter-drawer-panel {
        position: absolute; left: 0; top: 0; bottom: 0;
        width: 320px; max-width: 90vw;
        background: white;
        overflow-y: auto;
        transform: translateX(-100%);
        transition: transform .35s cubic-bezier(.22,1,.36,1);
        z-index: 1;
    }
    .filter-drawer.open .filter-drawer-panel { transform: translateX(0); }
    .filter-drawer-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-lt);
        position: sticky; top: 0; background: white; z-index: 1;
    }

    /* "Filtrele" Butonu Tasarımı - EKLENDİ */
    .apply-filters-btn {
        width: 100%;
        padding: 14px;
        background-color: var(--ink); /* Modern koyu ton */
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.1s;
        margin-top: auto; /* Panelin en altına it */
    }
    .apply-filters-btn:hover {
        background-color: #2d3a39; /* Hafif açılmış ton */
    }
    .apply-filters-btn:active {
        transform: scale(0.98);
    }

</style>

{{-- ═══ HERO ═══ --}}
<div class="cat-hero">
    @if(isset($kategori) && $kategori->gorsel)
        <img src="{{ asset('storage/' . $kategori->gorsel) }}" alt="{{ $kategori->ad }}" class="cat-hero-img">
    @else
        <img src="https://images.unsplash.com/photo-1607344645866-009c320b63e0?q=80&w=1600" alt="Koleksiyon" class="cat-hero-img">
    @endif
    <div class="cat-hero-grain"></div>
    <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(18,28,26,0.2) 0%, rgba(18,28,26,0.85) 100%);"></div>
    <div class="cat-hero-content">
        <div class="cat-hero-breadcrumb">
            <a href="/">Anasayfa</a>
            <span>/</span>
            @if(isset($kategori) && $kategori->ustKategori)
                <a href="/kategori/{{ $kategori->ustKategori->slug }}">{{ $kategori->ustKategori->ad }}</a>
                <span>/</span>
            @endif
            <span style="color:rgba(255,255,255,.65);">{{ $kategori->ad ?? 'Tüm Ürünler' }}</span>
        </div>
        <h1 class="cat-hero-title">{{ $kategori->ad ?? 'Tüm Ürünler' }}</h1>
        <div class="cat-hero-meta">
            <span class="cat-hero-badge">
                <i class="fa-solid fa-box text-[10px]"></i>
                {{ $urunler->total() }} ürün
            </span>
            @if(isset($kategori) && $kategori->altKategoriler->count() > 0)
                <span class="cat-hero-badge">
                    <i class="fa-solid fa-sitemap text-[10px]"></i>
                    {{ $kategori->altKategoriler->count() }} alt kategori
                </span>
            @endif
        </div>
    </div>
</div>

{{-- ═══ ALT KATEGORİLER SCROLL BAR ═══ --}}
@if(isset($kategori) && $kategori->altKategoriler->count() > 0)
<div class="sub-cat-bar">
    <div class="sub-cat-inner max-w-[1440px] mx-auto px-6">
        <a href="{{ route('kategori.goster', $kategori->slug) }}" 
           class="sub-cat-chip {{ !request('alt') ? 'active' : '' }}">
            <i class="fa-solid fa-border-all text-[11px]"></i>
            Tümü
        </a>
        @foreach($kategori->altKategoriler as $alt)
            <a href="{{ route('kategori.goster', $kategori->slug) }}?alt={{ $alt->slug }}" 
               class="sub-cat-chip {{ request('alt') == $alt->slug ? 'active' : '' }}">
                @if($alt->gorsel)
                    <img src="{{ asset('storage/' . $alt->gorsel) }}" alt="{{ $alt->ad }}">
                @endif
                {{ $alt->ad }}
                <span style="font-size:10px;opacity:.6;">({{ $alt->urunler->count() }})</span>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- ═══ AKTİF FİLTRELER ═══ --}}
@if(request()->hasAny(['min_fiyat', 'max_fiyat', 'ozellik', 'alt']))
<div class="active-filters max-w-[1440px] mx-auto" style="max-width:100%;">
    <span style="font-size:11px;font-weight:700;color:var(--ink-60);margin-right:4px;">Aktif Filtreler:</span>

    @if(request('alt'))
        <span class="active-filter-tag">
            Alt Kategori: {{ request('alt') }}
            <button onclick="removeFilter('alt')"><i class="fa-solid fa-xmark"></i></button>
        </span>
    @endif

    @if(request('min_fiyat') || request('max_fiyat'))
        <span class="active-filter-tag">
            ₺{{ request('min_fiyat', 0) }} — ₺{{ request('max_fiyat', 99999) }}
            <button onclick="removeFilter('min_fiyat'); removeFilter('max_fiyat');"><i class="fa-solid fa-xmark"></i></button>
        </span>
    @endif

    <a href="{{ route('kategori.goster', $kategori->slug ?? 'tumurунler') }}" 
       style="font-size:11px;font-weight:700;color:#C0392B;margin-left:8px;text-decoration:none;">
        <i class="fa-solid fa-rotate-left mr-1"></i> Tümünü Temizle
    </a>
</div>
@endif

{{-- ═══ ANA İÇERİK ═══ --}}
<div class="shop-layout" style="max-width:1440px;margin:0 auto;">

    {{-- ════ SİDEBAR ════ --}}
    <aside class="shop-sidebar" id="shopSidebar">

        {{-- FİYAT ARALIĞI --}}
        <div class="filter-section">
            <div class="filter-title" onclick="toggleFilter(this)">
                Fiyat Aralığı <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="price-range-wrap">
                <div class="price-inputs">
                    <input type="number" class="price-input" id="minPriceInput" placeholder="Min ₺"
                           value="{{ request('min_fiyat', 0) }}" min="0">
                    <span class="price-sep">—</span>
                    <input type="number" class="price-input" id="maxPriceInput" placeholder="Max ₺"
                           value="{{ request('max_fiyat', 5000) }}" max="5000">
                </div>
                <div class="range-track">
                    <div class="range-fill" id="rangeFill"></div>
                    <input type="range" class="price-slider" id="rangeMin" min="0" max="5000" value="{{ request('min_fiyat', 0) }}" step="50">
                    <input type="range" class="price-slider" id="rangeMax" min="0" max="5000" value="{{ request('max_fiyat', 5000) }}" step="50">
                </div>
            </div>
        </div>

        {{-- RENK FİLTRESİ - EKLENDİ VE DÜZELTİLDİ --}}
        <div class="filter-section">
            <div class="filter-title" onclick="toggleFilter(this)">
                Renk <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="filter-body">
                <label class="filter-check-item">
                    <span class="filter-check-label">
                        <input type="checkbox" class="filter-check-input ozellik-filter"
                               data-key="renk" value="Siyah">
                        <span class="color-chip" style="background-color: black;"></span>
                        Siyah
                    </span>
                    <span class="filter-count">1</span>
                </label>
                <label class="filter-check-item">
                    <span class="filter-check-label">
                        <input type="checkbox" class="filter-check-input ozellik-filter"
                               data-key="renk" value="Beyaz">
                        <span class="color-chip" style="background-color: white; border-color: rgba(0,0,0,0.1);"></span>
                        Beyaz
                    </span>
                    <span class="filter-count">1</span>
                </label>
            </div>
        </div>

        {{-- STOK DURUMU - EKLENDİ VE DÜZELTİLDİ --}}
        <div class="filter-section">
            <div class="filter-title" onclick="toggleFilter(this)">
                Stok Durumu <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="filter-body">
                <label class="filter-check-item">
                    <span class="filter-check-label">
                        <input type="checkbox" class="filter-check-input" name="stok_var">
                        Stokta Var
                    </span>
                </label>
                <label class="filter-check-item">
                    <span class="filter-check-label">
                        <input type="checkbox" class="filter-check-input" name="indirimli">
                        İndirimli Ürünler
                    </span>
                </label>
            </div>
        </div>

        {{-- ÖZELLİKLER --}}
        @if(isset($ozellikler) && $ozellikler->count() > 0)
            @foreach($ozellikler as $ozellik)
            <div class="filter-section">
                <div class="filter-title" onclick="toggleFilter(this)">
                    {{ $ozellik->ad }} <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="filter-body">
                    @foreach($ozellik->degerler as $deger)
                    <label class="filter-check-item">
                        <span class="filter-check-label">
                            <input type="checkbox" class="filter-check-input ozellik-filter"
                                   data-key="{{ $ozellik->id }}" value="{{ $deger->deger }}"
                                   {{ in_array($deger->deger, (array)request('ozellik.'.$ozellik->id)) ? 'checked' : '' }}>
                            {{ $deger->deger }}
                        </span>
                        <span class="filter-count">{{ $deger->varyasyonlar->count() }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif

        {{-- FİLTRELE BUTONU - EKLENDİ --}}
        <button class="apply-filters-btn" onclick="applyAllFilters()">
            <i class="fa-solid fa-sliders mr-2"></i> Filtrele
        </button>

    </aside>

    {{-- ════ ÜRÜN LİSTESİ ════ --}}
    <div style="min-width:0;">

        {{-- TOOLBAR --}}
        <div class="shop-toolbar">
            <div class="toolbar-left">
                <button class="mobile-filter-btn" onclick="openFilterDrawer()">
                    <i class="fa-solid fa-sliders"></i> Filtrele
                    @if(request()->hasAny(['min_fiyat', 'max_fiyat', 'ozellik']))
                        <span style="width:18px;height:18px;border-radius:50%;background:var(--copper);color:white;font-size:9px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">!</span>
                    @endif
                </button>
                <p class="toolbar-result">
                    <strong>{{ $urunler->total() }}</strong> ürün bulundu
                </p>
            </div>

            <div style="display:flex;align-items:center;gap:10px;">
                <div class="view-toggle">
                    <button class="view-btn active" id="viewGrid" onclick="setView('grid')" title="Grid">
                        <i class="fa-solid fa-grid-2"></i>
                    </button>
                    <button class="view-btn" id="viewList" onclick="setView('list')" title="Liste">
                        <i class="fa-solid fa-list"></i>
                    </button>
                </div>

                <select class="sort-select" onchange="applySort(this.value)">
                    <option value="" {{ !request('siralama') ? 'selected' : '' }}>Önerilen</option>
                    <option value="fiyat_asc" {{ request('siralama') == 'fiyat_asc' ? 'selected' : '' }}>Fiyat: Düşük → Yüksek</option>
                    <option value="fiyat_desc" {{ request('siralama') == 'fiyat_desc' ? 'selected' : '' }}>Fiyat: Yüksek → Düşük</option>
                    <option value="yeni" {{ request('siralama') == 'yeni' ? 'selected' : '' }}>En Yeni</option>
                    <option value="populer" {{ request('siralama') == 'populer' ? 'selected' : '' }}>En Popüler</option>
                </select>
            </div>
        </div>

        {{-- ÜRÜN GRİD --}}
        <div class="product-grid" id="productGrid">

            @forelse($urunler as $urun)
            @php
                $anaGorsel   = $urun->gorseller->where('sira', 1)->first();
                $ikinciGorsel = $urun->gorseller->where('sira', 2)->first();
                $standartV   = $urun->varyasyonlar->first();
                $normalFiyat = $standartV?->normal_fiyat ?? 0;
                $indirimFiyat = $standartV?->indirimli_fiyat;
                $stok        = $urun->varyasyonlar->sum('anlik_stok');
                $kategoriAd  = $urun->kategoriler->first()?->ad ?? '';
                $indirimYuzde = $indirimFiyat ? round((1 - $indirimFiyat / $normalFiyat) * 100) : 0;
            @endphp

            <article class="product-card" onclick="window.location.href='{{ route('urun.detay', $urun->slug) }}'">

                {{-- GÖRSEL --}}
                <div class="product-card-img">
                    @if($anaGorsel)
                        <img src="{{ asset($anaGorsel->gorsel_url) }}" alt="{{ $urun->ad }}" loading="lazy">
                        @if($ikinciGorsel)
                            <img src="{{ asset($ikinciGorsel->gorsel_url) }}" alt="{{ $urun->ad }}" class="img-second" loading="lazy">
                        @endif
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--ivory-dk);">
                            <i class="fa-regular fa-image" style="font-size:2rem;color:var(--border);"></i>
                        </div>
                    @endif

                    {{-- BADGELER --}}
                    <div class="product-badge">
                        @if($indirimFiyat)
                            <span class="badge-tag badge-sale">-{{ $indirimYuzde }}%</span>
                        @endif
                        @if($urun->created_at->diffInDays() < 14)
                            <span class="badge-tag badge-new">Yeni</span>
                        @endif
                        @if($stok == 0)
                            <span class="badge-tag" style="background:rgba(0,0,0,.6);color:white;">Tükendi</span>
                        @endif
                    </div>

                    {{-- AKSİYON BUTONLARI --}}
                    <div class="product-actions" onclick="event.stopPropagation()">
                        <button class="product-action-btn" title="Favorilere Ekle" onclick="toggleFav(this, {{ $urun->id }})">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <button class="product-action-btn" title="Hızlı Görüntüle" onclick="quickView({{ $urun->id }})">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>

                    {{-- SEPETE EKLE --}}
                    <button class="product-add-btn" onclick="event.stopPropagation(); addToCart({{ $urun->id }})">
                        <i class="fa-solid fa-bag-shopping text-[11px]"></i>
                        Sepete Ekle
                    </button>
                </div>

                {{-- BİLGİ --}}
                <div class="product-card-body">
                    <p class="product-cat-label">{{ $kategoriAd }}</p>
                    <h3 class="product-name">{{ $urun->ad }}</h3>
                    @if($urun->kisa_aciklama)
                        <p class="product-desc">{{ $urun->kisa_aciklama }}</p>
                    @endif

                    <div class="product-price-row">
                        @if($indirimFiyat)
                            <span class="price-discounted">₺{{ number_format($indirimFiyat, 0, ',', '.') }}</span>
                            <span class="price-old">₺{{ number_format($normalFiyat, 0, ',', '.') }}</span>
                            <span class="price-save">%{{ $indirimYuzde }} İndirim</span>
                        @else
                            <span class="price-normal">₺{{ number_format($normalFiyat, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>

            </article>
            @empty
            <div class="empty-state" style="grid-column: 1/-1;">
                <div style="width:80px;height:80px;border-radius:50%;background:var(--ivory-dk);display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                    <i class="fa-solid fa-box-open" style="font-size:2rem;color:var(--border);"></i>
                </div>
                <h3 style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--ink);margin-bottom:8px;">Ürün Bulunamadı</h3>
                <p style="font-size:13px;color:var(--ink-60);margin-bottom:20px;">Bu kriterlere uygun ürün henüz eklenmemiş.</p>
                <a href="{{ route('kategori.goster', $kategori->slug ?? 'tum-urunler') }}"
                   style="padding:12px 28px;background:var(--teal);color:white;border-radius:12px;font-size:13px;font-weight:700;">
                    Filtreleri Temizle
                </a>
            </div>
            @endforelse

        </div>

        {{-- PAGİNATION --}}
        @if($urunler->hasPages())
        <div class="pagination-wrap">
            {{-- Önceki --}}
            @if($urunler->onFirstPage())
                <button class="page-btn" disabled><i class="fa-solid fa-chevron-left text-xs"></i></button>
            @else
                <a href="{{ $urunler->previousPageUrl() }}" class="page-btn">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
            @endif

            {{-- Sayfa numaraları --}}
            @foreach($urunler->getUrlRange(1, $urunler->lastPage()) as $page => $url)
                @if(abs($page - $urunler->currentPage()) <= 2 || $page == 1 || $page == $urunler->lastPage())
                    <a href="{{ $url }}" class="page-btn {{ $page == $urunler->currentPage() ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @elseif(abs($page - $urunler->currentPage()) == 3)
                    <span style="color:var(--ink-30);font-weight:700;padding:0 4px;">···</span>
                @endif
            @endforeach

            {{-- Sonraki --}}
            @if($urunler->hasMorePages())
                <a href="{{ $urunler->nextPageUrl() }}" class="page-btn">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            @else
                <button class="page-btn" disabled><i class="fa-solid fa-chevron-right text-xs"></i></button>
            @endif
        </div>
        @endif

    </div>
</div>

{{-- ═══ MOBİL FİLTRE DRAWER ═══ --}}
<div class="filter-drawer" id="filterDrawer">
    <div class="filter-drawer-overlay" onclick="closeFilterDrawer()"></div>
    <div class="filter-drawer-panel" id="filterDrawerPanel">
        <div class="filter-drawer-header">
            <h3 style="font-size:15px;font-weight:800;color:var(--ink);">Filtrele & Sırala</h3>
            <button onclick="closeFilterDrawer()" style="background:none;border:none;font-size:18px;color:var(--ink-30);cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="padding:24px;">
            {{-- Sidebar içeriğinin kopyası --}}
            <p style="font-size:12px;color:var(--ink-60);">Masaüstündeki filtreler burada da çalışır.</p>
        </div>
    </div>
</div>

<script>
/* ── View toggle ── */
function setView(v) {
    const grid = document.getElementById('productGrid');
    const btnGrid = document.getElementById('viewGrid');
    const btnList = document.getElementById('viewList');
    if (v === 'list') {
        grid.classList.add('list-view');
        btnList.classList.add('active'); btnGrid.classList.remove('active');
    } else {
        grid.classList.remove('list-view');
        btnGrid.classList.add('active'); btnList.classList.remove('active');
    }
    localStorage.setItem('shop_view', v);
}
// Kaydedilen görünümü yükle
(function(){
    const saved = localStorage.getItem('shop_view');
    if (saved) setView(saved);
})();

/* ── Fiyat slider ── */
const rMin = document.getElementById('rangeMin');
const rMax = document.getElementById('rangeMax');
const fill  = document.getElementById('rangeFill');
const iMin  = document.getElementById('minPriceInput');
const iMax  = document.getElementById('maxPriceInput');

function updateSlider() {
    const min = parseInt(rMin.value), max = parseInt(rMax.value), total = 5000;
    if (min > max - 100) { rMin.value = max - 100; return; }
    fill.style.left  = (min / total * 100) + '%';
    fill.style.width = ((max - min) / total * 100) + '%';
    iMin.value = min; iMax.value = max;
}
if (rMin) {
    rMin.addEventListener('input', updateSlider);
    rMax.addEventListener('input', updateSlider);
    iMin.addEventListener('input', function() { rMin.value = this.value; updateSlider(); });
    iMax.addEventListener('input', function() { rMax.value = this.value; updateSlider(); });
    updateSlider();
}

function applyPriceFilter() {
    const url = new URL(window.location);
    url.searchParams.set('min_fiyat', rMin.value);
    url.searchParams.set('max_fiyat', rMax.value);
    url.searchParams.delete('page');
    window.location = url;
}

/* ── Sıralama ── */
function applySort(val) {
    const url = new URL(window.location);
    if (val) url.searchParams.set('siralama', val);
    else url.searchParams.delete('siralama');
    url.searchParams.delete('page');
    window.location = url;
}

/* ── Filter section toggle ── */
function toggleFilter(el) {
    el.classList.toggle('collapsed');
    const body = el.nextElementSibling;
    if (body) {
        body.style.display = el.classList.contains('collapsed') ? 'none' : '';
    }
}

/* ── Remove filter ── */
function removeFilter(key) {
    const url = new URL(window.location);
    url.searchParams.delete(key);
    url.searchParams.delete('page');
    window.location = url;
}

/* ── All filters apply ── */
function applyAllFilters() {
    const url = new URL(window.location);
    url.searchParams.set('min_fiyat', rMin.value);
    url.searchParams.set('max_fiyat', rMax.value);
    // Özellik filtreleri
    document.querySelectorAll('.ozellik-filter:checked').forEach(cb => {
        url.searchParams.append('ozellik[' + cb.dataset.key + '][]', cb.value);
    });
    if (document.querySelector('[name="stok_var"]:checked')) url.searchParams.set('stok_var', '1');
    if (document.querySelector('[name="indirimli"]:checked')) url.searchParams.set('indirimli', '1');
    url.searchParams.delete('page');
    window.location = url;
}

/* ── Mobile drawer ── */
function openFilterDrawer() {
    const d = document.getElementById('filterDrawer');
    d.classList.add('open');
    document.body.style.overflow = 'hidden';
    setTimeout(() => d.querySelector('.filter-drawer-panel').style.transform = 'translateX(0)', 10);
}
function closeFilterDrawer() {
    document.getElementById('filterDrawer').classList.remove('open');
    document.body.style.overflow = '';
}

/* ── Favori toggle ── */
function toggleFav(btn, id) {
    btn.classList.toggle('fav-active');
    const icon = btn.querySelector('i');
    icon.classList.toggle('fa-regular');
    icon.classList.toggle('fa-solid');
    // Burada AJAX ile favori ekle/çıkar
}

/* ── Sepete ekle ── */
function addToCart(id) {
    // Animasyonlu sepet bildirim
    const notif = document.createElement('div');
    notif.style.cssText = 'position:fixed;bottom:24px;right:24px;background:var(--teal);color:white;padding:14px 24px;border-radius:16px;font-size:13px;font-weight:700;z-index:9999;box-shadow:0 8px 32px rgba(42,107,105,.35);transform:translateY(20px);opacity:0;transition:all .3s;';
    notif.innerHTML = '<i class="fa-solid fa-check mr-2"></i>Sepete eklendi!';
    document.body.appendChild(notif);
    setTimeout(() => { notif.style.transform = 'translateY(0)'; notif.style.opacity = '1'; }, 50);
    setTimeout(() => { notif.style.opacity = '0'; setTimeout(() => notif.remove(), 300); }, 2500);
}

/* ── Hızlı görüntüle ── */
function quickView(id) {
    window.location.href = '/urun/' + id;
}
</script>

@endsection