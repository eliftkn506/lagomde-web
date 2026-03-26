@extends('admin.layout')

@section('page_title', 'Ürün Yönetimi')

@section('admin_content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-600 text-sm font-semibold flex items-center gap-2 shadow-sm">
    <i class="fa-solid fa-check-circle text-lg"></i> {{ session('success') }}
</div>
@endif

{{-- SAYFA BAŞLIĞI --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Ürün Yönetimi</h1>
        <p class="text-sm text-gray-400 mt-0.5">Sistemdeki tüm ürünleri görüntüleyin, düzenleyin veya yenisini ekleyin.</p>
    </div>
    <a href="{{ route('admin.urunler.create') }}"
       class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2.5 px-5 rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-gray-200">
        <i class="fa-solid fa-plus text-xs"></i> Yeni Ürün Ekle
    </a>
</div>

{{-- TABLO --}}
<div class="card overflow-hidden shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between px-6 py-4 border-b border-gray-100 bg-white gap-4">
        <h2 class="text-sm font-bold text-gray-800">
            Tüm Ürünler <span class="text-gray-400 font-normal">({{ $urunler->total() }})</span>
        </h2>
        <div class="relative">
            <input type="text" placeholder="Ürün adı veya SKU ara..."
                   class="pl-9 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-lg text-xs focus:outline-none focus:border-gray-300 focus:bg-white transition w-56 text-gray-700">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="clean w-full text-left">
            <thead>
                <tr>
                    <th class="w-16">Görsel</th>
                    <th>Ürün Adı & Kategori</th>
                    <th>Tip</th>
                    <th>Fiyat</th>
                    <th>Toplam Stok</th>
                    <th>Durum</th>
                    <th class="text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($urunler as $urun)
                <tr class="hover:bg-gray-50/50 transition border-b border-gray-50 last:border-0">

                    {{-- GÖRSEL --}}
                    <td>
                        <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center flex-shrink-0">
                            @if($urun->gorseller->count() > 0)
                                <img src="{{ asset($urun->gorseller->first()->gorsel_url) }}"
                                     alt="{{ $urun->ad }}"
                                     class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-gray-300 text-lg"></i>
                            @endif
                        </div>
                    </td>

                    {{-- AD & KATEGORİ --}}
                    <td>
                        <p class="font-bold text-gray-800 text-sm mb-1">{{ $urun->ad }}</p>
                        <div class="flex flex-wrap gap-1">
                            @forelse($urun->kategoriler as $kategori)
                                <span class="text-[10px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded font-medium">{{ $kategori->ad }}</span>
                            @empty
                                <span class="text-[10px] text-gray-400 italic">Kategori Yok</span>
                            @endforelse
                        </div>
                    </td>

                    {{-- TİP --}}
                    <td>
                        @if($urun->varyasyonlu_mu)
                            <span class="badge badge-amber"><i class="fa-solid fa-layer-group mr-1.5"></i> Varyasyonlu</span>
                        @else
                            <span class="badge badge-slate"><i class="fa-solid fa-cube mr-1.5"></i> Standart</span>
                        @endif
                    </td>

                    {{-- FİYAT --}}
                    <td>
                        @if($urun->varyasyonlar->count() > 0)
                            @php $ilkV = $urun->varyasyonlar->first(); @endphp
                            <p class="font-bold text-gray-800 text-sm">
                                ₺{{ number_format($ilkV->indirimli_fiyat ?? $ilkV->normal_fiyat, 2, ',', '.') }}
                            </p>
                            @if($ilkV->indirimli_fiyat)
                                <p class="text-[10px] text-gray-400 line-through">
                                    ₺{{ number_format($ilkV->normal_fiyat, 2, ',', '.') }}
                                </p>
                            @endif
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>

                    {{-- STOK --}}
                    <td>
                        @php $toplamStok = $urun->varyasyonlar->sum('anlik_stok'); @endphp
                        @if($toplamStok > 10)
                            <span class="text-green-600 font-bold text-sm">{{ $toplamStok }}</span>
                        @elseif($toplamStok > 0)
                            <span class="text-amber-500 font-bold text-sm">{{ $toplamStok }}</span>
                        @else
                            <span class="badge badge-red text-[10px]">Tükendi</span>
                        @endif
                    </td>

                    {{-- DURUM --}}
                    <td>
                        @if($urun->aktif_mi)
                            <span class="badge badge-green">Aktif</span>
                        @else
                            <span class="badge badge-slate">Pasif</span>
                        @endif
                    </td>

                    {{-- İŞLEMLER --}}
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($urun->varyasyonlu_mu)
                                <button type="button"
                                        onclick="varyasyonModalAc({{ $urun->id }})"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center"
                                        title="Seçenekleri Gör">
                                    <i class="fa-solid fa-layer-group text-xs"></i>
                                </button>
                            @endif
                            <a href="{{ route('admin.urunler.varyasyonlar', $urun->id) }}"
                               class="w-8 h-8 rounded-lg bg-purple-50 text-purple-500 hover:bg-purple-100 transition flex items-center justify-center"
                               title="Varyasyon Yönet">
                                <i class="fa-solid fa-sliders text-xs"></i>
                            </a>
                            <a href="{{ route('admin.urunler.edit', $urun->id) }}"
                               class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 transition flex items-center justify-center"
                               title="Düzenle">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <button type="button"
                                    onclick="silModalAc({{ $urun->id }}, '{{ addslashes($urun->ad) }}')"
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition flex items-center justify-center"
                                    title="Sil">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-400 py-16">
                        <i class="fa-solid fa-box-open text-5xl mb-4 block opacity-20"></i>
                        <p class="text-sm font-bold text-gray-600 mb-1">Henüz Ürün Bulunmuyor</p>
                        <a href="{{ route('admin.urunler.create') }}" class="text-blue-500 text-xs font-semibold hover:underline">İlk Ürünü Ekle →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($urunler->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $urunler->links('pagination::tailwind') }}
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════════════════════
     VARYASYON MODAL
     Özellikler ozellik_degerleri → ozellik ilişkisiyle gelir.
     Controller'da with(['varyasyonlar.ozellikDegerleri.ozellik']) eager load edilmeli.
═══════════════════════════════════════════════════════════ --}}
<div id="varyasyonModal" class="fixed inset-0 z-50 hidden">
    <div class="flex items-start justify-center min-h-screen px-4 py-16">

        {{-- Overlay --}}
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="varyasyonModalKapat()"></div>

        {{-- Panel --}}
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl z-10 overflow-hidden">

            {{-- Başlık --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900" id="modalUrunAdi">Ürün Seçenekleri</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Ürüne ait varyasyonlar, özellikler ve stok durumu</p>
                </div>
                <button onclick="varyasyonModalKapat()"
                        class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-gray-400"></i>
                </button>
            </div>

            {{-- İçerik --}}
            <div class="max-h-[65vh] overflow-y-auto">
                <table class="w-full text-left">
                    <thead class="sticky top-0 bg-gray-50 border-b border-gray-100 z-20">
                        <tr>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Özellikler</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Fiyat</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Stok</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">SKU / Barkod</th>
                        </tr>
                    </thead>
                    <tbody id="modalTbody">
                        {{-- JS ile doldurulur --}}
                    </tbody>
                </table>

                {{-- Boş durum --}}
                <div id="modalBos" class="hidden text-center py-14 text-gray-400">
                    <i class="fa-solid fa-sliders text-4xl mb-3 block opacity-20"></i>
                    <p class="text-sm font-medium">Bu ürüne henüz varyasyon eklenmemiş.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{--
    Ürün verilerini JS'e aktarıyoruz.
    ÖNEMLI: Controller'da mutlaka şu eager load olmalı:
    Urun::with(['kategoriler', 'gorseller', 'varyasyonlar.ozellikDegerleri.ozellik'])
--}}

{{-- ════════════════════════════════════════════════════════
     SİLME ONAY MODALI
════════════════════════════════════════════════════════ --}}
<div id="silModal" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="silModalKapat()"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md z-10 p-8 text-center">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Ürünü Sil</h3>
            <p class="text-sm text-gray-500 mb-1">
                <strong id="silModalUrunAd" class="text-gray-800">—</strong> adlı ürünü silmek istediğinize emin misiniz?
            </p>
            <p class="text-xs text-red-500 font-medium mb-7">
                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                Tüm görseller ve varyasyonlar da silinir. Geri alınamaz.
            </p>
            <div class="flex gap-3">
                <button onclick="silModalKapat()"
                        class="flex-1 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    İptal
                </button>
                <form id="silForm" method="POST" class="flex-1">
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
<script>
const tumUrunler = @json($urunler->items());

/* ── Silme Modalı ── */
function silModalAc(urunId, urunAd) {
    document.getElementById('silModalUrunAd').textContent = urunAd;
    // Route'u dinamik oluştur
    const baseUrl = '{{ url("admin/urunler") }}';
    const form    = document.getElementById('silForm');
    form.action   = baseUrl + '/' + urunId;
    document.getElementById('silModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function silModalKapat() {
    document.getElementById('silModal').classList.add('hidden');
    document.body.style.overflow = '';
}

/* ── Varyasyon Modalı ── */

function varyasyonModalAc(urunId) {
    const urun = tumUrunler.find(u => u.id === urunId);
    if (!urun) return;

    document.getElementById('modalUrunAdi').textContent = urun.ad;

    const tbody = document.getElementById('modalTbody');
    const bos   = document.getElementById('modalBos');
    tbody.innerHTML = '';

    const varyasyonlar = urun.varyasyonlar || [];

    if (varyasyonlar.length === 0) {
        bos.classList.remove('hidden');
    } else {
        bos.classList.add('hidden');

        varyasyonlar.forEach(function(v) {
            /* ── Özellik rozetleri ── */
            let rozetler = '';
            const degerler = v.ozellik_degerleri || [];   // snake_case (JSON serialization)

            if (degerler.length > 0) {
                degerler.forEach(function(od) {
                    const ozellikAdi = od.ozellik ? od.ozellik.ad : '?';
                    rozetler += `
                        <span class="inline-flex flex-col bg-slate-50 border border-slate-200 px-2.5 py-1.5 rounded-lg mr-1.5 mb-1">
                            <span class="text-[9px] text-slate-400 uppercase font-bold leading-none mb-0.5">${ozellikAdi}</span>
                            <span class="text-xs text-slate-800 font-bold leading-none">${od.deger}</span>
                        </span>`;
                });
            } else {
                rozetler = '<span class="text-xs text-gray-400 italic">Standart</span>';
            }

            /* ── Fiyat ── */
            const aktifFiyat = v.indirimli_fiyat || v.normal_fiyat;
            const fiyatHtml  = v.indirimli_fiyat
                ? `<p class="text-sm font-bold text-gray-900">₺${parseFloat(aktifFiyat).toLocaleString('tr-TR',{minimumFractionDigits:2})}</p>
                   <p class="text-[10px] text-gray-400 line-through">₺${parseFloat(v.normal_fiyat).toLocaleString('tr-TR',{minimumFractionDigits:2})}</p>`
                : `<p class="text-sm font-bold text-gray-900">₺${parseFloat(aktifFiyat).toLocaleString('tr-TR',{minimumFractionDigits:2})}</p>`;

            /* ── Stok rengi ── */
            let stokClass = 'text-green-600 bg-green-50';
            if (v.anlik_stok <= 0)   stokClass = 'text-red-600 bg-red-50';
            else if (v.anlik_stok <= 10) stokClass = 'text-amber-600 bg-amber-50';

            tbody.innerHTML += `
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap">${rozetler}</div>
                    </td>
                    <td class="px-6 py-4">${fiyatHtml}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold ${stokClass}">
                            ${v.anlik_stok} Adet
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="text-[10px] font-mono text-gray-500"><span class="text-gray-300">SKU: </span>${v.sku || '—'}</p>
                        <p class="text-[10px] font-mono text-gray-500"><span class="text-gray-300">BAR: </span>${v.barkod || '—'}</p>
                    </td>
                </tr>`;
        });
    }

    document.getElementById('varyasyonModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function varyasyonModalKapat() {
    document.getElementById('varyasyonModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// ESC ile kapat
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        varyasyonModalKapat();
        silModalKapat();
    }
});
</script>

@endsection