@extends('admin.layout')

@section('page_title', 'Ürün Düzenle — ' . $urun->ad)

@section('admin_content')

@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold flex flex-col gap-1 shadow-sm">
    @foreach($errors->all() as $error)
        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</span>
    @endforeach
</div>
@endif

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-600 text-sm font-semibold flex items-center gap-2 shadow-sm">
    <i class="fa-solid fa-check-circle text-lg"></i> {{ session('success') }}
</div>
@endif

{{-- BAŞLIK --}}
<div class="flex items-center justify-between mb-7">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.urunler.index') }}"
           class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Ürün Düzenle</h1>
            <p class="text-sm text-gray-400 mt-0.5">
                <span class="font-semibold text-gray-600">{{ $urun->ad }}</span>
                &nbsp;·&nbsp; ID: #{{ $urun->id }}
            </p>
        </div>
    </div>

    {{-- Hızlı aksiyonlar --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.urunler.varyasyonlar', $urun->id) }}"
           class="text-xs font-semibold px-4 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition flex items-center gap-2 text-gray-700">
            <i class="fa-solid fa-sliders"></i> Varyasyonlar
        </a>
        {{-- Silme butonu - onay modalı tetikler --}}
        <button type="button" onclick="silOnayAc()"
                class="text-xs font-semibold px-4 py-2 rounded-xl border border-red-200 bg-red-50 hover:bg-red-100 transition flex items-center gap-2 text-red-600">
            <i class="fa-solid fa-trash"></i> Ürünü Sil
        </button>
    </div>
</div>

{{-- GÜNCELLEME FORMU --}}
<form action="{{ route('admin.urunler.update', $urun->id) }}" method="POST" enctype="multipart/form-data" id="updateForm">
    @csrf
    @method('PUT')

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
                        <input type="text" name="ad" required
                               value="{{ old('ad', $urun->ad) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kısa Açıklama</label>
                        <input type="text" name="kisa_aciklama"
                               value="{{ old('kisa_aciklama', $urun->kisa_aciklama) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Detaylı Açıklama</label>
                        <textarea name="detayli_aciklama" rows="5"
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800 leading-relaxed">{{ old('detayli_aciklama', $urun->detayli_aciklama) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- FİYAT VE STOK --}}
            <div class="card p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-800">
                        <i class="fa-solid fa-tag mr-2 text-gray-400"></i>Fiyat ve Stok
                    </h2>
                    <span class="text-[10px] font-semibold bg-blue-50 text-blue-500 px-2 py-1 rounded">Standart Varyasyon</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Normal Fiyat (₺) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="normal_fiyat" required
                               value="{{ old('normal_fiyat', $standartVaryasyon->normal_fiyat ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">İndirimli Fiyat (₺)</label>
                        <input type="number" step="0.01" name="indirimli_fiyat"
                               value="{{ old('indirimli_fiyat', $standartVaryasyon->indirimli_fiyat ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-red-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Stok Adedi <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="anlik_stok" required
                               value="{{ old('anlik_stok', $standartVaryasyon->anlik_stok ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm font-bold text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">SKU</label>
                        <input type="text" name="sku"
                               value="{{ old('sku', $standartVaryasyon->sku ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm uppercase text-gray-800">
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════
                 GÖRSEL YÖNETİMİ
                 Mevcut görseller listelenir, silinebilir.
                 Yeni ana görsel veya ek görseller eklenebilir.
            ════════════════════════════════════════════ --}}
            <div class="card p-6 shadow-sm">
                <h2 class="text-sm font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-images text-gray-400"></i> Görsel Yönetimi
                </h2>
                <p class="text-[11px] text-gray-400 mb-6">Mevcut görselleri silebilir, yeni görsel ekleyebilirsiniz. İlk sıradaki görsel ana görsel olarak kullanılır.</p>

                {{-- MEVCUT GÖRSELLER --}}
                @if($urun->gorseller->count() > 0)
                <div class="mb-6">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-3">Mevcut Görseller</p>
                    <div class="grid grid-cols-3 md:grid-cols-5 gap-3" id="mevcutGorselGrid">
                        @foreach($urun->gorseller as $gorsel)
                        <div class="relative group rounded-xl overflow-hidden border-2 aspect-square
                                    {{ $gorsel->sira == 1 ? 'border-amber-400' : 'border-gray-200' }}"
                             id="gorsel-{{ $gorsel->id }}">

                            <img src="{{ asset($gorsel->gorsel_url) }}"
                                 alt=""
                                 class="w-full h-full object-cover">

                            {{-- Ana görsel rozeti --}}
                            @if($gorsel->sira == 1)
                                <span class="absolute top-1.5 left-1.5 bg-amber-400 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">
                                    Ana
                                </span>
                            @endif

                            {{-- Sil butonu --}}
                            <button type="button"
                                    onclick="gorselSil({{ $gorsel->id }}, this)"
                                    class="absolute top-1.5 right-1.5 w-6 h-6 bg-red-500 text-white rounded-full text-[11px]
                                           items-center justify-center hidden group-hover:flex shadow transition">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-amber-600 mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-star text-amber-400"></i>
                        Altın kenarlıklı görsel ana görseldir.
                    </p>
                </div>
                @else
                <div class="mb-6 p-4 rounded-xl bg-gray-50 border border-dashed border-gray-200 text-center text-[12px] text-gray-400">
                    <i class="fa-regular fa-image text-2xl mb-2 block opacity-40"></i>
                    Bu ürüne henüz görsel eklenmemiş.
                </div>
                @endif

                {{-- YENİ ANA GÖRSEL --}}
                <div class="mb-5">
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-3">
                        <i class="fa-solid fa-star text-amber-400 mr-1"></i>
                        {{ $urun->gorseller->count() > 0 ? 'Ana Görseli Değiştir' : 'Ana Görsel Ekle' }}
                        <span class="text-gray-400 font-normal normal-case ml-2">— Seçmezseniz mevcut görsel kalır</span>
                    </label>

                    <div id="yeniAnaGorselKutu"
                         class="relative border-2 border-dashed border-gray-200 rounded-2xl overflow-hidden flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                         style="min-height:160px"
                         onclick="document.getElementById('ana_gorsel_input').click()">

                        <img id="yeniAnaOnizleme" src="" alt=""
                             class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl">

                        <div id="yeniAnaPlaceholder" class="text-center p-6 pointer-events-none">
                            <i class="fa-regular fa-image text-3xl text-gray-300 mb-2 block"></i>
                            <p class="text-sm font-semibold text-gray-500">Tıklayın veya sürükleyin</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">PNG, JPG, WEBP — maks. 2 MB</p>
                        </div>

                        <button type="button" id="yeniAnaDegistir"
                                onclick="event.stopPropagation(); document.getElementById('ana_gorsel_input').click()"
                                class="hidden absolute bottom-2 right-2 bg-white/90 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-full border border-gray-200 shadow">
                            <i class="fa-solid fa-pen mr-1"></i> Değiştir
                        </button>
                    </div>
                    <input type="file" id="ana_gorsel_input" name="ana_gorsel"
                           accept="image/*" class="hidden"
                           onchange="yeniAnaOnizle(this)">
                </div>

                {{-- YENİ EK GÖRSELLER --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-3">
                        <i class="fa-solid fa-grip text-blue-400 mr-1"></i> Yeni Ek Görseller Ekle
                        <span class="text-gray-400 font-normal normal-case ml-2">— Mevcut galeriye eklenir</span>
                    </label>

                    <div id="yeniEkGrid" class="grid grid-cols-4 md:grid-cols-6 gap-3">
                        <label for="ek_gorsel_input"
                               class="aspect-square rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                               id="ekEkleBtn">
                            <i class="fa-solid fa-plus text-gray-400 text-lg mb-1"></i>
                            <span class="text-[10px] text-gray-400 font-medium">Ekle</span>
                        </label>
                    </div>
                    <input type="file" id="ek_gorsel_input" name="ek_gorseller[]"
                           accept="image/*" multiple class="hidden"
                           onchange="yeniEklerEkle(this)">
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
                <p class="text-[11px] text-gray-400 mb-4">En az 1 kategori seçilmesi zorunludur.</p>

                <div class="max-h-80 overflow-y-auto space-y-3 pr-1 custom-scrollbar">
                    @forelse($kategoriler as $anaKat)
                        <div class="space-y-1">
                            <label class="flex items-center gap-2.5 font-bold text-gray-800 text-xs cursor-pointer select-none">
                                <input type="checkbox" name="kategoriler[]" value="{{ $anaKat->id }}"
                                       {{ in_array($anaKat->id, $seciliKategoriler) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded text-gray-900 border-gray-300">
                                {{ $anaKat->ad }}
                            </label>
                            @foreach($anaKat->altKategoriler as $altKat)
                                <div class="ml-5 space-y-1">
                                    <label class="flex items-center gap-2.5 font-semibold text-gray-600 text-xs cursor-pointer select-none mt-1">
                                        <input type="checkbox" name="kategoriler[]" value="{{ $altKat->id }}"
                                               {{ in_array($altKat->id, $seciliKategoriler) ? 'checked' : '' }}
                                               class="w-4 h-4 rounded text-gray-900 border-gray-300">
                                        {{ $altKat->ad }}
                                    </label>
                                    <div class="ml-5 space-y-1.5 mt-1">
                                        @foreach($altKat->altKategoriler as $altAltKat)
                                            <label class="flex items-center gap-2.5 text-gray-500 text-[11px] font-medium cursor-pointer select-none">
                                                <input type="checkbox" name="kategoriler[]" value="{{ $altAltKat->id }}"
                                                       {{ in_array($altAltKat->id, $seciliKategoriler) ? 'checked' : '' }}
                                                       class="w-3.5 h-3.5 rounded text-gray-900 border-gray-300">
                                                {{ $altAltKat->ad }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p class="text-[11px] text-red-500">Önce kategori ekleyin.</p>
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
                        <span class="text-xs font-bold text-gray-700">Sitede Yayınla</span>
                        <input type="checkbox" name="aktif_mi" value="1"
                               {{ $urun->aktif_mi ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-green-500 border-gray-300 cursor-pointer">
                    </label>
                    <label class="flex items-center justify-between cursor-pointer group pt-4 border-t border-gray-100">
                        <div>
                            <span class="text-xs font-bold text-gray-700 block">Varyasyonlu Ürün Mü?</span>
                            <span class="text-[9px] text-gray-400">Renk, beden gibi seçenekler içerir.</span>
                        </div>
                        <input type="checkbox" name="varyasyonlu_mu" value="1"
                               {{ $urun->varyasyonlu_mu ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-blue-500 border-gray-300 cursor-pointer">
                    </label>
                </div>
            </div>

            {{-- KAYDET BUTONU --}}
            <button type="submit"
                    class="w-full py-4 rounded-xl bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-gray-200">
                <i class="fa-solid fa-floppy-disk"></i> Değişiklikleri Kaydet
            </button>

            {{-- ÜRÜN BİLGİLERİ --}}
            <div class="card p-5 shadow-sm text-[11px] text-gray-400 space-y-2">
                <p><span class="font-semibold text-gray-600">Oluşturulma:</span> {{ $urun->created_at->format('d.m.Y H:i') }}</p>
                <p><span class="font-semibold text-gray-600">Son Güncelleme:</span> {{ $urun->updated_at->format('d.m.Y H:i') }}</p>
                <p><span class="font-semibold text-gray-600">Slug:</span> {{ $urun->slug }}</p>
            </div>

        </div>
    </div>
</form>

{{-- ════════════════════════════════════════════════════════
     SİLME ONAY MODALI
════════════════════════════════════════════════════════ --}}
<div id="silModal" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="silOnayKapat()"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md z-10 p-8 text-center">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Ürünü Sil</h3>
            <p class="text-sm text-gray-500 mb-2">
                <strong class="text-gray-800">{{ $urun->ad }}</strong> adlı ürünü silmek istediğinize emin misiniz?
            </p>
            <p class="text-xs text-red-500 font-medium mb-7">
                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                Bu işlem tüm görselleri ve varyasyonları da siler. Geri alınamaz.
            </p>
            <div class="flex gap-3">
                <button onclick="silOnayKapat()"
                        class="flex-1 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    İptal
                </button>
                <form action="{{ route('admin.urunler.destroy', $urun->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-bold transition">
                        <i class="fa-solid fa-trash mr-1"></i> Evet, Sil
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
</style>

<script>
/* ── Silme onay modalı ── */
function silOnayAc()   { document.getElementById('silModal').classList.remove('hidden'); document.body.style.overflow='hidden'; }
function silOnayKapat(){ document.getElementById('silModal').classList.add('hidden');    document.body.style.overflow=''; }
document.addEventListener('keydown', e => { if(e.key==='Escape') silOnayKapat(); });

/* ── Mevcut görsel AJAX silme ── */
function gorselSil(gorselId, btn) {
    if (!confirm('Bu görseli silmek istediğinize emin misiniz?')) return;

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

    fetch('{{ route("admin.urunler.gorselSil", ":id") }}'.replace(':id', gorselId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const el = document.getElementById('gorsel-' + gorselId);
            el.style.transition = 'opacity .3s, transform .3s';
            el.style.opacity = '0';
            el.style.transform = 'scale(0.85)';
            setTimeout(() => el.remove(), 300);
        } else {
            alert('Silme başarısız: ' + (data.message || 'Bilinmeyen hata'));
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        }
    })
    .catch(() => {
        alert('Bir hata oluştu.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
    });
}

/* ── Yeni ana görsel önizleme ── */
function yeniAnaOnizle(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('yeniAnaOnizleme');
        const ph  = document.getElementById('yeniAnaPlaceholder');
        const btn = document.getElementById('yeniAnaDegistir');
        img.src = e.target.result;
        img.classList.remove('hidden');
        ph.classList.add('hidden');
        btn.classList.remove('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}

/* ── Yeni ek görseller ── */
function yeniEklerEkle(input) {
    if (!input.files) return;
    const grid   = document.getElementById('yeniEkGrid');
    const ekleBtn = document.getElementById('ekEkleBtn');

    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const kart = document.createElement('div');
            kart.className = 'relative aspect-square rounded-xl overflow-hidden border border-gray-200 group';
            kart.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover">
                <button type="button" onclick="this.parentElement.remove()"
                        class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full text-[10px] items-center justify-center hidden group-hover:flex shadow">
                    <i class="fa-solid fa-xmark"></i>
                </button>`;
            grid.insertBefore(kart, ekleBtn);
        };
        reader.readAsDataURL(file);
    });
    input.value = '';
}
</script>

@endsection