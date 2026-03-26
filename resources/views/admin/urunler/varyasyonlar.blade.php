@extends('admin.layout')

@section('page_title', 'Varyasyon Yönetimi')

@section('admin_content')

{{-- BİLDİRİMLER --}}
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-600 text-sm font-semibold flex items-center gap-2">
    <i class="fa-solid fa-check-circle text-lg"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold flex flex-col gap-1">
    @foreach($errors->all() as $error)
        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</span>
    @endforeach
</div>
@endif

{{-- ÜST BİLGİ BARI --}}
<div class="flex items-center justify-between mb-7">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.urunler.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Özellik & Varyasyon Yönetimi</h1>
            <p class="text-sm text-gray-400 mt-0.5"><strong class="text-gray-600">{{ $urun->ad }}</strong> isimli ürüne seçenekler ekliyorsunuz.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- SOL: YENİ VARYASYON EKLEME FORMU --}}
    <div class="lg:col-span-1">
        <form action="{{ route('admin.urunler.varyasyonKaydet', $urun->id) }}" method="POST" class="card p-6 shadow-sm sticky top-24">
            @csrf
            <h2 class="text-sm font-bold text-gray-800 mb-5 pb-3 border-b border-gray-100"><i class="fa-solid fa-plus-circle mr-2 text-gray-400"></i>Yeni Seçenek Ekle</h2>

            <div class="space-y-5">
                {{-- ÖZELLİK 1 (Örn: Renk) --}}
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="mb-3">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">1. Özellik Adı <span class="text-red-500">*</span></label>
                        <input type="text" name="ozellik_ad_1" list="ozellikler" required placeholder="Örn: Renk, Beden, Kutu Boyu" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-gray-900 outline-none text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Değeri <span class="text-red-500">*</span></label>
                        <input type="text" name="ozellik_deger_1" required placeholder="Örn: Kırmızı, Small, Büyük" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-gray-900 outline-none text-sm font-bold text-blue-600">
                    </div>
                </div>

                {{-- ÖZELLİK 2 (Opsiyonel) --}}
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 opacity-70 hover:opacity-100 transition">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3"><i class="fa-solid fa-link mr-1"></i> İkinci Özellik (İsteğe Bağlı)</p>
                    <div class="mb-3">
                        <input type="text" name="ozellik_ad_2" list="ozellikler" placeholder="Örn: Beden" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-gray-900 outline-none text-sm font-medium">
                    </div>
                    <div>
                        <input type="text" name="ozellik_deger_2" placeholder="Örn: M Beden" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-gray-900 outline-none text-sm font-bold text-blue-600">
                    </div>
                </div>

                {{-- FİYAT VE STOK --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Normal Fiyat <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="normal_fiyat" required value="{{ $urun->varyasyonlar->first()->normal_fiyat ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-gray-900 outline-none text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">İndirimli Fiyat</label>
                        <input type="number" step="0.01" name="indirimli_fiyat" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-gray-900 outline-none text-sm font-bold text-red-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Stok Adedi <span class="text-red-500">*</span></label>
                        <input type="number" name="anlik_stok" required placeholder="0" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-gray-900 outline-none text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">SKU (Stok Kodu)</label>
                        <input type="text" name="sku" placeholder="SKU" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-gray-900 outline-none text-sm uppercase">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold transition shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i> Varyasyonu Kaydet
                </button>
            </div>
        </form>
    </div>

    {{-- SAĞ: MEVCUT VARYASYONLAR TABLOSU --}}
    <div class="lg:col-span-2 card overflow-hidden shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white">
            <h2 class="text-sm font-bold text-gray-800">Eklenen Seçenekler</h2>
            <span class="badge badge-blue">{{ $urun->varyasyonlar->count() }} Adet</span>
        </div>

        <div class="overflow-x-auto">
            <table class="clean w-full">
                <thead>
                    <tr>
                        <th>Özellikler (Renk, Beden vb.)</th>
                        <th>Fiyat</th>
                        <th>Stok</th>
                        <th>SKU</th>
                        <th class="text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($urun->varyasyonlar as $varyasyon)
                    <tr class="hover:bg-gray-50 transition">
                        <td>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($varyasyon->ozellikDegerleri as $deger)
                                    <span class="text-[11px] bg-slate-100 text-slate-700 px-2 py-1 rounded-md font-bold border border-slate-200">
                                        <span class="text-slate-400 font-medium mr-1">{{ $deger->ozellik->ad }}:</span>{{ $deger->deger }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <p class="font-bold text-gray-800 text-sm">₺{{ number_format($varyasyon->indirimli_fiyat ?? $varyasyon->normal_fiyat, 2, ',', '.') }}</p>
                            @if($varyasyon->indirimli_fiyat)
                                <p class="text-[10px] text-gray-400 line-through">₺{{ number_format($varyasyon->normal_fiyat, 2, ',', '.') }}</p>
                            @endif
                        </td>
                        <td>
                            <span class="font-bold {{ $varyasyon->anlik_stok > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $varyasyon->anlik_stok }}</span>
                        </td>
                        <td class="text-xs text-gray-500 uppercase">{{ $varyasyon->sku ?? '-' }}</td>
                        <td class="text-right">
                            {{-- SİLME FORMU --}}
                            <form action="{{ route('admin.urunler.varyasyonSil', $varyasyon->id) }}" method="POST" onsubmit="return confirm('Bu seçeneği silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition flex items-center justify-center ml-auto" title="Sil">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-12">
                            <i class="fa-solid fa-sliders text-4xl mb-3 block opacity-20"></i>
                            <p class="text-sm font-medium">Bu ürüne henüz bir özellik eklenmemiş.</p>
                            <p class="text-xs mt-1">Sol taraftaki formu kullanarak renk, beden gibi seçenekler ekleyin.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Otomatik Tamamlama İçin Veri Listesi (Datalist) --}}
<datalist id="ozellikler">
    @foreach($tumOzellikler as $oz)
        <option value="{{ $oz->ad }}">
    @endforeach
</datalist>

@endsection