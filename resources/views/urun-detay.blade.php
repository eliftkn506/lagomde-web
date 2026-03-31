@extends('layouts.app')

@section('title', $urun->ad . ' — Lagomde')

@section('content')

<style>
/* ════════════ ÜRÜN DETAY STİLLER ════════════ */

.detail-wrap {
    max-width: 1440px;
    margin: 0 auto;
    padding: 40px 40px 80px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: start;
}
@media (max-width: 1024px) {
    .detail-wrap { grid-template-columns: 1fr; padding: 24px; gap: 32px; }
}

/* ── BREADCRUMB ── */
.breadcrumb-bar {
    background: white;
    border-bottom: 1px solid var(--border-lt);
}
.breadcrumb-inner {
    max-width: 1440px; margin: 0 auto;
    padding: 14px 40px;
    display: flex; align-items: center; gap: 8px;
    font-size: 11px; font-weight: 600;
    letter-spacing: .06em;
    color: var(--ink-60);
    overflow-x: auto; white-space: nowrap;
    -ms-overflow-style: none; scrollbar-width: none;
}
.breadcrumb-inner::-webkit-scrollbar { display: none; }
.breadcrumb-inner a { color: inherit; transition: color .15s; }
.breadcrumb-inner a:hover { color: var(--teal); }
.breadcrumb-inner .sep { color: var(--ink-30); }
.breadcrumb-inner .current { color: var(--ink); font-weight: 700; }

/* ════════ GALERİ ════════ */
.gallery-section { position: sticky; top: 120px; }

.gallery-main {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    background: var(--ivory-dk);
    aspect-ratio: 1 / 1.05;
    cursor: zoom-in;
    margin-bottom: 12px;
}
.gallery-main img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .6s cubic-bezier(.22,1,.36,1);
    transform-origin: center;
}
.gallery-main:hover img { transform: scale(1.04); }

/* Zoom overlay */
.gallery-zoom-overlay {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    background: rgba(24,32,31,.02);
    opacity: 0; transition: opacity .2s;
}
.gallery-main:hover .gallery-zoom-overlay { opacity: 1; }

/* Nav arrows */
.gallery-nav {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 44px; height: 44px; border-radius: 50%;
    background: white; border: none;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--ink);
    cursor: pointer; z-index: 3;
    box-shadow: 0 4px 20px rgba(24,32,31,.14);
    transition: all .2s;
}
.gallery-nav:hover { background: var(--teal); color: white; transform: translateY(-50%) scale(1.1); }
.gallery-nav.prev { left: 14px; }
.gallery-nav.next { right: 14px; }

/* Badge */
.gallery-badge {
    position: absolute; top: 16px; left: 16px; z-index: 2;
    display: flex; flex-direction: column; gap: 6px;
}
.gbadge {
    display: inline-block; font-size: 9px; font-weight: 800;
    letter-spacing: .1em; text-transform: uppercase;
    padding: 5px 12px; border-radius: 8px;
}
.gbadge-sale { background: #C0392B; color: white; }
.gbadge-new  { background: var(--teal); color: white; }

/* Thumbnail strip */
.gallery-thumbs {
    display: flex; gap: 8px;
    overflow-x: auto; padding-bottom: 4px;
    -ms-overflow-style: none; scrollbar-width: none;
}
.gallery-thumbs::-webkit-scrollbar { display: none; }
.gallery-thumb {
    width: 72px; min-width: 72px; height: 72px;
    border-radius: 14px; overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer; transition: border-color .2s, transform .2s;
    background: var(--ivory-dk);
}
.gallery-thumb:hover { border-color: var(--teal); transform: translateY(-2px); }
.gallery-thumb.active { border-color: var(--teal); }
.gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }

/* ════════ ÜRÜN BİLGİ PANEL ════════ */
.detail-panel { }

.detail-badges {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    margin-bottom: 14px;
}
.d-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 9px; font-weight: 800; letter-spacing: .1em;
    text-transform: uppercase; padding: 4px 12px; border-radius: 6px;
}
.d-badge-cat { background: var(--teal-lt); color: var(--teal); }
.d-badge-stock { background: #EAFAF1; color: #27AE60; }
.d-badge-outstock { background: #FFECEA; color: #C0392B; }
.d-badge-new { background: var(--copper-lt); color: var(--copper); }

.detail-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.6rem, 2.5vw, 2.2rem);
    font-weight: 700; color: var(--ink);
    line-height: 1.25; margin-bottom: 12px;
}
.detail-subtitle {
    font-size: 14px; color: var(--ink-60);
    line-height: 1.6; margin-bottom: 20px;
}

/* Değerlendirme satırı */
.rating-row {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 24px; padding-bottom: 24px;
    border-bottom: 1px solid var(--border-lt);
}
.stars { display: flex; gap: 2px; }
.stars i { font-size: 13px; color: var(--copper); }
.stars i.empty { color: var(--border); }
.rating-count { font-size: 12px; color: var(--ink-60); font-weight: 600; }
.rating-divider { width: 1px; height: 14px; background: var(--border); }
.sold-count { font-size: 12px; color: var(--ink-30); }

/* FİYAT */
.detail-price-section { margin-bottom: 28px; }
.detail-price-row { display: flex; align-items: baseline; gap: 12px; margin-bottom: 6px; }
.detail-price-main {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem; font-weight: 800; color: var(--ink);
}
.detail-price-main.discounted { color: #C0392B; }
.detail-price-old {
    font-size: 1.1rem; font-weight: 500;
    color: var(--ink-30); text-decoration: line-through;
}
.detail-price-save {
    display: inline-flex; align-items: center; gap: 4px;
    background: #EAFAF1; color: #27AE60;
    font-size: 11px; font-weight: 800;
    padding: 4px 12px; border-radius: 8px;
}
.detail-price-note {
    font-size: 11px; color: var(--ink-30);
    display: flex; align-items: center; gap: 6px;
}

/* VARYASYON */
.variant-section { margin-bottom: 24px; }
.variant-label {
    font-size: 10px; font-weight: 800;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--ink-60); margin-bottom: 10px;
    display: flex; align-items: center; justify-content: space-between;
}
.variant-selected { color: var(--teal); font-weight: 700; }
.variant-options { display: flex; flex-wrap: wrap; gap: 8px; }

.variant-btn {
    padding: 9px 18px; border-radius: 12px;
    border: 2px solid var(--border);
    font-size: 12px; font-weight: 700;
    color: var(--ink-60); background: white;
    cursor: pointer; transition: all .2s;
    font-family: 'Outfit', sans-serif;
    position: relative;
}
.variant-btn:hover { border-color: var(--teal); color: var(--teal); }
.variant-btn.selected {
    border-color: var(--teal); background: var(--teal);
    color: white; box-shadow: 0 4px 16px rgba(42,107,105,.3);
}
.variant-btn.out-of-stock {
    opacity: .45; cursor: not-allowed;
    text-decoration: line-through;
}
.variant-btn.out-of-stock::after {
    content: '';
    position: absolute;
    top: 50%; left: -4px; right: -4px;
    height: 1px; background: var(--border);
    transform: rotate(-10deg);
}

/* Renk varyasyon */
.color-btn {
    width: 38px; height: 38px; border-radius: 50%;
    border: 3px solid transparent;
    cursor: pointer; transition: transform .2s;
    outline: 3px solid transparent; outline-offset: 2px;
    position: relative;
}
.color-btn:hover { transform: scale(1.15); }
.color-btn.selected { outline-color: var(--teal); }
.color-btn.out-of-stock::after {
    content: '✕'; position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: white; font-weight: 800;
}

/* MIKTAR */
.qty-section { margin-bottom: 24px; }
.qty-control {
    display: inline-flex; align-items: center;
    border: 2px solid var(--border); border-radius: 16px;
    overflow: hidden;
}
.qty-btn {
    width: 48px; height: 48px;
    border: none; background: transparent;
    font-size: 16px; color: var(--ink-60);
    cursor: pointer; transition: all .15s;
    display: flex; align-items: center; justify-content: center;
}
.qty-btn:hover { background: var(--teal-lt); color: var(--teal); }
.qty-input {
    width: 60px; height: 48px;
    border: none; border-left: 2px solid var(--border-lt); border-right: 2px solid var(--border-lt);
    text-align: center; font-size: 16px; font-weight: 800;
    color: var(--ink); font-family: 'Outfit', sans-serif;
    outline: none; background: white;
}
.qty-stock { margin-left: 14px; font-size: 11px; color: var(--ink-30); font-weight: 600; }

/* ANA BUTONLAR */
.action-buttons { display: flex; gap: 12px; margin-bottom: 20px; }
.btn-cart {
    flex: 1;
    padding: 16px 24px;
    background: var(--teal); color: white;
    border: none; border-radius: 18px;
    font-size: 14px; font-weight: 800;
    letter-spacing: .04em; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    font-family: 'Outfit', sans-serif;
    transition: all .25s;
    box-shadow: 0 8px 32px rgba(42,107,105,.3);
}
.btn-cart:hover {
    background: var(--teal-dk);
    transform: translateY(-2px);
    box-shadow: 0 16px 40px rgba(42,107,105,.4);
}
.btn-fav {
    width: 56px; height: 56px; border-radius: 18px;
    border: 2px solid var(--border); background: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: var(--ink-60);
    cursor: pointer; transition: all .2s;
}
.btn-fav:hover, .btn-fav.active {
    border-color: #e74c3c; color: #e74c3c;
    background: #FFF5F5;
}

.btn-buy-now {
    width: 100%; padding: 16px;
    background: var(--copper); color: white;
    border: none; border-radius: 18px;
    font-size: 14px; font-weight: 800;
    cursor: pointer; font-family: 'Outfit', sans-serif;
    transition: all .25s; margin-bottom: 24px;
    box-shadow: 0 8px 24px rgba(192,122,79,.3);
}
.btn-buy-now:hover {
    background: #A86940;
    transform: translateY(-1px);
    box-shadow: 0 12px 32px rgba(192,122,79,.4);
}

/* Güvenceler */
.trust-row {
    display: flex; gap: 6px; flex-wrap: wrap;
    padding: 16px 0;
    border-top: 1px solid var(--border-lt);
    border-bottom: 1px solid var(--border-lt);
    margin-bottom: 24px;
}
.trust-item {
    display: flex; align-items: center; gap: 7px;
    font-size: 11px; font-weight: 600; color: var(--ink-60);
    flex: 1; min-width: 120px;
}
.trust-item i { color: var(--teal); font-size: 14px; }

/* Kargo hesap */
.shipping-calc {
    display: flex; gap: 8px; margin-bottom: 20px;
}
.shipping-input {
    flex: 1; padding: 11px 16px;
    border: 1.5px solid var(--border); border-radius: 12px;
    font-size: 13px; font-family: 'Outfit', sans-serif;
    color: var(--ink); outline: none; background: var(--ivory);
    transition: border-color .2s;
}
.shipping-input:focus { border-color: var(--teal); background: white; }
.shipping-btn {
    padding: 11px 18px; border-radius: 12px;
    background: var(--ivory-dk); border: 1.5px solid var(--border);
    font-size: 12px; font-weight: 700; color: var(--ink-60);
    cursor: pointer; white-space: nowrap;
    font-family: 'Outfit', sans-serif;
    transition: all .2s;
}
.shipping-btn:hover { border-color: var(--teal); color: var(--teal); }

/* ════════ DETAY TABLAR ════════ */
.detail-tabs-section {
    max-width: 1440px; margin: 0 auto;
    padding: 0 40px 60px;
    border-top: 1px solid var(--border-lt);
}
@media (max-width: 768px) { .detail-tabs-section { padding: 0 20px 40px; } }

.tab-list {
    display: flex; gap: 0;
    border-bottom: 2px solid var(--border-lt);
    margin-bottom: 40px; overflow-x: auto;
    -ms-overflow-style: none; scrollbar-width: none;
}
.tab-list::-webkit-scrollbar { display: none; }
.tab-btn {
    padding: 16px 28px;
    font-size: 13px; font-weight: 700;
    color: var(--ink-60); cursor: pointer;
    border: none; border-bottom: 3px solid transparent;
    margin-bottom: -2px; background: transparent;
    white-space: nowrap; transition: all .2s;
    font-family: 'Outfit', sans-serif;
}
.tab-btn:hover { color: var(--teal); }
.tab-btn.active { color: var(--teal); border-bottom-color: var(--teal); }

.tab-content { display: none; }
.tab-content.active { display: block; animation: fadeIn .3s ease; }

@keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

/* Açıklama içerik */
.detail-description {
    font-size: 14px; line-height: 1.85; color: var(--ink-60);
    max-width: 740px;
}
.detail-description h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem; color: var(--ink);
    margin: 28px 0 12px;
}
.detail-description ul { padding-left: 20px; margin: 12px 0; }
.detail-description li { margin-bottom: 8px; }

/* Özellik tablosu */
.spec-table { width: 100%; border-collapse: collapse; max-width: 600px; }
.spec-table tr { border-bottom: 1px solid var(--border-lt); }
.spec-table tr:last-child { border-bottom: none; }
.spec-table td {
    padding: 12px 16px; font-size: 13px;
}
.spec-table td:first-child {
    font-weight: 700; color: var(--ink-60);
    width: 40%; background: var(--ivory);
}
.spec-table td:last-child { color: var(--ink); }

/* Değerlendirmeler */
.reviews-summary {
    display: grid; grid-template-columns: auto 1fr;
    gap: 40px; align-items: center;
    padding: 32px; border-radius: 24px;
    background: var(--ivory); margin-bottom: 36px;
    border: 1px solid var(--border-lt);
}
@media (max-width: 640px) { .reviews-summary { grid-template-columns: 1fr; gap: 24px; } }
.review-score { text-align: center; }
.review-score-num {
    font-family: 'Playfair Display', serif;
    font-size: 4rem; font-weight: 800; color: var(--ink);
    line-height: 1;
}
.review-score-stars { display: flex; justify-content: center; gap: 3px; margin: 6px 0; }
.review-score-stars i { font-size: 16px; color: var(--copper); }
.review-score-count { font-size: 12px; color: var(--ink-30); font-weight: 600; }

.rating-bars { display: flex; flex-direction: column; gap: 8px; }
.rating-bar-row { display: flex; align-items: center; gap: 10px; }
.rating-bar-label { font-size: 12px; font-weight: 700; color: var(--ink-60); width: 30px; text-align: right; }
.rating-bar-track { flex: 1; height: 6px; background: var(--border-lt); border-radius: 3px; overflow: hidden; }
.rating-bar-fill { height: 100%; background: var(--copper); border-radius: 3px; transition: width .8s ease; }
.rating-bar-pct { font-size: 11px; color: var(--ink-30); width: 30px; }

.review-card {
    padding: 24px; border-radius: 20px;
    border: 1px solid var(--border-lt);
    margin-bottom: 16px; background: white;
    transition: box-shadow .2s;
}
.review-card:hover { box-shadow: var(--shadow-sm); }
.review-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
.reviewer-info { display: flex; align-items: center; gap: 12px; }
.reviewer-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--teal-lt); display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 800; color: var(--teal);
}
.reviewer-name { font-size: 14px; font-weight: 700; color: var(--ink); }
.reviewer-date { font-size: 11px; color: var(--ink-30); }
.review-stars { display: flex; gap: 2px; }
.review-stars i { font-size: 12px; color: var(--copper); }
.review-text { font-size: 13px; line-height: 1.65; color: var(--ink-60); }
.review-verified {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; font-weight: 700; color: #27AE60;
    margin-top: 10px;
}

/* ════════ BENZER ÜRÜNLER ════════ */
.related-section {
    max-width: 1440px; margin: 0 auto;
    padding: 0 40px 80px;
}
@media (max-width: 768px) { .related-section { padding: 0 20px 60px; } }
.related-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 32px; padding-bottom: 20px;
    border-bottom: 1px solid var(--border-lt);
}
.related-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem; font-weight: 700; color: var(--ink);
}
.related-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
@media (max-width: 900px) { .related-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .related-grid { grid-template-columns: 1fr; } }

/* Mini ürün kartı (benzer ürünler için) */
.mini-card {
    border-radius: 20px; overflow: hidden;
    background: white;
    border: 1px solid var(--border-lt);
    transition: all .3s;
    cursor: pointer;
}
.mini-card:hover {
    box-shadow: 0 16px 40px rgba(24,32,31,.12);
    transform: translateY(-4px);
}
.mini-card-img {
    aspect-ratio: 1 / 1; overflow: hidden;
    background: var(--ivory-dk); position: relative;
}
.mini-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
.mini-card:hover .mini-card-img img { transform: scale(1.06); }
.mini-card-body { padding: 14px 16px 18px; }
.mini-card-cat { font-size: 9px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--copper); margin-bottom: 5px; }
.mini-card-name { font-size: 13px; font-weight: 600; color: var(--ink); line-height: 1.4; margin-bottom: 10px; }
.mini-card-price { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 800; color: var(--ink); }

/* Lightbox */
.lightbox {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(18,28,26,.95); backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none; transition: opacity .3s;
}
.lightbox.open { opacity: 1; pointer-events: all; }
.lightbox img {
    max-width: 90vw; max-height: 90vh;
    border-radius: 20px; object-fit: contain;
    transform: scale(.92); transition: transform .3s;
    box-shadow: 0 40px 100px rgba(0,0,0,.5);
}
.lightbox.open img { transform: scale(1); }
.lightbox-close {
    position: absolute; top: 24px; right: 24px;
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.1); border: none;
    color: white; font-size: 18px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .2s;
}
.lightbox-close:hover { background: rgba(255,255,255,.2); }
</style>

{{-- BREADCRUMB --}}
<div class="breadcrumb-bar">
    <div class="breadcrumb-inner">
        <a href="/"><i class="fa-solid fa-house text-[10px]"></i></a>
        <span class="sep">/</span>
        @foreach($urun->kategoriler as $kat)
            @if($kat->ustKategori)
                <a href="{{ route('kategori.goster', $kat->ustKategori->slug) }}">{{ $kat->ustKategori->ad }}</a>
                <span class="sep">/</span>
            @endif
            <a href="{{ route('kategori.goster', $kat->slug) }}">{{ $kat->ad }}</a>
            <span class="sep">/</span>
        @endforeach
        <span class="current">{{ Str::limit($urun->ad, 60) }}</span>
    </div>
</div>

{{-- ANA DETAY BÖLÜMÜ --}}
<div class="detail-wrap">

    {{-- ════ GALERİ ════ --}}
    <div class="gallery-section">

        <div class="gallery-main" id="galleryMain" onclick="openLightbox(currentGalleryIndex)">
            @if($urun->gorseller->count() > 0)
                <img src="{{ asset($urun->gorseller->first()->gorsel_url) }}" 
                     alt="{{ $urun->ad }}" id="mainGalleryImg">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--ivory-dk);">
                    <i class="fa-regular fa-image" style="font-size:4rem;color:var(--border);"></i>
                </div>
            @endif

            @if($urun->gorseller->count() > 1)
            <button class="gallery-nav prev" onclick="event.stopPropagation(); changeGallery(-1)">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button class="gallery-nav next" onclick="event.stopPropagation(); changeGallery(1)">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>
            @endif

            @php
                $standartV    = $urun->varyasyonlar->first();
                $normalFiyat  = $standartV?->normal_fiyat ?? 0;
                $indirimFiyat = $standartV?->indirimli_fiyat;
                $indirimYuzde = $indirimFiyat ? round((1 - $indirimFiyat / $normalFiyat) * 100) : 0;
            @endphp
            <div class="gallery-badge">
                @if($indirimFiyat)
                    <span class="gbadge gbadge-sale">-{{ $indirimYuzde }}%</span>
                @endif
                @if($urun->created_at->diffInDays() < 14)
                    <span class="gbadge gbadge-new">Yeni Geldi</span>
                @endif
            </div>

            <div class="gallery-zoom-overlay">
                <div style="width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,.9);display:flex;align-items:center;justify-content:center;color:var(--ink);font-size:16px;">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </div>
            </div>
        </div>

        {{-- THUMBNAIL STRİP --}}
        @if($urun->gorseller->count() > 1)
        <div class="gallery-thumbs">
            @foreach($urun->gorseller as $idx => $gorsel)
                <div class="gallery-thumb {{ $idx === 0 ? 'active' : '' }}"
                     onclick="setGallery({{ $idx }})">
                    <img src="{{ asset($gorsel->gorsel_url) }}" alt="{{ $urun->ad }} görsel {{ $idx + 1 }}">
                </div>
            @endforeach
        </div>
        @endif

    </div>

    {{-- ════ BİLGİ PANELİ ════ --}}
    <div class="detail-panel">

        {{-- Badges --}}
        <div class="detail-badges">
            @foreach($urun->kategoriler->take(2) as $kat)
                <span class="d-badge d-badge-cat">{{ $kat->ad }}</span>
            @endforeach
            @php $toplamStok = $urun->varyasyonlar->sum('anlik_stok'); @endphp
            @if($toplamStok > 0)
                <span class="d-badge d-badge-stock"><i class="fa-solid fa-circle-check"></i> Stokta</span>
            @else
                <span class="d-badge d-badge-outstock"><i class="fa-solid fa-circle-xmark"></i> Tükendi</span>
            @endif
            @if($urun->created_at->diffInDays() < 14)
                <span class="d-badge d-badge-new">✦ Yeni</span>
            @endif
        </div>

        <h1 class="detail-title">{{ $urun->ad }}</h1>

        @if($urun->kisa_aciklama)
            <p class="detail-subtitle">{{ $urun->kisa_aciklama }}</p>
        @endif

        {{-- Değerlendirme --}}
        @php $degCount = $urun->degerlendirmeler->count(); $avgPuan = $degCount > 0 ? round($urun->degerlendirmeler->avg('puan'), 1) : 0; @endphp
        <div class="rating-row">
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fa-{{ $i <= $avgPuan ? 'solid' : 'regular' }} fa-star {{ $i <= $avgPuan ? '' : 'empty' }}"></i>
                @endfor
            </div>
            <span class="rating-count">{{ number_format($avgPuan, 1) }}</span>
            <span class="rating-divider"></span>
            <a href="#yorumlar" style="font-size:12px;font-weight:600;color:var(--teal);">{{ $degCount }} değerlendirme</a>
            <span class="rating-divider"></span>
            <span class="sold-count">500+ satıldı</span>
        </div>

        {{-- FİYAT --}}
        <div class="detail-price-section">
            <div class="detail-price-row">
                @if($indirimFiyat)
                    <span class="detail-price-main discounted">₺{{ number_format($indirimFiyat, 0, ',', '.') }}</span>
                    <span class="detail-price-old">₺{{ number_format($normalFiyat, 0, ',', '.') }}</span>
                    <span class="detail-price-save">
                        <i class="fa-solid fa-tag text-[10px]"></i>
                        %{{ $indirimYuzde }} İndirim
                    </span>
                @else
                    <span class="detail-price-main">₺{{ number_format($normalFiyat, 0, ',', '.') }}</span>
                @endif
            </div>
            <p class="detail-price-note">
                <i class="fa-solid fa-truck-fast"></i>
                500₺ üzeri siparişlerde ücretsiz kargo
            </p>
        </div>

        {{-- VARYASYONLAR --}}
        @if($urun->varyasyonlu_mu && $urun->varyasyonlar->count() > 1)
        <div class="variant-section">
            @php
                $ozellikGruplari = [];
                foreach ($urun->varyasyonlar as $v) {
                    foreach ($v->ozellikDegerleri as $deg) {
                        $ozellikGruplari[$deg->ozellik->ad][$deg->deger] = [
                            'stok' => $v->anlik_stok,
                            'varyasyon_id' => $v->id,
                            'fiyat' => $v->indirimli_fiyat ?? $v->normal_fiyat,
                        ];
                    }
                }
            @endphp

            @foreach($ozellikGruplari as $ozellikAd => $degerler)
            <div style="margin-bottom: 20px;">
                <div class="variant-label">
                    {{ $ozellikAd }}
                    <span class="variant-selected" id="selected_{{ Str::slug($ozellikAd) }}">Seçiniz</span>
                </div>
                <div class="variant-options">
                    @foreach($degerler as $deger => $info)
                        <button class="variant-btn {{ $info['stok'] == 0 ? 'out-of-stock' : '' }}"
                                onclick="selectVariant(this, '{{ Str::slug($ozellikAd) }}', '{{ $deger }}')"
                                data-price="{{ $info['fiyat'] }}"
                                {{ $info['stok'] == 0 ? 'disabled' : '' }}>
                            {{ $deger }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- MİKTAR --}}
        <div class="qty-section">
            <div class="variant-label" style="margin-bottom:10px;">Miktar</div>
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="qty-control">
                    <button class="qty-btn" onclick="changeQty(-1)">−</button>
                    <input type="number" class="qty-input" id="qtyInput" value="1" min="1" max="{{ $toplamStok }}">
                    <button class="qty-btn" onclick="changeQty(1)">+</button>
                </div>
                @if($toplamStok > 0 && $toplamStok < 20)
                    <span class="qty-stock" style="color: #e67e22;">
                        <i class="fa-solid fa-fire text-orange-400"></i>
                        Son {{ $toplamStok }} ürün!
                    </span>
                @elseif($toplamStok >= 20)
                    <span class="qty-stock">{{ $toplamStok }} adet stokta</span>
                @endif
            </div>
        </div>

        {{-- ANA EYLEM BUTONLARI --}}
        <div class="action-buttons">
            <button class="btn-cart" onclick="addToCartDetail()">
                <i class="fa-solid fa-bag-shopping"></i>
                Sepete Ekle
            </button>
            <button class="btn-fav" id="favBtn" onclick="toggleDetailFav()" title="Favorilere Ekle">
                <i class="fa-regular fa-heart"></i>
            </button>
        </div>
        <button class="btn-buy-now">
            <i class="fa-solid fa-bolt mr-2"></i> Hemen Satın Al
        </button>

        {{-- GÜVENCE ÇUBUĞU --}}
        <div class="trust-row">
            <div class="trust-item">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Güvenli Ödeme</span>
            </div>
            <div class="trust-item">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Hızlı Teslimat</span>
            </div>
            <div class="trust-item">
                <i class="fa-solid fa-rotate-left"></i>
                <span>30 Gün İade</span>
            </div>
            <div class="trust-item">
                <i class="fa-solid fa-gift"></i>
                <span>Hediye Paketi</span>
            </div>
        </div>

        {{-- KARGO HESAPLA --}}
        <div>
            <p style="font-size:11px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-60);margin-bottom:8px;">
                Kargo Süresi Hesapla
            </p>
            <div class="shipping-calc">
                <input type="text" class="shipping-input" placeholder="Posta kodunuzu girin..." maxlength="5">
                <button class="shipping-btn">Hesapla</button>
            </div>
        </div>

        {{-- PAYLAŞ --}}
        <div style="display:flex;align-items:center;gap:10px;margin-top:16px;">
            <span style="font-size:11px;font-weight:700;color:var(--ink-30);">Paylaş:</span>
            @foreach(['instagram','facebook','twitter','whatsapp'] as $social)
            <a href="#" style="width:32px;height:32px;border-radius:50%;background:var(--ivory-dk);border:1px solid var(--border-lt);display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--ink-60);transition:all .2s;"
               onmouseover="this.style.background='var(--teal)';this.style.color='white'"
               onmouseout="this.style.background='var(--ivory-dk)';this.style.color='var(--ink-60)'">
                <i class="fa-brands fa-{{ $social }}"></i>
            </a>
            @endforeach
        </div>

    </div>
</div>

{{-- ════════════ DETAY TABLAR ════════════ --}}
<div class="detail-tabs-section" id="urunDetay">
    <div class="tab-list">
        <button class="tab-btn active" onclick="switchTab(this, 'aciklama')">Ürün Detayları</button>
        <button class="tab-btn" onclick="switchTab(this, 'ozellikler')">Teknik Özellikler</button>
        <button class="tab-btn" onclick="switchTab(this, 'yorumlar')" id="yorumlarTabBtn">
            Değerlendirmeler
            @if($degCount > 0)
                <span style="margin-left:6px;background:var(--teal);color:white;font-size:9px;font-weight:800;padding:2px 7px;border-radius:999px;">{{ $degCount }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab(this, 'kargo')">Kargo & İade</button>
    </div>

    {{-- AÇIKLAMA --}}
    <div class="tab-content active" id="tab-aciklama">
        <div class="detail-description">
            {!! nl2br(e($urun->detayli_aciklama)) !!}

            @if(!$urun->detayli_aciklama)
                <p style="color:var(--ink-30);font-style:italic;">Bu ürün için detaylı açıklama henüz eklenmemiş.</p>
            @endif
        </div>
    </div>

    {{-- VARYASYON ÖZELLİKLERİ --}}
    <div class="tab-content" id="tab-ozellikler">
        <table class="spec-table">
            <tbody>
                <tr><td>Ürün Kodu</td><td>{{ $urun->varyasyonlar->first()?->sku ?? '-' }}</td></tr>
                <tr><td>Barkod</td><td>{{ $urun->varyasyonlar->first()?->barkod ?? '-' }}</td></tr>
                <tr><td>Ürün Tipi</td><td>{{ $urun->urun_tipi }}</td></tr>
                @foreach($urun->varyasyonlar->first()?->ozellikDegerleri ?? [] as $deg)
                    <tr>
                        <td>{{ $deg->ozellik->ad }}</td>
                        <td>{{ $deg->deger }}</td>
                    </tr>
                @endforeach
                <tr><td>Stok Durumu</td><td>{{ $toplamStok > 0 ? $toplamStok . ' adet' : 'Tükendi' }}</td></tr>
                <tr><td>Ekleme Tarihi</td><td>{{ $urun->created_at->format('d.m.Y') }}</td></tr>
            </tbody>
        </table>
    </div>

    {{-- DEĞERLENDİRMELER --}}
    <div class="tab-content" id="tab-yorumlar" id="yorumlar">

        {{-- ÖZET --}}
        <div class="reviews-summary">
            <div class="review-score">
                <div class="review-score-num">{{ number_format($avgPuan, 1) }}</div>
                <div class="review-score-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa-{{ $i <= $avgPuan ? 'solid' : 'regular' }} fa-star"></i>
                    @endfor
                </div>
                <div class="review-score-count">{{ $degCount }} değerlendirme</div>
            </div>
            <div class="rating-bars">
                @for($star = 5; $star >= 1; $star--)
                    @php $count = $urun->degerlendirmeler->where('puan', $star)->count(); $pct = $degCount > 0 ? ($count/$degCount*100) : 0; @endphp
                    <div class="rating-bar-row">
                        <span class="rating-bar-label">{{ $star }}⭐</span>
                        <div class="rating-bar-track">
                            <div class="rating-bar-fill" style="width:{{ $pct }}%"></div>
                        </div>
                        <span class="rating-bar-pct">{{ $count }}</span>
                    </div>
                @endfor
            </div>
        </div>

        {{-- YORUM KARTI --}}
        @forelse($urun->degerlendirmeler->take(5) as $deg)
        <div class="review-card">
            <div class="review-header">
                <div class="reviewer-info">
                    <div class="reviewer-avatar">{{ mb_strtoupper(mb_substr($deg->kullanici->ad ?? 'A', 0, 1)) }}</div>
                    <div>
                        <div class="reviewer-name">{{ $deg->kullanici->ad ?? 'Anonim' }}</div>
                        <div class="reviewer-date">{{ $deg->created_at->format('d.m.Y') }}</div>
                    </div>
                </div>
                <div class="review-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa-{{ $i <= $deg->puan ? 'solid' : 'regular' }} fa-star"></i>
                    @endfor
                </div>
            </div>
            <p class="review-text">{{ $deg->yorum ?? 'Harika ürün, çok memnun kaldım.' }}</p>
            <div class="review-verified">
                <i class="fa-solid fa-circle-check"></i> Doğrulanmış Satın Alım
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:40px;color:var(--ink-30);">
            <i class="fa-regular fa-star" style="font-size:2.5rem;display:block;margin-bottom:12px;"></i>
            <p style="font-size:14px;font-weight:600;">Henüz değerlendirme yapılmamış.</p>
            <p style="font-size:12px;margin-top:6px;">İlk değerlendirmeyi siz yapın!</p>
        </div>
        @endforelse

    </div>

    {{-- KARGO & İADE --}}
    <div class="tab-content" id="tab-kargo">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:700px;">
            @foreach([
                ['fa-truck-fast','Hızlı Teslimat','Siparişiniz aynı iş günü kargoya verilir. Standart teslimat 1-3 iş günüdür.'],
                ['fa-rotate-left','30 Gün İade','Ürünü beğenmediyseniz 30 gün içinde koşulsuz iade edebilirsiniz.'],
                ['fa-shield-halved','Güvenli Paketleme','Ürünler özel korumalı kutularda, hasar görmeden teslim edilir.'],
                ['fa-headset','7/24 Destek','Herhangi bir sorun için müşteri hizmetlerimiz her zaman yanınızda.'],
            ] as [$icon,$title,$desc])
            <div style="display:flex;gap:14px;padding:20px;border-radius:16px;background:var(--ivory);border:1px solid var(--border-lt);">
                <div style="width:44px;height:44px;border-radius:14px;background:var(--teal-lt);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid {{ $icon }}" style="color:var(--teal);font-size:18px;"></i>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:800;color:var(--ink);margin-bottom:5px;">{{ $title }}</p>
                    <p style="font-size:12px;color:var(--ink-60);line-height:1.5;">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ════════ BENZER ÜRÜNLER ════════ --}}
@if(isset($benzerUrunler) && $benzerUrunler->count() > 0)
<div class="related-section">
    <div class="related-header">
        <div>
            <p style="font-size:10px;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:var(--copper);margin-bottom:6px;">Bunları da Beğenebilirsiniz</p>
            <h2 class="related-title">Benzer Ürünler</h2>
        </div>
        <a href="{{ route('kategori.goster', $urun->kategoriler->first()?->slug ?? 'tum-urunler') }}"
           style="font-size:12px;font-weight:700;color:var(--teal);display:inline-flex;align-items:center;gap:6px;">
            Tümünü Gör <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="related-grid">
        @foreach($benzerUrunler as $b)
        @php
            $bGorsel = $b->gorseller->first();
            $bV = $b->varyasyonlar->first();
        @endphp
        <div class="mini-card" onclick="window.location.href='{{ route('urun.detay', $b->slug) }}'">
            <div class="mini-card-img">
                @if($bGorsel)
                    <img src="{{ asset($bGorsel->gorsel_url) }}" alt="{{ $b->ad }}" loading="lazy">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-regular fa-image" style="color:var(--border);font-size:2rem;"></i>
                    </div>
                @endif
                @if($bV?->indirimli_fiyat)
                    <span style="position:absolute;top:10px;left:10px;background:#C0392B;color:white;font-size:9px;font-weight:800;padding:3px 9px;border-radius:6px;letter-spacing:.08em;">İNDİRİM</span>
                @endif
            </div>
            <div class="mini-card-body">
                <div class="mini-card-cat">{{ $b->kategoriler->first()?->ad }}</div>
                <div class="mini-card-name">{{ Str::limit($b->ad, 50) }}</div>
                <div style="display:flex;align-items:center;gap:8px;">
                    @if($bV?->indirimli_fiyat)
                        <span class="mini-card-price" style="color:#C0392B;">₺{{ number_format($bV->indirimli_fiyat, 0, ',', '.') }}</span>
                        <span style="font-size:12px;text-decoration:line-through;color:var(--ink-30);">₺{{ number_format($bV->normal_fiyat, 0, ',', '.') }}</span>
                    @else
                        <span class="mini-card-price">₺{{ number_format($bV?->normal_fiyat ?? 0, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- LİGHTBOX --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="fa-solid fa-xmark"></i></button>
    <img id="lightboxImg" src="" alt="">
</div>

<script>
// ── Galeri görselleri ──
const galleryImages = @json($urun->gorseller->pluck('gorsel_url')->map(fn($u) => asset($u)));
let currentGalleryIndex = 0;

function setGallery(idx) {
    currentGalleryIndex = idx;
    document.getElementById('mainGalleryImg').src = galleryImages[idx];
    document.querySelectorAll('.gallery-thumb').forEach((t, i) => {
        t.classList.toggle('active', i === idx);
    });
}

function changeGallery(dir) {
    const len = galleryImages.length;
    setGallery((currentGalleryIndex + dir + len) % len);
}

// Klavye ile navigasyon
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').classList.contains('open')) {
        if (e.key === 'ArrowLeft') changeGallery(-1);
        if (e.key === 'ArrowRight') changeGallery(1);
        if (e.key === 'Escape') closeLightbox();
    }
});

// ── Lightbox ──
function openLightbox(idx) {
    const lb = document.getElementById('lightbox');
    document.getElementById('lightboxImg').src = galleryImages[idx];
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}

// ── Tab sistemi ──
function switchTab(btn, tabId) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + tabId).classList.add('active');
}

// ── Varyasyon seçimi ──
function selectVariant(btn, group, val) {
    btn.closest('.variant-section > div, [style]').querySelectorAll('.variant-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    const label = document.getElementById('selected_' + group);
    if (label) label.textContent = val;
}

// ── Miktar ──
function changeQty(dir) {
    const inp = document.getElementById('qtyInput');
    const max = parseInt(inp.max) || 99;
    const val = Math.min(max, Math.max(1, parseInt(inp.value) + dir));
    inp.value = val;
}

// ── Favori toggle ──
function toggleDetailFav() {
    const btn = document.getElementById('favBtn');
    btn.classList.toggle('active');
    const icon = btn.querySelector('i');
    icon.classList.toggle('fa-regular');
    icon.classList.toggle('fa-solid');
}

// ── Sepet bildirimi ──
function addToCartDetail() {
    const notif = document.createElement('div');
    notif.style.cssText = 'position:fixed;bottom:24px;right:24px;background:var(--teal);color:white;padding:16px 28px;border-radius:20px;font-size:14px;font-weight:700;z-index:9999;box-shadow:0 12px 40px rgba(42,107,105,.4);transform:translateY(30px);opacity:0;transition:all .35s cubic-bezier(.22,1,.36,1);display:flex;align-items:center;gap:10px;';
    notif.innerHTML = '<i class="fa-solid fa-bag-shopping"></i> Sepete eklendi!';
    document.body.appendChild(notif);
    requestAnimationFrame(() => { notif.style.transform = 'translateY(0)'; notif.style.opacity = '1'; });
    setTimeout(() => { notif.style.opacity = '0'; notif.style.transform = 'translateY(10px)'; setTimeout(() => notif.remove(), 350); }, 2800);
}

// ── Anchor tab link ──
if (window.location.hash === '#yorumlar') {
    setTimeout(() => {
        const btn = document.getElementById('yorumlarTabBtn');
        if (btn) btn.click();
    }, 300);
}
</script>

@endsection