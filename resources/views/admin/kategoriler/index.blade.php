@extends('admin.layout')

@section('page_title', 'Kategori Yönetimi')

@section('admin_content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-600 text-sm font-semibold flex items-center gap-2 shadow-sm">
    <i class="fa-solid fa-check-circle text-lg"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold flex flex-col gap-1 shadow-sm">
    @foreach($errors->all() as $error)
        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</span>
    @endforeach
</div>
@endif

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

<div class="card overflow-hidden shadow-sm">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white">
        <h2 class="text-sm font-bold text-gray-800">Tüm Kategoriler</h2>
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
                    <th class="w-16 text-center">Görsel</th>
                    <th>Kategori Adı</th>
                    <th>Üst Kategori</th>
                    <th>Özel Kutu Modülü</th> <th>URL</th>
                    <th class="text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoriler as $kategori)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="text-center">
                        @if($kategori->gorsel)
                            <img src="{{ asset('storage/' . $kategori->gorsel) }}" alt="{{ $kategori->ad }}" class="w-10 h-10 rounded-lg object-cover mx-auto shadow-sm">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mx-auto text-gray-400">
                                <i class="fa-regular fa-image text-xs"></i>
                            </div>
                        @endif
                    </td>
                    <td class="font-bold text-gray-800">{{ $kategori->ad }}</td>
                    <td>
                        @if($kategori->ustKategori)
                            <span class="badge badge-slate">
                                <i class="fa-solid fa-level-up-alt mr-1 rotate-90 text-[9px] opacity-70"></i> 
                                {{ $kategori->ustKategori->ad }}
                            </span>
                        @else
                            <span class="text-xs text-gray-400 font-semibold">Ana Kategori</span>
                        @endif
                    </td>
                    
                    {{-- YENİ EKLENDİ: Özel Kutu Rozeti --}}
                    <td>
                        @if($kategori->ozel_kutuda_goster)
                            <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-[#EAF1F1] text-[#326765] border border-[#326765]/20">
                                <i class="fa-solid fa-box-open mr-1"></i> Aktif
                            </span>
                        @else
                            <span class="text-xs text-gray-400 font-medium">-</span>
                        @endif
                    </td>

                    <td class="text-gray-500 text-xs">{{ $kategori->slug ?? '-' }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.kategoriler.edit', $kategori->id) }}" class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 text-blue-500 hover:bg-blue-500 hover:text-white flex items-center justify-center transition" title="Düzenle">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            
                            <form action="{{ route('admin.kategoriler.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Bu kategoriyi silmek istediğinize emin misiniz?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 border border-red-100 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition" title="Sil">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-400 py-12">
                        <i class="fa-solid fa-layer-group text-4xl mb-3 block opacity-20"></i>
                        <p class="text-sm font-medium">Henüz hiç kategori eklenmemiş.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($kategoriler->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $kategoriler->links('pagination::tailwind') }}
    </div>
    @endif
</div>

{{-- MODAL (KATEGORİ EKLE) --}}
<div id="addCategoryModal" class="modal-overlay" onclick="if(event.target===this) this.classList.remove('open')">
    <div class="modal-box text-left max-w-md">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Yeni Kategori Ekle</h3>
            <button type="button" onclick="document.getElementById('addCategoryModal').classList.remove('open')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form action="{{ route('admin.kategoriler.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori Görseli</label>
                <input type="file" name="gorsel" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#EAF1F1] file:text-[#326765] cursor-pointer">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori Adı <span class="text-red-500">*</span></label>
                <input type="text" name="ad" required placeholder="Örn: Kahveler" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#326765] focus:ring-1 focus:ring-[#326765] outline-none transition text-sm text-gray-800 font-medium">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Üst Kategori (Opsiyonel)</label>
                <select name="ust_kategori_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#326765] outline-none transition text-sm text-gray-700 bg-white">
                    <option value="">-- Ana Kategori Olsun --</option>
                    @foreach($tumKategoriler as $kat)
                        <option value="{{ $kat->id }}">
                            {{ $kat->ustKategori ? $kat->ustKategori->ad . ' > ' : '' }}{{ $kat->ad }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- YENİ EKLENDİ: ÖZEL KUTU CHECKBOX --}}
            <div>
                <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                    <input type="checkbox" name="ozel_kutuda_goster" value="1" class="w-5 h-5 text-[#326765] rounded border-gray-300 focus:ring-[#326765]">
                    <div>
                        <span class="block text-sm font-bold text-gray-800">Özel Kutuda Göster</span>
                        <span class="block text-[10px] text-gray-500">Bu kategori "Kendi Kutunu Yap" sayfasında hediye veya kutu seçeneği olarak listelensin.</span>
                    </div>
                </label>
            </div>

            <div class="pt-3 flex gap-3">
                <button type="button" onclick="document.getElementById('addCategoryModal').classList.remove('open')" 
                        class="flex-1 py-3.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition">
                    İptal
                </button>
                <button type="submit" 
                        class="flex-1 py-3.5 rounded-xl bg-[#326765] hover:bg-[#26504e] text-white text-sm font-bold transition text-center shadow-lg shadow-[#326765]/30">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection