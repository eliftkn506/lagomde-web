@extends('layouts.app')

@section('title', 'Lagomde — Anlamlı Hediyeler')

@section('content')

{{-- ══════════════════════════════════════════════════
     1. MODERN KATEGORİ VİTRİNİ (Resimli Dinamik Grid)
══════════════════════════════════════════════════ --}}
<section class="max-w-[1440px] mx-auto px-6 lg:px-10 pt-10 pb-6 fade-up">
    @if(isset($vitrinKategorileri) && $vitrinKategorileri->count() > 0)
        @php
            // İlk kategoriyi BÜYÜK kart yapıyoruz, sonrakileri küçük kart.
            $ilkKategori   = $vitrinKategorileri->first();
            $digerKategoriler = $vitrinKategorileri->slice(1, 4); // Sağ tarafta 4 kutu
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-5">
            
            {{-- SOL BÜYÜK KART (2 Kolon, 2 Satır kaplar) --}}
            <a href="#" class="group relative rounded-[2rem] overflow-hidden md:col-span-2 md:row-span-2 h-[400px] md:h-full block shadow-sm">
                {{-- Resim Admin Panelinden gelir --}}
                <img src="{{ $ilkKategori->gorsel ? asset('storage/' . $ilkKategori->gorsel) : 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=800' }}"
                     alt="{{ $ilkKategori->ad }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-105">
                
                {{-- Koyu Gradyan (Yazıların okunması için) --}}
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(30,30,30,0.85) 0%, rgba(30,30,30,0) 60%);"></div>
                
                {{-- Etiket --}}
                <span class="absolute top-6 left-6 text-[10px] font-bold tracking-[0.15em] uppercase px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-white border border-white/30 shadow-sm">
                    Öne Çıkan
                </span>
                
                {{-- Yazılar ve Buton --}}
                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-10">
                    <p class="text-[11px] font-bold tracking-[0.15em] uppercase text-white/70 mb-2">Kategori</p>
                    <h2 class="font-display text-white text-4xl md:text-5xl font-bold leading-tight mb-5">{{ $ilkKategori->ad }}</h2>
                    <span class="inline-flex items-center gap-2 text-[12px] font-bold tracking-wider uppercase px-6 py-3 rounded-full transition-colors bg-[#D2A077] hover:bg-[#b88963] text-white">
                        Keşfet <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

            {{-- SAĞ 4 KÜÇÜK KART --}}
            @foreach($digerKategoriler as $kat)
                <a href="#" class="group relative rounded-3xl overflow-hidden h-[200px] md:h-auto md:aspect-[4/3] block shadow-sm">
                    <img src="{{ $kat->gorsel ? asset('storage/' . $kat->gorsel) : 'https://images.unsplash.com/photo-1512413914856-12151121d120?q=80&w=600' }}"
                         alt="{{ $kat->ad }}"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    
                    {{-- Alttan Hafif Gölge --}}
                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 50%);"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <h3 class="text-white text-[15px] font-bold tracking-wide">{{ $kat->ad }}</h3>
                    </div>
                </a>
            @endforeach

        </div>
    @else
        <div class="flex flex-col items-center justify-center py-24 rounded-[2rem] border border-dashed border-gray-300 bg-gray-50/50 text-gray-400">
            <i class="fa-solid fa-image text-4xl mb-4 opacity-40"></i>
            <p class="text-sm font-medium">Anasayfa vitrini için henüz resimli kategori eklenmemiş.</p>
        </div>
    @endif
</section>


{{-- ══════════════════════════════════════════════════
     2. DİNAMİK CMS BLOKLARI (Admin Panelinden Gelenler)
══════════════════════════════════════════════════ --}}
@if(isset($dinamikBloklar))
    @foreach($dinamikBloklar as $blok)

        {{-- A) FULL BANNER BLOĞU (Örn: Kendi Kutunu Yap) --}}
        @if($blok->tip == 'full_banner')
            <section class="mx-6 lg:mx-10 my-10 rounded-3xl overflow-hidden relative fade-up" style="min-height:280px;background:var(--ink)">
                
                {{-- Admin panelinden yüklenen resim --}}
                @if(isset($blok->icerik_verisi['arka_plan']))
                    <img src="{{ asset('storage/' . $blok->icerik_verisi['arka_plan']) }}" alt="{{ $blok->baslik }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
                @else
                    <img src="https://images.unsplash.com/photo-1607344645866-009c320b63e0?q=80&w=1600&auto=format&fit=crop" alt="Banner" class="absolute inset-0 w-full h-full object-cover opacity-30">
                @endif
                
                <div class="absolute inset-0" style="background:radial-gradient(ellipse at 70% 50%, rgba(201,149,106,.25) 0%, transparent 65%)"></div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 px-10 py-14 max-w-[1440px] mx-auto">
                    <div>
                        @if($blok->alt_baslik)
                            <p class="text-[11px] tracking-[.15em] uppercase font-semibold mb-3" style="color:var(--accent)">{{ $blok->alt_baslik }}</p>
                        @endif
                        
                        <h2 class="font-display text-white text-4xl md:text-5xl font-semibold leading-tight max-w-lg">
                            {{ $blok->baslik }}
                        </h2>
                        
                        @if(isset($blok->icerik_verisi['aciklama']))
                            <p class="text-sm mt-4 max-w-sm leading-relaxed" style="color:rgba(255,255,255,.55)">
                                {{ $blok->icerik_verisi['aciklama'] }}
                            </p>
                        @endif
                    </div>
                    
                    @if($blok->buton_metni)
                        <div class="flex-shrink-0">
                            <a href="{{ $blok->buton_linki ?? '#' }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-full font-semibold text-sm transition hover:gap-5" style="background:var(--accent);color:#fff">
                                {{ $blok->buton_metni }}
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </section>

        {{-- B) AVANTAJLAR BLOĞU (İkonlu 4'lü Kutu) --}}
        @elseif($blok->tip == 'avantajlar')
            <section class="border-t border-b py-14 my-10 fade-up" style="border-color:var(--border);background:var(--warm-white)">
                <div class="max-w-[1440px] mx-auto px-6 lg:px-10">

                    <div class="text-center mb-12">
                        <p class="text-[11px] tracking-[.12em] uppercase font-semibold mb-2" style="color:var(--accent)">{{ $blok->alt_baslik }}</p>
                        <h2 class="font-display text-4xl" style="color:var(--ink)">{{ $blok->baslik }}</h2>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @if(isset($blok->icerik_verisi['avantajlar']))
                            @foreach($blok->icerik_verisi['avantajlar'] as $avantaj)
                                @if(!empty($avantaj['baslik']))
                                <div class="flex flex-col items-center text-center gap-4">
                                    <div class="w-14 h-14 flex items-center justify-center rounded-2xl transition-transform hover:scale-110 duration-300" style="background:var(--cream)">
                                        <i class="fa-solid {{ $avantaj['ikon'] ?? 'fa-star' }} text-xl" style="color:var(--accent)"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold mb-1" style="color:var(--ink)">{{ $avantaj['baslik'] }}</p>
                                        <p class="text-xs leading-relaxed" style="color:var(--muted)">{{ $avantaj['aciklama'] ?? '' }}</p>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                </div>
            </section>
            
        {{-- C) ÖZEL KOLEKSİYONLAR BLOĞU (Grid) --}}
        @elseif($blok->tip == 'koleksiyon_grid')
            <section class="max-w-[1440px] mx-auto px-6 lg:px-10 py-14 fade-up">
                <div class="mb-8">
                    <p class="text-[11px] tracking-[.12em] uppercase font-semibold mb-1" style="color:var(--accent)">{{ $blok->alt_baslik }}</p>
                    <h2 class="font-display text-3xl" style="color:var(--ink)">{{ $blok->baslik }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @if(isset($blok->icerik_verisi['koleksiyonlar']))
                        @foreach($blok->icerik_verisi['koleksiyonlar'] as $kol)
                            <a href="{{ $kol['link'] ?? '#' }}" class="card-lift group block rounded-3xl overflow-hidden relative" style="min-height:340px;background:{{ $kol['renk'] ?? '#DED6CC' }}">
                                @if(isset($kol['resim']))
                                    <img src="{{ asset('storage/' . $kol['resim']) }}" class="absolute inset-0 w-full h-full object-cover opacity-75 transition-opacity duration-500 group-hover:opacity-90">
                                @endif
                                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(26,22,18,.65) 0%, transparent 50%)"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-7">
                                    <h3 class="font-display text-white text-2xl font-semibold mb-1">{{ $kol['baslik'] ?? '' }}</h3>
                                    <p class="text-sm mb-4" style="color:rgba(255,255,255,.65)">{{ $kol['aciklama'] ?? '' }}</p>
                                    <span class="inline-flex items-center gap-2 text-xs font-medium" style="color:rgba(255,255,255,.8)">
                                        Keşfet <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </section>
            
        {{-- D) İLHAM GALERİSİ (6'lı Instagram Grid) --}}
        @elseif($blok->tip == 'galeri')
            <section class="max-w-[1440px] mx-auto px-6 lg:px-10 py-14 fade-up">
                <div class="flex items-end justify-between mb-8 border-b border-gray-100 pb-4">
                    <div>
                        @if($blok->alt_baslik)
                            <p class="text-[11px] tracking-[.12em] uppercase font-semibold mb-1" style="color:var(--accent)">{{ $blok->alt_baslik }}</p>
                        @endif
                        <h2 class="font-display text-3xl" style="color:var(--ink)">{{ $blok->baslik }}</h2>
                    </div>
                    @if($blok->buton_metni)
                        <a href="{{ $blok->buton_linki ?? '#' }}" target="_blank" class="hidden md:flex items-center gap-2 text-xs font-bold transition hover:text-[#326765] px-4 py-2 bg-gray-50 rounded-full" style="color:var(--muted)">
                            <i class="fa-brands fa-instagram text-sm text-[#326765]"></i> {{ $blok->buton_metni }}
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-3 md:grid-cols-6 gap-2 md:gap-3">
                    @if(isset($blok->icerik_verisi['galeri']))
                        @foreach($blok->icerik_verisi['galeri'] as $gItem)
                            @if(isset($gItem['resim']))
                                <a href="{{ $gItem['link'] ?? '#' }}" target="_blank" class="group relative rounded-xl md:rounded-2xl overflow-hidden aspect-square shadow-sm">
                                    <img src="{{ asset('storage/' . $gItem['resim']) }}" alt="Instagram" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    
                                    {{-- Koyu Hover Katmanı ve İkon --}}
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300" style="background:rgba(50,103,101,0.7); backdrop-filter:blur(2px);">
                                        <i class="fa-brands fa-instagram text-white text-3xl transform scale-50 group-hover:scale-100 transition-transform duration-300 delay-100"></i>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </section>
            
        @endif

    @endforeach
@endif

@endsection