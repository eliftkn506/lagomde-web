@extends('admin.layout')

@section('page_title', 'Anasayfa Bloğu Düzenle')

@section('admin_content')

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bloğu Düzenle</h1>
        <p class="text-sm text-gray-400 mt-0.5">Mevcut anasayfa bloğunun içeriklerini güncelliyorsunuz.</p>
    </div>
    <a href="{{ route('admin.anasayfa-bloklari.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
        <i class="fa-solid fa-arrow-left text-xs"></i> Vazgeç ve Geri Dön
    </a>
</div>

{{-- x-data içine veritabanındaki mevcut 'tip' bilgisini gönderiyoruz --}}
<form action="{{ route('admin.anasayfa-bloklari.update', $blok->id) }}" method="POST" enctype="multipart/form-data" x-data="{ tip: '{{ $blok->tip }}' }">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            {{-- 1. GENEL BİLGİLER --}}
            <div class="card p-6 md:p-8 border-t-4 border-t-[#326765]" x-show="tip !== ''" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Genel Blok Başlıkları</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase mb-2">Alt Başlık</label>
                        <input type="text" name="alt_baslik" value="{{ $blok->alt_baslik }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#326765] outline-none text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase mb-2">Ana Başlık</label>
                        <input type="text" name="baslik" value="{{ $blok->baslik }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#326765] outline-none text-sm font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase mb-2">Buton Metni</label>
                        <input type="text" name="buton_metni" value="{{ $blok->buton_metni }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#326765] outline-none text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase mb-2">Buton Linki</label>
                        <input type="text" name="buton_linki" value="{{ $blok->buton_linki }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#326765] outline-none text-sm font-medium">
                    </div>
                </div>
            </div>

            {{-- 2. FULL BANNER --}}
            <div class="card p-6 md:p-8" x-show="tip === 'full_banner'" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Banner İçerikleri</h3>
                <div class="mb-5 flex items-center gap-4">
                    @if(isset($blok->icerik_verisi['arka_plan']))
                        <img src="{{ asset('storage/' . $blok->icerik_verisi['arka_plan']) }}" class="w-20 h-20 object-cover rounded-lg shadow-sm border border-gray-200">
                    @endif
                    <div class="flex-1">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase mb-2">Yeni Görsel Yükle (Eskisini Değiştirir)</label>
                        <input type="file" name="icerik_verisi[arka_plan]" accept="image/*" class="w-full text-xs file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#EAF1F1] file:text-[#326765] cursor-pointer">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase mb-2">Açıklama Metni</label>
                    <textarea name="icerik_verisi[aciklama]" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm font-medium">{{ $blok->icerik_verisi['aciklama'] ?? '' }}</textarea>
                </div>
            </div>

            {{-- 3. AVANTAJLAR --}}
            <div class="card p-6 md:p-8" x-show="tip === 'avantajlar'" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Avantaj Kartları</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @for($i = 0; $i < 4; $i++)
                    @php $veri = $blok->icerik_verisi['avantajlar'][$i] ?? []; @endphp
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        <p class="text-xs font-bold text-[#326765] mb-3">{{ $i + 1 }}. Avantaj</p>
                        <input type="text" name="icerik_verisi[avantajlar][{{ $i }}][ikon]" value="{{ $veri['ikon'] ?? '' }}" placeholder="İkon (örn: fa-star)" class="w-full mb-3 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                        <input type="text" name="icerik_verisi[avantajlar][{{ $i }}][baslik]" value="{{ $veri['baslik'] ?? '' }}" placeholder="Başlık" class="w-full mb-3 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold outline-none">
                        <input type="text" name="icerik_verisi[avantajlar][{{ $i }}][aciklama]" value="{{ $veri['aciklama'] ?? '' }}" placeholder="Açıklama" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                    @endfor
                </div>
            </div>

            {{-- 4. KOLEKSİYON GRİD --}}
            <div class="card p-6 md:p-8" x-show="tip === 'koleksiyon_grid'" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Özel Koleksiyonlar</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @for($i = 0; $i < 3; $i++)
                    @php $veri = $blok->icerik_verisi['koleksiyonlar'][$i] ?? []; @endphp
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        <p class="text-xs font-bold text-[#326765] mb-3">{{ $i + 1 }}. Koleksiyon</p>
                        
                        @if(isset($veri['resim']))
                            <img src="{{ asset('storage/' . $veri['resim']) }}" class="w-full h-24 object-cover rounded-lg mb-2 shadow-sm">
                        @endif
                        <input type="file" name="icerik_verisi[koleksiyonlar][{{ $i }}][resim]" accept="image/*" class="w-full mb-3 text-[10px] file:py-1 file:px-2 file:rounded file:border-0 file:bg-[#EAF1F1] file:text-[#326765]">
                        
                        <input type="text" name="icerik_verisi[koleksiyonlar][{{ $i }}][baslik]" value="{{ $veri['baslik'] ?? '' }}" placeholder="Başlık" class="w-full mb-3 px-3 py-2 bg-white border rounded-lg text-xs font-bold">
                        <input type="text" name="icerik_verisi[koleksiyonlar][{{ $i }}][aciklama]" value="{{ $veri['aciklama'] ?? '' }}" placeholder="Açıklama" class="w-full mb-3 px-3 py-2 bg-white border rounded-lg text-xs">
                        <input type="text" name="icerik_verisi[koleksiyonlar][{{ $i }}][renk]" value="{{ $veri['renk'] ?? '' }}" placeholder="Renk (#HEX)" class="w-full mb-3 px-3 py-2 bg-white border rounded-lg text-xs">
                        <input type="text" name="icerik_verisi[koleksiyonlar][{{ $i }}][link]" value="{{ $veri['link'] ?? '' }}" placeholder="Link" class="w-full px-3 py-2 bg-white border rounded-lg text-xs">
                    </div>
                    @endfor
                </div>
            </div>

            {{-- 5. İLHAM GALERİSİ --}}
            <div class="card p-6 md:p-8" x-show="tip === 'galeri'" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">İlham Galerisi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @for($i = 0; $i < 6; $i++)
                    @php $veri = $blok->icerik_verisi['galeri'][$i] ?? []; @endphp
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl relative">
                        <span class="absolute -top-3 -left-3 w-6 h-6 rounded-full bg-[#326765] text-white flex items-center justify-center text-xs font-bold">{{ $i + 1 }}</span>
                        
                        @if(isset($veri['resim']))
                            <img src="{{ asset('storage/' . $veri['resim']) }}" class="w-full h-24 object-cover rounded-lg mb-2 shadow-sm">
                        @endif
                        <input type="file" name="icerik_verisi[galeri][{{ $i }}][resim]" accept="image/*" class="w-full mb-3 text-[10px] file:py-1 file:px-2 file:rounded file:border-0 file:bg-[#EAF1F1] file:text-[#326765]">
                        <input type="text" name="icerik_verisi[galeri][{{ $i }}][link]" value="{{ $veri['link'] ?? '' }}" placeholder="Link (Opsiyonel)" class="w-full px-3 py-2 bg-white border rounded-lg text-xs">
                    </div>
                    @endfor
                </div>
            </div>

        </div>

        {{-- SAĞ PANEL: AYARLAR --}}
        <div class="space-y-6">
            <div class="card p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Blok Ayarları</h3>

                <div class="mb-6 opacity-70 pointer-events-none">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase mb-2">Blok Tipi (Değiştirilemez)</label>
                    <input type="text" value="{{ $blok->tip }}" readonly class="w-full px-4 py-3.5 bg-slate-100 border border-slate-200 rounded-xl text-sm font-bold text-gray-600">
                    <input type="hidden" name="tip" value="{{ $blok->tip }}">
                </div>

                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase mb-2">Anasayfa Sırası</label>
                    <input type="number" name="sira" value="{{ $blok->sira }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#326765] outline-none text-sm font-bold">
                </div>

                <div class="flex items-center justify-between py-2 border-t border-gray-100 pt-5">
                    <div>
                        <p class="text-sm font-bold text-gray-800">Yayın Durumu</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="aktif_mi" value="1" {{ $blok->aktif_mi ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#326765]"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full py-4.5 bg-[#326765] hover:bg-[#26504e] text-white rounded-xl text-sm font-bold tracking-[0.1em] uppercase transition-all shadow-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-check text-xs"></i> DEĞİŞİKLİKLERİ KAYDET
            </button>
        </div>
    </div>
</form>

@endsection