@extends('layouts.app')

@section('title', 'Lagomde — Anlamlı Hediyeler')

@section('content')

{{-- ══════════════════════════════════════════════════
     1. KATEGORİ VİTRİNİ
     Sol: büyük featured kart  |  Sağ: 2×3 grid
══════════════════════════════════════════════════ --}}
<section class="max-w-[1440px] mx-auto px-6 lg:px-10 pt-10 pb-6 fade-up">

    @if($vitrinKategorileri->count() > 0)
        @php
            $ilkKategori   = $vitrinKategorileri->first();
            $digerKategoriler = $vitrinKategorileri->slice(1, 6);
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4" style="height:auto lg:height:580px">

            {{-- BÜYÜK SOL KART --}}
            <a href="#"
               class="card-lift lg:col-span-2 relative rounded-3xl overflow-hidden block"
               style="min-height:420px">
                
                {{-- Veritabanından görsel kontrolü: Görsel varsa storage'dan çek, yoksa varsayılan placeholder kullan --}}
                <img src="{{ $ilkKategori->gorsel ? asset('storage/' . $ilkKategori->gorsel) : 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?q=80&w=1000&auto=format&fit=crop' }}"
                     alt="{{ $ilkKategori->ad }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 hover:scale-[1.03]">
                
                {{-- gradient --}}
                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(26,22,18,.88) 0%, rgba(26,22,18,.0) 55%)"></div>
                {{-- tag --}}
                <span class="absolute top-5 left-5 text-[10px] font-semibold tracking-[.12em] uppercase px-3 py-1.5 rounded-full" style="background:rgba(253,250,246,.15);backdrop-filter:blur(8px);color:#fff;border:1px solid rgba(255,255,255,.2)">Öne Çıkan</span>
                {{-- label --}}
                <div class="absolute bottom-0 left-0 right-0 p-7">
                    <p class="text-[11px] tracking-[.1em] uppercase mb-2" style="color:rgba(255,255,255,.55)">Kategori</p>
                    <h2 class="font-display text-white text-3xl font-semibold leading-tight mb-4">{{ $ilkKategori->ad }}</h2>
                    <span class="inline-flex items-center gap-2 text-[12px] font-medium px-4 py-2 rounded-full transition" style="background:var(--accent);color:#fff">
                        Keşfet <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

            {{-- SAĞ 2×3 GRID --}}
            <div class="lg:col-span-3 grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($digerKategoriler as $i => $kat)
                    <a href="#"
                       class="card-lift relative rounded-2xl overflow-hidden block"
                       style="min-height:180px">
                        
                        {{-- Veritabanından görsel kontrolü --}}
                        <img src="{{ $kat->gorsel ? asset('storage/' . $kat->gorsel) : 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=600&auto=format&fit=crop' }}"
                             alt="{{ $kat->ad }}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 hover:scale-[1.05]">
                        
                        <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(26,22,18,.78) 0%, transparent 55%)"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white text-[14px] font-semibold leading-snug">{{ $kat->ad }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>

    @else
        <div class="flex flex-col items-center justify-center py-24 rounded-3xl" style="background:var(--border);color:var(--muted)">
            <i class="fa-regular fa-folder-open text-4xl mb-4 opacity-40"></i>
            <p class="text-sm">Admin panelinden henüz kategori eklenmemiş.</p>
        </div>
    @endif

</section>


{{-- ══════════════════════════════════════════════════
     2. AMAÇ / OCCASION ŞERİDİ
══════════════════════════════════════════════════ --}}
<section class="max-w-[1440px] mx-auto px-6 lg:px-10 py-12 fade-up delay-1">

    <div class="flex items-end justify-between mb-8">
        <div>
            <p class="text-[11px] tracking-[.12em] uppercase font-semibold mb-1" style="color:var(--accent)">Bir Neden Seç</p>
            <h2 class="font-display text-3xl" style="color:var(--ink)">Hangi Anı Özel Kılacaksın?</h2>
        </div>
        <a href="#" class="hidden md:flex items-center gap-2 text-xs font-medium transition hover:text-[var(--accent)]" style="color:var(--muted)">
            Tümü <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    @php
        $anlar = [
            ['icon'=>'fa-cake-candles',   'label'=>'Doğum Günü',    'count'=>'84 ürün'],
            ['icon'=>'fa-heart',          'label'=>'Sevgiliye',     'count'=>'61 ürün'],
            ['icon'=>'fa-champagne-glasses','label'=>'Yıl Dönümü',  'count'=>'47 ürün'],
            ['icon'=>'fa-graduation-cap', 'label'=>'Mezuniyet',     'count'=>'39 ürün'],
            ['icon'=>'fa-briefcase',      'label'=>'Kurumsal',      'count'=>'52 ürün'],
            ['icon'=>'fa-baby',           'label'=>'Bebek Hediyesi','count'=>'31 ürün'],
            ['icon'=>'fa-house-chimney',  'label'=>'Ev Hediyesi',   'count'=>'28 ürün'],
            ['icon'=>'fa-star',           'label'=>'Özel Günler',   'count'=>'90 ürün'],
        ];
    @endphp

    <div class="grid grid-cols-4 md:grid-cols-8 gap-3">
        @foreach($anlar as $i => $an)
            <a href="#"
               class="group flex flex-col items-center gap-3 p-4 rounded-2xl transition duration-200 hover:-translate-y-1"
               style="background:var(--warm-white);border:1.5px solid var(--border)">
                <div class="w-12 h-12 flex items-center justify-center rounded-xl transition" style="background:var(--cream)">
                    <i class="fa-solid {{ $an['icon'] }} text-lg transition group-hover:text-[var(--accent)]" style="color:var(--ink)"></i>
                </div>
                <div class="text-center">
                    <p class="text-[12px] font-semibold leading-tight" style="color:var(--ink)">{{ $an['label'] }}</p>
                    <p class="text-[10px] mt-0.5" style="color:var(--muted)">{{ $an['count'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     3. FULL-WIDTH BANNER — "KENDİ KUTUNU YAP"
══════════════════════════════════════════════════ --}}
<section class="mx-6 lg:mx-10 my-6 rounded-3xl overflow-hidden relative fade-up delay-2" style="min-height:280px;background:var(--ink)">
    {{-- arka görsel --}}
    <img src="https://images.unsplash.com/photo-1607344645866-009c320b63e0?q=80&w=1600&auto=format&fit=crop"
         alt="Kendi Kutunu Yap"
         class="absolute inset-0 w-full h-full object-cover opacity-30">
    {{-- desen --}}
    <div class="absolute inset-0" style="background:radial-gradient(ellipse at 70% 50%, rgba(201,149,106,.25) 0%, transparent 65%)"></div>

    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 px-10 py-14 max-w-[1440px] mx-auto">
        <div>
            <p class="text-[11px] tracking-[.15em] uppercase font-semibold mb-3" style="color:var(--accent)">Yeni Deneyim</p>
            <h2 class="font-display text-white text-4xl md:text-5xl font-semibold leading-tight max-w-lg">
                Kendi Hediye<br>Kutunu Tasarla
            </h2>
            <p class="text-sm mt-4 max-w-sm leading-relaxed" style="color:rgba(255,255,255,.55)">
                İstediğin ürünleri seç, kişisel notunu ekle — tamamen sana özel bir kutu hazırlıyoruz.
            </p>
        </div>
        <div class="flex-shrink-0">
            <a href="#"
               class="inline-flex items-center gap-3 px-8 py-4 rounded-full font-semibold text-sm transition hover:gap-5"
               style="background:var(--accent);color:#fff">
                Hemen Başla
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     4. ÖZEL KOLEKSIYONLAR
══════════════════════════════════════════════════ --}}
<section class="max-w-[1440px] mx-auto px-6 lg:px-10 py-14 fade-up delay-3">

    <div class="mb-8">
        <p class="text-[11px] tracking-[.12em] uppercase font-semibold mb-1" style="color:var(--accent)">Editörün Seçimi</p>
        <h2 class="font-display text-3xl" style="color:var(--ink)">Özel Koleksiyonlar</h2>
    </div>

    @php
        $koleksiyonlar = [
            [
                'img'   => 'https://images.unsplash.com/photo-1512909006721-3d6018887383?q=80&w=700&auto=format&fit=crop',
                'baslik'=> 'Minimalist Yaşam',
                'desc'  => 'Sade ve anlamlı seçimler',
                'renk'  => '#DED6CC',
            ],
            [
                'img'   => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=700&auto=format&fit=crop',
                'baslik'=> 'Kitap & Kahve',
                'desc'  => 'Huzurun adresi',
                'renk'  => '#C8D6C0',
            ],
            [
                'img'   => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?q=80&w=700&auto=format&fit=crop',
                'baslik'=> 'Bakım & Güzellik',
                'desc'  => 'Kendine iyi bak',
                'renk'  => '#D6C0C8',
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @foreach($koleksiyonlar as $k)
            <a href="#" class="card-lift group block rounded-3xl overflow-hidden relative" style="min-height:340px;background:{{ $k['renk'] }}">
                <img src="{{ $k['img'] }}"
                     alt="{{ $k['baslik'] }}"
                     class="absolute inset-0 w-full h-full object-cover opacity-75 transition-opacity duration-500 group-hover:opacity-90">
                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(26,22,18,.65) 0%, transparent 50%)"></div>
                <div class="absolute bottom-0 left-0 right-0 p-7">
                    <h3 class="font-display text-white text-2xl font-semibold mb-1">{{ $k['baslik'] }}</h3>
                    <p class="text-sm mb-4" style="color:rgba(255,255,255,.65)">{{ $k['desc'] }}</p>
                    <span class="inline-flex items-center gap-2 text-xs font-medium" style="color:rgba(255,255,255,.8)">
                        Keşfet <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     5. NEDEN LAGOMDE?
══════════════════════════════════════════════════ --}}
<section class="border-t border-b py-14 fade-up delay-4" style="border-color:var(--border);background:var(--warm-white)">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-10">

        <div class="text-center mb-12">
            <p class="text-[11px] tracking-[.12em] uppercase font-semibold mb-2" style="color:var(--accent)">Neden Lagomde?</p>
            <h2 class="font-display text-4xl" style="color:var(--ink)">Hediye Vermek Bu Kadar Kolaydı</h2>
        </div>

        @php
            $vaatler = [
                ['icon'=>'fa-truck-fast',    'baslik'=>'Aynı Gün Gönderim', 'desc'=>'Saat 14.00\'e kadar verilen siparişler bugün kargolanır.'],
                ['icon'=>'fa-gift',          'baslik'=>'Ücretsiz Paketleme', 'desc'=>'Her sipariş özenli, markalı kutu ile gönderilir.'],
                ['icon'=>'fa-pen-nib',       'baslik'=>'Kişisel Not',        'desc'=>'Hediyene sevgiliye özel, el yazısı kart ekle.'],
                ['icon'=>'fa-rotate-left',   'baslik'=>'Koşulsuz İade',      'desc'=>'Beğenmezsen 30 gün içinde iade garanti.'],
            ];
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($vaatler as $v)
                <div class="flex flex-col items-center text-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center rounded-2xl" style="background:var(--cream)">
                        <i class="fa-solid {{ $v['icon'] }} text-xl" style="color:var(--accent)"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold mb-1" style="color:var(--ink)">{{ $v['baslik'] }}</p>
                        <p class="text-xs leading-relaxed" style="color:var(--muted)">{{ $v['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════
     6. INSTAGRAM / GÖRSEL GRID
══════════════════════════════════════════════════ --}}
<section class="max-w-[1440px] mx-auto px-6 lg:px-10 py-14">

    <div class="flex items-end justify-between mb-8">
        <div>
            <p class="text-[11px] tracking-[.12em] uppercase font-semibold mb-1" style="color:var(--accent)">@lagomde</p>
            <h2 class="font-display text-3xl" style="color:var(--ink)">İlham Galerisi</h2>
        </div>
        <a href="#" class="hidden md:flex items-center gap-2 text-xs font-medium transition hover:text-[var(--accent)]" style="color:var(--muted)">
            Instagram'da Takip Et <i class="fa-brands fa-instagram text-sm"></i>
        </a>
    </div>

    @php
        $galeri = [
            'https://images.unsplash.com/photo-1607344645866-009c320b63e0?q=80&w=500',
            'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=500',
            'https://images.unsplash.com/photo-1512413914856-12151121d120?q=80&w=500',
            'https://images.unsplash.com/photo-1542314546-527e02df357e?q=80&w=500',
            'https://images.unsplash.com/photo-1518199266791-5375a83190b7?q=80&w=500',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=500',
        ];
    @endphp

    <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
        @foreach($galeri as $g)
            <a href="#" class="group relative rounded-xl overflow-hidden aspect-square">
                <img src="{{ $g }}" alt="" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition" style="background:rgba(26,22,18,.4)">
                    <i class="fa-brands fa-instagram text-white text-xl"></i>
                </div>
            </a>
        @endforeach
    </div>
</section>

@endsection