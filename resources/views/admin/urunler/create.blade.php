@extends('admin.layout')

@section('page_title', 'Yeni Ürün Ekle')

@section('admin_content')

@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold flex flex-col gap-1 shadow-sm">
    @foreach($errors->all() as $error)
        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</span>
    @endforeach
</div>
@endif

<div class="flex items-center justify-between mb-7">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.urunler.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Yeni Ürün Ekle</h1>
            <p class="text-sm text-gray-400 mt-0.5">Sisteme yeni bir ürün tanımlayın.</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.urunler.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ═══ SOL SÜTUN ═══ --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- TEMEL BİLGİLER --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-5 pb-3 border-b border-gray-100">
                    <i class="fa-solid fa-circle-info mr-2 text-gray-400"></i>Temel Bilgiler
                </h2>
                <div class="space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Ürün Adı <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ad" required value="{{ old('ad') }}"
                               placeholder="Örn: İsme Özel French Pressli Çelik Termos"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Kısa Açıklama <span class="text-gray-400 font-normal text-[9px]">(Vitrin için)</span>
                        </label>
                        <input type="text" name="kisa_aciklama" value="{{ old('kisa_aciklama') }}"
                               placeholder="Örn: 500ml kapasiteli, paslanmaz çelik..."
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Detaylı Açıklama</label>
                        <textarea name="detayli_aciklama" rows="5"
                                  placeholder="Ürünün tüm özellikleri, kutu içeriği vb..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800 leading-relaxed">{{ old('detayli_aciklama') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- FİYAT VE STOK --}}
            <div class="card p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-800">
                        <i class="fa-solid fa-tag mr-2 text-gray-400"></i>Fiyat ve Stok
                    </h2>
                    <span class="text-[10px] font-semibold bg-blue-50 text-blue-500 px-2 py-1 rounded">Standart Ürün</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Normal Fiyat (₺) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="normal_fiyat" required value="{{ old('normal_fiyat') }}"
                               placeholder="0.00"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                            İndirimli Fiyat (₺) <span class="text-gray-400 font-normal text-[9px]">(Opsiyonel)</span>
                        </label>
                        <input type="number" step="0.01" name="indirimli_fiyat" value="{{ old('indirimli_fiyat') }}"
                               placeholder="0.00"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-red-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Stok Adedi <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="anlik_stok" required value="{{ old('anlik_stok') }}"
                               placeholder="100"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">SKU (Stok Kodu)</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" placeholder="Örn: LGM-TRMS-01"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm uppercase text-gray-800">
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════
                 GÖRSEL YÖNETİMİ
                 Ana görsel (sira=1, ana_gorsel=1) + Ek görseller (galeri)
            ═══════════════════════════════════════════════════════ --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-images text-gray-400"></i> Ürün Görselleri
                </h2>
                <p class="text-[11px] text-gray-400 mb-6">Ana görsel, vitrin ve ürün detay sayfasında büyük olarak gösterilir. Ek görseller, galeride kaydırılarak görüntülenir.</p>

                {{-- ANA GÖRSEL --}}
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-3">
                        <i class="fa-solid fa-star text-amber-400 mr-1"></i> Ana Görsel
                        <span class="text-red-500">*</span>
                        <span class="text-gray-400 font-normal normal-case ml-2">— Ürünün öne çıkan fotoğrafı</span>
                    </label>

                    <div id="anaGorselKutu"
                         class="relative border-2 border-dashed border-gray-200 rounded-2xl overflow-hidden flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                         style="min-height:220px"
                         onclick="document.getElementById('ana_gorsel_input').click()">

                        {{-- Önizleme --}}
                        <img id="anaGorselOnizleme"
                             src=""
                             alt=""
                             class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl">

                        {{-- Placeholder metin --}}
                        <div id="anaGorselPlaceholder" class="text-center p-8 pointer-events-none">
                            <i class="fa-regular fa-image text-4xl text-gray-300 mb-3 block"></i>
                            <p class="text-sm font-semibold text-gray-500">Tıklayın veya sürükleyin</p>
                            <p class="text-[11px] text-gray-400 mt-1">PNG, JPG, WEBP — maks. 2 MB</p>
                        </div>

                        {{-- Değiştir butonu (görsel seçilince belirir) --}}
                        <button type="button"
                                id="anaGorselDegistir"
                                onclick="event.stopPropagation(); document.getElementById('ana_gorsel_input').click()"
                                class="hidden absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-full border border-gray-200 shadow hover:bg-white transition">
                            <i class="fa-solid fa-pen mr-1"></i> Değiştir
                        </button>
                    </div>

                    <input type="file"
                           id="ana_gorsel_input"
                           name="ana_gorsel"
                           accept="image/*"
                           class="hidden"
                           onchange="anaGorselOnizle(this)">
                </div>

                {{-- EK GÖRSELLER --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-3">
                        <i class="fa-solid fa-grip text-blue-400 mr-1"></i> Ek Görseller (Galeri)
                        <span class="text-gray-400 font-normal normal-case ml-2">— Ürün detayında kaydırılarak görüntülenir</span>
                    </label>

                    {{-- Mevcut önizlemeler + ekle butonu --}}
                    <div id="ekGorsellerGrid"
                         class="grid grid-cols-4 md:grid-cols-6 gap-3">

                        {{-- Ekle butonu (her zaman sonda kalır) --}}
                        <label for="ek_gorsel_input"
                               class="aspect-square rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                               id="ekGorselEkleBtn">
                            <i class="fa-solid fa-plus text-gray-400 text-lg mb-1"></i>
                            <span class="text-[10px] text-gray-400 font-medium">Ekle</span>
                        </label>
                    </div>

                    <input type="file"
                           id="ek_gorsel_input"
                           name="ek_gorseller[]"
                           accept="image/*"
                           multiple
                           class="hidden"
                           onchange="ekGorsellerEkle(this)">
                    <p class="text-[10px] text-gray-400 mt-2">Birden fazla seçebilirsiniz. Her biri maks. 2 MB.</p>
                </div>
            </div>

        </div>

        {{-- ═══ SAĞ SÜTUN ═══ --}}
        <div class="space-y-6">

            {{-- KATEGORİ SEÇİMİ --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-2 pb-3 border-b border-gray-100">
                    <i class="fa-solid fa-sitemap mr-2 text-gray-400"></i>Kategoriler
                </h2>
                <p class="text-[11px] text-gray-400 mb-4 leading-relaxed">En az 1 kategori seçilmesi zorunludur.</p>

                <div class="max-h-80 overflow-y-auto space-y-3 pr-1 custom-scrollbar">
                    @forelse($kategoriler as $anaKat)
                        <div class="space-y-1">
                            <label class="flex items-center gap-2.5 font-bold text-gray-800 text-xs cursor-pointer select-none">
                                <input type="checkbox" name="kategoriler[]" value="{{ $anaKat->id }}"
                                       {{ in_array($anaKat->id, old('kategoriler', [])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded text-gray-900 focus:ring-gray-900 border-gray-300">
                                {{ $anaKat->ad }}
                            </label>
                            @foreach($anaKat->altKategoriler as $altKat)
                                <div class="ml-5 space-y-1">
                                    <label class="flex items-center gap-2.5 font-semibold text-gray-600 text-xs cursor-pointer select-none mt-1">
                                        <input type="checkbox" name="kategoriler[]" value="{{ $altKat->id }}"
                                               {{ in_array($altKat->id, old('kategoriler', [])) ? 'checked' : '' }}
                                               class="w-4 h-4 rounded text-gray-900 focus:ring-gray-900 border-gray-300">
                                        {{ $altKat->ad }}
                                    </label>
                                    <div class="ml-5 space-y-1.5 mt-1">
                                        @foreach($altKat->altKategoriler as $altAltKat)
                                            <label class="flex items-center gap-2.5 text-gray-500 text-[11px] font-medium cursor-pointer select-none">
                                                <input type="checkbox" name="kategoriler[]" value="{{ $altAltKat->id }}"
                                                       {{ in_array($altAltKat->id, old('kategoriler', [])) ? 'checked' : '' }}
                                                       class="w-3.5 h-3.5 rounded text-gray-900 focus:ring-gray-900 border-gray-300">
                                                {{ $altAltKat->ad }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="text-[11px] text-red-500 font-medium">Önce kategori ekleyin.</div>
                    @endforelse
                </div>
            </div>

            {{-- YAYIN AYARLARI --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-5 pb-3 border-b border-gray-100">
                    <i class="fa-solid fa-gear mr-2 text-gray-400"></i>Yayın Ayarları
                </h2>
                <div class="space-y-4">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-xs font-bold text-gray-700 group-hover:text-gray-900 transition">Sitede Yayınla</span>
                        <input type="checkbox" name="aktif_mi" value="1" checked
                               class="w-4 h-4 rounded text-green-500 focus:ring-green-500 border-gray-300 cursor-pointer">
                    </label>
                    <label class="flex items-center justify-between cursor-pointer group pt-4 border-t border-gray-100">
                        <div>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-gray-900 transition block">Varyasyonlu Ürün Mü?</span>
                            <span class="text-[9px] text-gray-400">Renk, beden gibi seçenekler içerir.</span>
                        </div>
                        <input type="checkbox" name="varyasyonlu_mu" value="1"
                               class="w-4 h-4 rounded text-blue-500 focus:ring-blue-500 border-gray-300 cursor-pointer">
                    </label>
                </div>
            </div>

            <button type="submit"
                    class="w-full py-4 rounded-xl bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold transition text-center shadow-lg shadow-gray-200 flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Ürünü Kaydet
            </button>

        </div>
    </div>
</form>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
</style>

<script>
/* ─── ANA GÖRSEL ÖNİZLEME ─── */
function anaGorselOnizle(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img       = document.getElementById('anaGorselOnizleme');
        const ph        = document.getElementById('anaGorselPlaceholder');
        const degistir  = document.getElementById('anaGorselDegistir');
        img.src = e.target.result;
        img.classList.remove('hidden');
        ph.classList.add('hidden');
        degistir.classList.remove('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}

/* ─── EK GÖRSEL EKLEMELİ GRİD ─── */
function ekGorsellerEkle(input) {
    if (!input.files) return;

    const grid      = document.getElementById('ekGorsellerGrid');
    const ekleBtn   = document.getElementById('ekGorselEkleBtn');

    Array.from(input.files).forEach(function(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Kart oluştur
            const kart = document.createElement('div');
            kart.className = 'relative aspect-square rounded-xl overflow-hidden border border-gray-200 group';
            kart.innerHTML = `
                <img src="${e.target.result}" alt="" class="w-full h-full object-cover">
                <button type="button"
                        onclick="this.parentElement.remove()"
                        class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full text-[10px] items-center justify-center hidden group-hover:flex shadow">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            // "Ekle" butonunun ÖNÜNE ekle
            grid.insertBefore(kart, ekleBtn);
        };
        reader.readAsDataURL(file);
    });

    // Aynı dosyaları tekrar seçebilmek için inputu sıfırla
    input.value = '';
}
</script>

@endsection