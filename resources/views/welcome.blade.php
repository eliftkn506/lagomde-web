@extends('layouts.app')

@section('title', 'Lagomde — Anlamlı Hediyeler')

@section('content')

{{-- ══════ 1. KATEGORİ VİTRİNİ ══════ --}}
<section class="max-w-[1440px] mx-auto px-5 lg:px-10 pt-10 pb-8 fade-up">

    @if(isset($vitrinKategorileri) && $vitrinKategorileri->count() > 0)
        @php
            $ilkKategori      = $vitrinKategorileri->first();
            $digerKategoriler = $vitrinKategorileri->slice(1, 4);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-4" style="min-height: 520px;">

            <a href="{{ route('kategori.goster', $ilkKategori->slug) }}" class="group relative rounded-[28px] overflow-hidden md:col-span-2 md:row-span-2 block" style="min-height: 420px;">
                <img src="{{ $ilkKategori->gorsel ? asset('storage/' . $ilkKategori->gorsel) : 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=900' }}"
                     alt="{{ $ilkKategori->ad }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2s] ease-out group-hover:scale-105">
                <div class="absolute inset-0" style="background: linear-gradient(160deg, rgba(22,18,14,0) 30%, rgba(22,18,14,0.75) 100%);"></div>
                <div class="absolute top-6 left-6">
                    <span class="inline-flex items-center gap-2 text-[10px] font-bold tracking-[0.14em] uppercase px-4 py-2 rounded-full text-white"
                          style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.2);">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                        Öne Çıkan
                    </span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-10">
                    <p class="text-[10px] font-bold tracking-[0.18em] uppercase mb-2" style="color: rgba(255,255,255,0.6);">Koleksiyon</p>
                    <h2 class="font-display text-white text-4xl md:text-5xl font-bold leading-tight mb-6">{{ $ilkKategori->ad }}</h2>
                    <span class="inline-flex items-center gap-3 text-[12px] font-bold tracking-wide uppercase px-7 py-3.5 rounded-2xl transition-all duration-300 group-hover:gap-5"
                          style="background: var(--teal); color: #fff;">
                        Keşfet <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

            @foreach($digerKategoriler as $kat)
                <a href="{{ route('kategori.goster', $kat->slug) }}" class="group relative rounded-[22px] overflow-hidden block" style="min-height: 190px;">
                    <img src="{{ $kat->gorsel ? asset('storage/' . $kat->gorsel) : 'https://images.unsplash.com/photo-1512413914856-12151121d120?q=80&w=600' }}"
                         alt="{{ $kat->ad }}"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-110">
                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(22,18,14,0.72) 0%, rgba(22,18,14,0.05) 55%);"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 flex items-end justify-between">
                        <h3 class="text-white text-[15px] font-semibold">{{ $kat->ad }}</h3>
                        <span class="w-8 h-8 rounded-xl flex items-center justify-center text-white opacity-0 translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"
                              style="background: rgba(255,255,255,0.15); backdrop-filter:blur(8px);">
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-28 rounded-[28px] border-2 border-dashed" style="border-color:var(--border);">
            <i class="fa-solid fa-images text-4xl mb-4" style="color:var(--border)"></i>
            <p class="text-sm font-medium" style="color:var(--ink-soft)">Vitrin için henüz kategori eklenmemiş.</p>
        </div>
    @endif
</section>


{{-- ══════ 2. DİNAMİK CMS BLOKLARI ══════ --}}
@if(isset($dinamikBloklar))
    @foreach($dinamikBloklar as $blok)

        @if($blok->tip == 'full_banner')
        <section class="mx-5 lg:mx-10 my-10 rounded-[28px] overflow-hidden relative fade-up" style="min-height: 300px;">
            @if(isset($blok->icerik_verisi['arka_plan']))
                <img src="{{ asset('storage/' . $blok->icerik_verisi['arka_plan']) }}" alt="{{ $blok->baslik }}" class="absolute inset-0 w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1607344645866-009c320b63e0?q=80&w=1600" alt="Banner" class="absolute inset-0 w-full h-full object-cover">
            @endif
            <div class="absolute inset-0" style="background: linear-gradient(100deg, rgba(22,18,14,0.88) 0%, rgba(22,18,14,0.50) 55%, rgba(22,18,14,0.15) 100%);"></div>
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 80% 50%, rgba(46,112,109,0.2) 0%, transparent 60%);"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10 px-10 md:px-16 py-16 max-w-[1440px] mx-auto">
                <div class="text-center md:text-left max-w-lg">
                    @if($blok->alt_baslik)
                        <p class="text-[11px] font-bold tracking-[0.2em] uppercase mb-4" style="color: var(--copper);">{{ $blok->alt_baslik }}</p>
                    @endif
                    <h2 class="font-display text-white text-4xl md:text-5xl font-bold leading-tight mb-4">{{ $blok->baslik }}</h2>
                    @if(isset($blok->icerik_verisi['aciklama']))
                        <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.55);">{{ $blok->icerik_verisi['aciklama'] }}</p>
                    @endif
                </div>
                @if($blok->buton_metni)
                    <div class="flex-shrink-0">
                        <a href="{{ $blok->buton_linki ?? '#' }}" class="inline-flex items-center gap-3 px-9 py-5 rounded-2xl font-bold text-sm tracking-wide uppercase transition-all duration-300 hover:scale-105" style="background: var(--teal); color: #fff; box-shadow: 0 8px 32px rgba(46,112,109,0.4);">
                            {{ $blok->buton_metni }} <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </section>

        @elseif($blok->tip == 'avantajlar')
        <section class="my-10 py-16 fade-up" style="background: var(--surface); border-top: 1px solid var(--border-soft); border-bottom: 1px solid var(--border-soft);">
            <div class="max-w-[1440px] mx-auto px-5 lg:px-10">
                <div class="text-center mb-14">
                    @if($blok->alt_baslik)
                        <p class="text-[11px] font-bold tracking-[0.2em] uppercase mb-3" style="color: var(--copper);">{{ $blok->alt_baslik }}</p>
                    @endif
                    <h2 class="font-display text-4xl font-bold" style="color: var(--ink);">{{ $blok->baslik }}</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    @if(isset($blok->icerik_verisi['avantajlar']))
                        @foreach($blok->icerik_verisi['avantajlar'] as $avantaj)
                            @if(!empty($avantaj['baslik']))
                                <div class="group flex flex-col items-center text-center p-8 rounded-[22px] transition-all duration-300 hover:-translate-y-2"
                                     style="background: var(--bg); border: 1px solid var(--border-soft);">
                                    <div class="w-16 h-16 flex items-center justify-center rounded-2xl mb-5 transition-all duration-300 group-hover:scale-110"
                                         style="background: var(--teal-pale); color: var(--teal);">
                                        <i class="fa-solid {{ $avantaj['ikon'] ?? 'fa-star' }} text-2xl"></i>
                                    </div>
                                    <p class="text-sm font-bold mb-2" style="color: var(--ink);">{{ $avantaj['baslik'] }}</p>
                                    <p class="text-xs leading-relaxed" style="color: var(--ink-soft);">{{ $avantaj['aciklama'] ?? '' }}</p>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        @elseif($blok->tip == 'koleksiyon_grid')
        <section class="max-w-[1440px] mx-auto px-5 lg:px-10 py-14 fade-up">
            <div class="flex items-end justify-between mb-10">
                <div>
                    @if($blok->alt_baslik)
                        <p class="text-[11px] font-bold tracking-[0.2em] uppercase mb-2" style="color: var(--copper);">{{ $blok->alt_baslik }}</p>
                    @endif
                    <h2 class="font-display text-4xl font-bold" style="color: var(--ink);">{{ $blok->baslik }}</h2>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @if(isset($blok->icerik_verisi['koleksiyonlar']))
                    @foreach($blok->icerik_verisi['koleksiyonlar'] as $kol)
                        <a href="{{ $kol['link'] ?? '#' }}" class="card-lift group block rounded-[24px] overflow-hidden relative" style="min-height: 360px; background: {{ $kol['renk'] ?? '#E8E0D8' }};">
                            @if(isset($kol['resim']))
                                <img src="{{ asset('storage/' . $kol['resim']) }}" class="absolute inset-0 w-full h-full object-cover opacity-70 transition-opacity duration-500 group-hover:opacity-90">
                            @endif
                            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(22,18,14,0.75) 0%, transparent 55%);"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-8">
                                <h3 class="font-display text-white text-2xl font-bold mb-2">{{ $kol['baslik'] ?? '' }}</h3>
                                <p class="text-sm mb-5 leading-relaxed" style="color: rgba(255,255,255,0.65);">{{ $kol['aciklama'] ?? '' }}</p>
                                <span class="inline-flex items-center gap-2 text-[11px] font-bold tracking-wide uppercase" style="color: rgba(255,255,255,0.75);">
                                    Keşfet <i class="fa-solid fa-arrow-right text-[9px] transition-transform duration-300 group-hover:translate-x-2"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </section>

        @elseif($blok->tip == 'galeri')
        <section class="max-w-[1440px] mx-auto px-5 lg:px-10 py-14 fade-up">
            <div class="flex items-end justify-between mb-10 pb-6" style="border-bottom: 1px solid var(--border-soft);">
                <div>
                    @if($blok->alt_baslik)
                        <p class="text-[11px] font-bold tracking-[0.2em] uppercase mb-2" style="color: var(--copper);">{{ $blok->alt_baslik }}</p>
                    @endif
                    <h2 class="font-display text-4xl font-bold" style="color: var(--ink);">{{ $blok->baslik }}</h2>
                </div>
                @if($blok->buton_metni)
                    <a href="{{ $blok->buton_linki ?? '#' }}" target="_blank"
                       class="hidden md:inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl transition-all duration-200"
                       style="color: var(--teal); background: var(--teal-pale); border: 1px solid rgba(46,112,109,0.15);">
                        <i class="fa-brands fa-instagram"></i> {{ $blok->buton_metni }}
                    </a>
                @endif
            </div>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
                @if(isset($blok->icerik_verisi['galeri']))
                    @foreach($blok->icerik_verisi['galeri'] as $gItem)
                        @if(isset($gItem['resim']))
                            <a href="{{ $gItem['link'] ?? '#' }}" target="_blank" class="group relative rounded-[18px] overflow-hidden aspect-square">
                                <img src="{{ asset('storage/' . $gItem['resim']) }}" alt="Instagram" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300"
                                     style="background: rgba(46,112,109,0.82); backdrop-filter: blur(4px);">
                                    <i class="fa-brands fa-instagram text-white text-2xl transform scale-50 group-hover:scale-100 transition-transform duration-300"></i>
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