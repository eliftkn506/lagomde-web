@extends('admin.layout')

@section('page_title', 'Yeni Ürün Ekle')

@section('admin_content')

{{-- HATA MESAJLARI --}}
@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold flex flex-col gap-1 shadow-sm">
    @foreach($errors->all() as $error)
        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</span>
    @endforeach
</div>
@endif

{{-- SAYFA BAŞLIĞI VE GERİ BUTONU --}}
<div class="flex items-center justify-between mb-7">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.urunler.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Yeni Ürün Ekle</h1>
            <p class="text-sm text-gray-400 mt-0.5">Sisteme yeni bir ürün ve varyasyonlarını tanımlayın.</p>
        </div>
    </div>
</div>

{{-- ÜRÜN EKLEME FORMU --}}
<form action="{{ route('admin.urunler.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- SOL SÜTUN (Ana Bilgiler, Fiyat, Görseller) --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- 1. TEMEL BİLGİLER --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-5 pb-3 border-b border-gray-100"><i class="fa-solid fa-circle-info mr-2 text-gray-400"></i>Temel Bilgiler</h2>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Ürün Adı <span class="text-red-500">*</span></label>
                        <input type="text" name="ad" required placeholder="Örn: İsme Özel French Pressli Çelik Termos" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800 font-medium">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kısa Açıklama (Vitrin İçin)</label>
                        <input type="text" name="kisa_aciklama" placeholder="Örn: 500ml kapasiteli, paslanmaz çelik..." 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Detaylı Açıklama</label>
                        <textarea name="detayli_aciklama" rows="5" placeholder="Ürünün tüm özellikleri, kutu içeriği vb..." 
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800 leading-relaxed"></textarea>
                    </div>
                </div>
            </div>

            {{-- 2. STANDART FİYAT VE STOK (Varyasyonsuz ürünler için) --}}
            <div class="card p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-800"><i class="fa-solid fa-tag mr-2 text-gray-400"></i>Fiyat ve Stok</h2>
                    <span class="text-[10px] font-semibold bg-blue-50 text-blue-500 px-2 py-1 rounded">Standart Ürün</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Normal Fiyat (₺) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="normal_fiyat" required placeholder="0.00" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">İndirimli Fiyat (₺) <span class="text-gray-400 font-normal text-[9px]">(Opsiyonel)</span></label>
                        <input type="number" step="0.01" name="indirimli_fiyat" placeholder="0.00" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-red-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Stok Adedi <span class="text-red-500">*</span></label>
                        <input type="number" name="anlik_stok" required placeholder="100" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">SKU (Stok Kodu)</label>
                        <input type="text" name="sku" placeholder="Örn: LGM-TRMS-01" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm uppercase text-gray-800">
                    </div>
                </div>
            </div>

            {{-- 3. GÖRSELLER --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-5 pb-3 border-b border-gray-100"><i class="fa-solid fa-images mr-2 text-gray-400"></i>Ürün Görselleri</h2>
                
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:bg-gray-50 transition cursor-pointer relative">
                    <input type="file" name="gorseller[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 mb-3"></i>
                    <p class="text-sm font-bold text-gray-700">Görselleri seçmek için tıklayın veya sürükleyin</p>
                    <p class="text-[11px] text-gray-400 mt-1">PNG, JPG veya WEBP. (Birden fazla seçebilirsiniz)</p>
                </div>
            </div>

        </div>

        {{-- SAĞ SÜTUN (Kategoriler ve Yayın) --}}
        <div class="space-y-6">
            
            {{-- 4. KATEGORİ (FİLTRE) SEÇİMİ --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-5 pb-3 border-b border-gray-100"><i class="fa-solid fa-sitemap mr-2 text-gray-400"></i>Kategoriler & Filtreler</h2>
                <p class="text-[11px] text-gray-500 mb-4 leading-relaxed">Ürünün hangi sayfalarda ve "Kadına, Erkeğe, Yeni İş" gibi hangi sekmelerde görüneceğini seçin.</p>
                
                {{-- KAYDIRILABİLİR KATEGORİ AĞACI --}}
                <div class="max-h-80 overflow-y-auto space-y-3 pr-2 custom-scrollbar">
                    @forelse($kategoriler as $anaKat)
                        <div class="space-y-1">
                            <label class="flex items-center gap-2.5 font-bold text-gray-800 text-xs cursor-pointer">
                                <input type="checkbox" name="kategoriler[]" value="{{ $anaKat->id }}" class="w-4 h-4 rounded text-gray-900 focus:ring-gray-900 border-gray-300">
                                {{ $anaKat->ad }}
                            </label>
                            
                            {{-- 2. Seviye (Doğum Günü Hediyeleri) --}}
                            @foreach($anaKat->altKategoriler as $altKat)
                                <div class="ml-6 space-y-1">
                                    <label class="flex items-center gap-2.5 font-semibold text-gray-600 text-xs cursor-pointer mt-1.5">
                                        <input type="checkbox" name="kategoriler[]" value="{{ $altKat->id }}" class="w-4 h-4 rounded text-gray-900 focus:ring-gray-900 border-gray-300">
                                        {{ $altKat->ad }}
                                    </label>
                                    
                                    {{-- 3. Seviye (Sevgiliye Doğum Günü) --}}
                                    <div class="ml-6 space-y-1.5 mt-1.5">
                                        @foreach($altKat->altKategoriler as $altAltKat)
                                            <label class="flex items-center gap-2.5 text-gray-500 text-[11px] font-medium cursor-pointer">
                                                <input type="checkbox" name="kategoriler[]" value="{{ $altAltKat->id }}" class="w-3.5 h-3.5 rounded text-gray-900 focus:ring-gray-900 border-gray-300">
                                                {{ $altAltKat->ad }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="text-[11px] text-red-500 font-medium">Sistemde hiç kategori yok. Önce kategori ekleyin.</div>
                    @endforelse
                </div>
            </div>

            {{-- 5. YAYIN AYARLARI --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-5 pb-3 border-b border-gray-100"><i class="fa-solid fa-gear mr-2 text-gray-400"></i>Yayın Ayarları</h2>
                
                <div class="space-y-4">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-xs font-bold text-gray-700 group-hover:text-gray-900 transition">Sitede Yayınla (Aktif)</span>
                        <input type="checkbox" name="aktif_mi" value="1" checked class="w-4 h-4 rounded text-green-500 focus:ring-green-500 border-gray-300 cursor-pointer">
                    </label>

                    <label class="flex items-center justify-between cursor-pointer group pt-4 border-t border-gray-100">
                        <div>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-gray-900 transition block">Varyasyonlu Ürün Mü?</span>
                            <span class="text-[9px] text-gray-400">Renk, beden gibi seçenekler içerir.</span>
                        </div>
                        <input type="checkbox" name="varyasyonlu_mu" value="1" class="w-4 h-4 rounded text-blue-500 focus:ring-blue-500 border-gray-300 cursor-pointer">
                    </label>
                </div>
            </div>

            {{-- KAYDET BUTONU --}}
            <button type="submit" class="w-full py-4 rounded-xl bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold transition text-center shadow-lg shadow-gray-200 flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Ürünü Kaydet
            </button>

        </div>
    </div>
</form>

<style>
    /* Sağ paneldeki kategori kaydırma çubuğunu inceltme */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
</style>

@endsection