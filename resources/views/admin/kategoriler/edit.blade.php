@extends('admin.layout')

@section('page_title', 'Kategori Düzenle')

@section('admin_content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Kategori Düzenle</h1>
        <p class="text-sm text-gray-400 mt-0.5"><span class="font-semibold text-[#326765]">{{ $kategori->ad }}</span> kategorisinin bilgilerini güncelliyorsunuz.</p>
    </div>
    <a href="{{ route('admin.kategoriler.index') }}" class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold py-2.5 px-5 rounded-xl transition flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-arrow-left text-xs"></i> İptal ve Geri Dön
    </a>
</div>

<div class="card p-8 max-w-2xl bg-white shadow-sm border border-gray-100 rounded-[2rem]">
    <form action="{{ route('admin.kategoriler.update', $kategori->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Mevcut Görsel Önizleme ve Yeni Görsel Yükleme --}}
        <div>
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-3">Kategori Görseli</label>
            <div class="flex items-center gap-6">
                @if($kategori->gorsel)
                    <img src="{{ asset('storage/' . $kategori->gorsel) }}" alt="Mevcut Görsel" class="w-24 h-24 rounded-2xl object-cover shadow-sm border border-gray-100">
                @else
                    <div class="w-24 h-24 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 border border-gray-100">
                        <i class="fa-regular fa-image text-2xl"></i>
                    </div>
                @endif
                
                <div class="flex-1">
                    <p class="text-xs text-gray-500 mb-2">Yeni bir görsel seçerek mevcut olanı değiştirebilirsiniz.</p>
                    <input type="file" name="gorsel" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#EAF1F1] file:text-[#326765] cursor-pointer transition hover:file:bg-[#326765] hover:file:text-white">
                </div>
            </div>
        </div>

        <hr class="border-gray-100">

        {{-- Kategori Adı --}}
        <div>
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori Adı <span class="text-red-500">*</span></label>
            <input type="text" name="ad" value="{{ $kategori->ad }}" required 
                   class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:border-[#326765] focus:ring-1 focus:ring-[#326765] outline-none transition text-sm text-gray-800 font-semibold bg-gray-50 focus:bg-white">
        </div>

        {{-- Üst Kategori Seçimi --}}
        <div>
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Üst Kategori</label>
            <select name="ust_kategori_id" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:border-[#326765] outline-none transition text-sm text-gray-700 bg-gray-50 focus:bg-white cursor-pointer">
                <option value="">-- Ana Kategori Olsun --</option>
                @foreach($tumKategoriler as $kat)
                    <option value="{{ $kat->id }}" {{ $kategori->ust_kategori_id == $kat->id ? 'selected' : '' }}>
                        {{ $kat->ustKategori ? $kat->ustKategori->ad . ' > ' : '' }}{{ $kat->ad }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- YENİ EKLENDİ: ÖZEL KUTU MODÜLÜ CHECKBOX --}}
        <div>
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Modül Ayarları</label>
            <label class="flex items-start gap-4 p-5 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition bg-gray-50/50">
                <div class="pt-0.5">
                    <input type="checkbox" name="ozel_kutuda_goster" value="1" 
                           {{ $kategori->ozel_kutuda_goster ? 'checked' : '' }}
                           class="w-5 h-5 text-[#326765] rounded border-gray-300 focus:ring-[#326765] cursor-pointer">
                </div>
                <div>
                    <span class="block text-sm font-bold text-gray-800">"Kendi Kutunu Yap" Modülünde Göster</span>
                    <span class="block text-[12px] text-gray-500 mt-1 leading-relaxed">Eğer işaretlerseniz, müşteriler özel hediye kutusu oluştururken bu kategorideki ürünleri <b>kutu veya hediye seçeneği</b> olarak görebilirler. Standart ürün kategorileri için işaretlemeyin.</span>
                </div>
            </label>
        </div>

        {{-- Buton --}}
        <div class="pt-4">
            <button type="submit" class="w-full py-4 rounded-xl bg-[#326765] hover:bg-[#26504e] text-white text-sm font-bold tracking-wide uppercase transition shadow-lg shadow-[#326765]/30">
                Değişiklikleri Kaydet
            </button>
        </div>
    </form>
</div>

@endsection