@extends('admin.layout')

@section('page_title', 'Ürün Yönetimi')

@section('admin_content')

{{-- BAŞARI MESAJI --}}
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-600 text-sm font-semibold flex items-center gap-2 shadow-sm">
    <i class="fa-solid fa-check-circle text-lg"></i> {{ session('success') }}
</div>
@endif

{{-- SAYFA BAŞLIĞI VE BUTON --}}
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

{{-- ÜRÜN TABLOSU --}}
<div class="card overflow-hidden shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between px-6 py-4 border-b border-gray-100 bg-white gap-4">
        <h2 class="text-sm font-bold text-gray-800">Tüm Ürünler <span class="text-gray-400 font-normal">({{ $urunler->total() }})</span></h2>
        
        <div class="flex items-center gap-3">
            <div class="relative">
                <input type="text" placeholder="Ürün adı veya SKU ara..." 
                       class="pl-9 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-lg text-xs focus:outline-none focus:border-gray-300 focus:bg-white transition w-56 text-gray-700">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="clean w-full text-left">
            <thead>
                <tr>
                    <th class="w-16">Görsel</th>
                    <th>Ürün Adı & Kategori</th>
                    <th>Tip</th>
                    <th>Fiyat Bilgisi</th>
                    <th>Toplam Stok</th>
                    <th>Durum</th>
                    <th class="text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($urunler as $urun)
                <tr class="hover:bg-gray-50/50 transition border-b border-gray-50 last:border-0">
                    <td>
                        <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center">
                            @if($urun->gorseller->count() > 0)
                                <img src="{{ asset($urun->gorseller->first()->gorsel_url) }}" alt="{{ $urun->ad }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-gray-300 text-lg"></i>
                            @endif
                        </div>
                    </td>
                    
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
                    
                    <td>
                        @if($urun->varyasyonlu_mu)
                            <span class="badge badge-amber"><i class="fa-solid fa-layer-group mr-1.5"></i> Varyasyonlu</span>
                        @else
                            <span class="badge badge-slate"><i class="fa-solid fa-cube mr-1.5"></i> Standart</span>
                        @endif
                    </td>

                    <td>
                        @if($urun->varyasyonlar->count() > 0)
                            @php $ilkV = $urun->varyasyonlar->first(); @endphp
                            <p class="font-bold text-gray-800 text-sm">₺{{ number_format($ilkV->indirimli_fiyat ?? $ilkV->normal_fiyat, 2, ',', '.') }}</p>
                            @if($ilkV->indirimli_fiyat)
                                <p class="text-[10px] text-gray-400 line-through">₺{{ number_format($ilkV->normal_fiyat, 2, ',', '.') }}</p>
                            @endif
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>

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
                    
                    <td>
                        @if($urun->aktif_mi)
                            <span class="badge badge-green">Aktif</span>
                        @else
                            <span class="badge badge-slate">Pasif</span>
                        @endif
                    </td>
                    
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{-- VARYASYON MODAL BUTONU --}}
                            @if($urun->varyasyonlu_mu)
                            <button type="button" 
                                    onclick="openVaryasyonModal({{ $urun->id }})"
                                    class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition flex items-center justify-center" 
                                    title="Seçenekleri Gör">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </button>
                            @endif

                            <a href="#" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 transition flex items-center justify-center" title="Düzenle">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <button class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition flex items-center justify-center" title="Sil">
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
                        <a href="{{ route('admin.urunler.create') }}" class="text-blue-500 text-xs font-semibold hover:underline">İlk Ürünü Ekle</a>
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

{{-- VARYASYON MODAL --}}
<div id="varyasyonModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeVaryasyonModal()"></div>
        
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl z-10 overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
                <div>
                    <h3 class="text-lg font-bold text-gray-900" id="modalTitle">Ürün Seçenekleri</h3>
                    <p class="text-xs text-gray-400">Ürüne ait tüm alt varyasyonlar, fiyatlar ve stok durumları.</p>
                </div>
                <button onclick="closeVaryasyonModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-gray-400"></i>
                </button>
            </div>
            
            <div class="p-0 max-h-[60vh] overflow-y-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="sticky top-0 bg-gray-50 border-b border-gray-100 z-20">
                        <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <th class="px-6 py-4">Özellik Karışımı</th>
                            <th class="px-6 py-4">Fiyat</th>
                            <th class="px-6 py-4">Stok</th>
                            <th class="px-6 py-4 text-right">Kodlar (SKU/Barkod)</th>
                        </tr>
                    </thead>
                    <tbody id="modalBody">
                        {{-- JavaScript ile dolacak --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Laravel'den gelen tüm ürünleri (varyasyonlarıyla birlikte) JS'e alıyoruz
    const urunVerileri = @json($urunler->items());

    function openVaryasyonModal(urunId) {
        const urun = urunVerileri.find(u => u.id === urunId);
        if (!urun) return;

        document.getElementById('modalTitle').innerText = urun.ad;
        const tbody = document.getElementById('modalBody');
        tbody.innerHTML = '';

        urun.varyasyonlar.forEach(v => {
            // Renk: Siyah, Beden: XL gibi özellikleri formatla
            let ozellikRozetleri = '';
            if(v.ozellik_degerleri && v.ozellik_degerleri.length > 0) {
                v.ozellik_degerleri.forEach(od => {
                    ozellikRozetleri += `
                        <div class="inline-flex flex-col bg-slate-50 border border-slate-100 px-2 py-1 rounded mr-1">
                            <span class="text-[9px] text-slate-400 uppercase font-bold">${od.ozellik.ad}</span>
                            <span class="text-xs text-slate-700 font-bold">${od.deger}</span>
                        </div>
                    `;
                });
            } else {
                ozellikRozetleri = '<span class="text-gray-400 italic text-xs">Standart Ürün</span>';
            }

            const fiyat = v.indirimli_fiyat || v.normal_fiyat;
            const stokRengi = v.anlik_stok > 10 ? 'text-green-600 bg-green-50' : (v.anlik_stok > 0 ? 'text-amber-600 bg-amber-50' : 'text-red-600 bg-red-50');

            tbody.innerHTML += `
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">${ozellikRozetleri}</td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold text-gray-900">₺${new Number(fiyat).toLocaleString('tr-TR', {minimumFractionDigits: 2})}</span>
                        ${v.indirimli_fiyat ? `<span class="block text-[10px] text-gray-400 line-through">₺${new Number(v.normal_fiyat).toLocaleString('tr-TR')}</span>` : ''}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold ${stokRengi}">
                            ${v.anlik_stok} Adet
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="text-[10px] font-mono text-gray-500"><span class="text-gray-300">SKU:</span> ${v.sku || '-'}</div>
                        <div class="text-[10px] font-mono text-gray-500"><span class="text-gray-300">BAR:</span> ${v.barkod || '-'}</div>
                    </td>
                </tr>
            `;
        });

        document.getElementById('varyasyonModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Sayfa kaymasını engelle
    }

    function closeVaryasyonModal() {
        document.getElementById('varyasyonModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>

@endsection