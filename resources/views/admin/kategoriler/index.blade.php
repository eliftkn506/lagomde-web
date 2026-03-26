@extends('admin.layout')

@section('page_title', 'Kategori Yönetimi')

@section('admin_content')

{{-- BAŞARI MESAJI --}}
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-600 text-sm font-semibold flex items-center gap-2 shadow-sm">
    <i class="fa-solid fa-check-circle text-lg"></i> {{ session('success') }}
</div>
@endif

{{-- HATA MESAJLARI (Eğer form boş veya hatalı gönderilirse) --}}
@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold flex flex-col gap-1 shadow-sm">
    @foreach($errors->all() as $error)
        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</span>
    @endforeach
</div>
@endif

{{-- SAYFA BAŞLIĞI VE BUTON --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Kategori Yönetimi</h1>
        <p class="text-sm text-gray-400 mt-0.5">Sistemdeki tüm ana ve alt kategorileri buradan yönetebilirsiniz.</p>
    </div>
    <button onclick="document.getElementById('addCategoryModal').classList.add('open')" 
            class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2.5 px-5 rounded-xl transition flex items-center gap-2 shadow-lg shadow-gray-200">
        <i class="fa-solid fa-plus text-xs"></i> Yeni Kategori Ekle
    </button>
</div>

{{-- KATEGORİ TABLOSU --}}
<div class="card overflow-hidden shadow-sm">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white">
        <h2 class="text-sm font-bold text-gray-800">Tüm Kategoriler</h2>
        
        {{-- Arama Kutusu --}}
        <div class="relative">
            <input type="text" placeholder="Kategori ara..." 
                   class="pl-9 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-lg text-xs focus:outline-none focus:border-gray-300 focus:bg-white transition w-48 text-gray-700">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="clean w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kategori Adı</th>
                    <th>Bağlı Olduğu Kategori (Üst)</th>
                    <th>Slug / URL</th>
                    <th class="text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoriler as $kategori)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="font-semibold text-gray-500">#{{ $kategori->id }}</td>
                    <td class="font-bold text-gray-800">
                        {{ $kategori->ad }}
                    </td>
                    <td>
                        @if($kategori->ustKategori)
                            <span class="badge badge-slate">
                                <i class="fa-solid fa-level-up-alt mr-1 rotate-90 text-[9px] opacity-70"></i> 
                                {{ $kategori->ustKategori->ad }}
                            </span>
                        @else
                            <span class="text-xs text-gray-400 italic font-semibold">Ana Kategori</span>
                        @endif
                    </td>
                    <td class="text-gray-500 text-xs">{{ $kategori->slug ?? '-' }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 transition flex items-center justify-center" title="Düzenle">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            <button class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition flex items-center justify-center" title="Sil">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-400 py-12">
                        <i class="fa-solid fa-layer-group text-4xl mb-3 block opacity-20"></i>
                        <p class="text-sm font-medium">Henüz hiç kategori eklenmemiş.</p>
                        <p class="text-xs mt-1">Sağ üstteki butonu kullanarak ilk kategorinizi ekleyin.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Sayfalama (Pagination) --}}
    @if($kategoriler->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $kategoriler->links('pagination::tailwind') }}
    </div>
    @endif
</div>

{{-- KATEGORİ EKLEME MODALI (POP-UP) --}}
<div id="addCategoryModal" class="modal-overlay" onclick="if(event.target===this) this.classList.remove('open')">
    <div class="modal-box text-left max-w-md">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Yeni Kategori Ekle</h3>
            <button type="button" onclick="document.getElementById('addCategoryModal').classList.remove('open')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form action="{{ route('admin.kategoriler.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Kategori Adı --}}
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori Adı <span class="text-red-500">*</span></label>
                <input type="text" name="ad" required placeholder="Örn: Sevgiliye Doğum Günü Hediyesi" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-800 font-medium">
            </div>

            {{-- Üst Kategori Seçimi (Muhiku stili alt kategoriler için) --}}
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Üst Kategori (Opsiyonel)</label>
                <select name="ust_kategori_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 outline-none transition text-sm text-gray-700 bg-white">
                    <option value="">-- Ana Kategori Olsun (En Üst Seviye) --</option>
                    
                    {{-- Tüm kategorileri hiyerarşik listeleme --}}
                    @foreach($tumKategoriler as $kat)
                        <option value="{{ $kat->id }}">
                            {{-- Eğer üst kategorisi varsa adının başına ekleyip ok işareti koyuyoruz --}}
                            {{ $kat->ustKategori ? $kat->ustKategori->ad . ' > ' : '' }}{{ $kat->ad }}
                        </option>
                    @endforeach
                    
                </select>
                <p class="text-[11px] text-gray-400 mt-2 font-medium">Eğer bu kategori bir başlığın altına girecekse (Örn: Hediye Gönder > Doğum Günü Hediyesi), o başlığı seçin.</p>
            </div>

            {{-- Butonlar --}}
            <div class="pt-3 flex gap-3">
                <button type="button" onclick="document.getElementById('addCategoryModal').classList.remove('open')" 
                        class="flex-1 py-3.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition">
                    İptal
                </button>
                <button type="submit" 
                        class="flex-1 py-3.5 rounded-xl bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold transition text-center shadow-lg shadow-gray-200">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

@endsection