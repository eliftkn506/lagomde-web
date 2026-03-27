@extends('admin.layout')

@section('page_title', 'Anasayfa Yönetimi')

@section('admin_content')

{{-- ÜST BAŞLIK VE EKLE BUTONU --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Anasayfa Yönetimi</h1>
        <p class="text-sm text-gray-400 mt-0.5">Sitenizin anasayfasındaki bölümleri (kategoriler, bannerlar, avantajlar) buradan sıralayın ve yönetin.</p>
    </div>
    <a href="{{ route('admin.anasayfa-bloklari.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#326765] text-white rounded-xl text-sm font-bold tracking-wide hover:bg-[#26504e] transition shadow-lg shadow-[#326765]/30 group">
        <i class="fa-solid fa-plus text-xs group-hover:rotate-90 transition-transform duration-300"></i> YENİ BLOK EKLE
    </a>
</div>

{{-- BAŞARI BİLDİRİMİ --}}
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-center gap-3">
    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
        <i class="fa-solid fa-check text-green-500 text-sm"></i>
    </div>
    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
</div>
@endif

{{-- BLOKLAR TABLOSU --}}
<div class="card overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="clean w-full">
            <thead>
                <tr>
                    <th class="w-16 text-center">Sıra</th>
                    <th>Blok Tipi</th>
                    <th>Başlık & Alt Başlık</th>
                    <th class="text-center">Durum</th>
                    <th class="text-right pr-8">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bloklar as $blok)
                <tr class="hover:bg-gray-50 transition-colors">
                    
                    {{-- Sıra --}}
                    <td class="text-center">
                        <div class="w-8 h-8 mx-auto rounded-lg bg-gray-100 flex items-center justify-center font-bold text-gray-600 text-sm">
                            {{ $blok->sira }}
                        </div>
                    </td>
                    
                    {{-- Blok Tipi (Renkli Rozetler) --}}
                    <td>
                        @if($blok->tip == 'kategori_vitrini')
                            <span class="badge badge-blue"><i class="fa-solid fa-border-all mr-1.5"></i> Kategori Vitrini</span>
                        @elseif($blok->tip == 'ikon_seridi')
                            <span class="badge badge-amber"><i class="fa-solid fa-icons mr-1.5"></i> İkon Şeridi</span>
                        @elseif($blok->tip == 'full_banner')
                            <span class="badge badge-slate"><i class="fa-regular fa-image mr-1.5"></i> Full Banner</span>
                        @elseif($blok->tip == 'koleksiyon_grid')
                            <span class="badge" style="background:#EAF1F1; color:#326765;"><i class="fa-solid fa-grip mr-1.5"></i> Koleksiyon Grid</span>
                        @elseif($blok->tip == 'avantajlar')
                            <span class="badge badge-green"><i class="fa-solid fa-truck-fast mr-1.5"></i> Avantajlar</span>
                        @elseif($blok->tip == 'galeri')
                            <span class="badge badge-red"><i class="fa-brands fa-instagram mr-1.5"></i> İlham Galerisi</span>
                        @else
                            <span class="badge badge-slate">{{ $blok->tip }}</span>
                        @endif
                    </td>

                    {{-- Başlık Bilgileri --}}
                    <td>
                        <p class="font-bold text-gray-800 mb-0.5">{{ $blok->baslik ?? '(Başlıksız Blok)' }}</p>
                        <p class="text-[11px] text-gray-400 font-medium">{{ $blok->alt_baslik ?? '-' }}</p>
                    </td>
                    
                    {{-- Durum --}}
                    <td class="text-center">
                        @if($blok->aktif_mi)
                            <span class="badge badge-green">Aktif <span class="w-1.5 h-1.5 rounded-full bg-green-500 ml-1.5 inline-block"></span></span>
                        @else
                            <span class="badge badge-slate">Gizli <span class="w-1.5 h-1.5 rounded-full bg-gray-400 ml-1.5 inline-block"></span></span>
                        @endif
                    </td>
                    
                    {{-- İşlemler --}}
                    <td class="text-right pr-6">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.anasayfa-bloklari.edit', $blok->id) }}" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:text-[#326765] hover:border-[#326765] hover:bg-white flex items-center justify-center transition shadow-sm" title="Düzenle">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            
                            <form action="{{ route('admin.anasayfa-bloklari.destroy', $blok->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bu anasayfa bloğunu silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 border border-red-100 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition shadow-sm" title="Sil">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-20">
                        <div class="w-20 h-20 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fa-solid fa-cubes text-3xl"></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-800 mb-1">Anasayfa Şu An Boş</h3>
                        <p class="text-sm text-gray-400 mb-6">Sitenizin anasayfasını oluşturmak için ilk bloğunuzu ekleyin.</p>
                        <a href="{{ route('admin.anasayfa-bloklari.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:border-[#326765] hover:text-[#326765] transition shadow-sm">
                            <i class="fa-solid fa-plus"></i> İlk Bloğu Ekle
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection