@extends('admin.layout')

@section('page_title', 'Yeni Anasayfa Bloğu Ekle')

@section('admin_content')

{{-- ÜST BAŞLIK VE GERİ BUTONU --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Yeni Anasayfa Bloğu Ekle</h1>
        <p class="text-sm text-gray-400 mt-0.5">Anasayfanızda sergilemek istediğiniz modülü seçin ve içeriklerini doldurun.</p>
    </div>
    <a href="{{ route('admin.anasayfa-bloklari.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
        <i class="fa-solid fa-arrow-left text-xs"></i> Vazgeç ve Geri Dön
    </a>
</div>

{{-- FORM ALANI (Alpine.js ile Dinamik Yapı) --}}
{{-- x-data ile varsayılan olarak 'full_banner' tipini seçili başlatıyoruz --}}
<form action="{{ route('admin.anasayfa-bloklari.store') }}" method="POST" enctype="multipart/form-data" x-data="{ tip: '' }">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- SOL PANEL: İÇERİK ALANLARI --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- 1. GENEL BİLGİLER (Her blokta ortaktır) --}}
            <div class="card p-6 md:p-8 border-t-4 border-t-[#326765]" x-show="tip !== ''" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Genel Blok Başlıkları (İsteğe Bağlı)</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Üst Küçük Başlık (Alt Başlık)</label>
                        <input type="text" name="alt_baslik" placeholder="Örn: Yeni Deneyim veya Editörün Seçimi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#326765]/20 focus:border-[#326765] outline-none text-sm font-medium text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Ana Başlık</label>
                        <input type="text" name="baslik" placeholder="Örn: Kendi Hediye Kutunu Tasarla" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#326765]/20 focus:border-[#326765] outline-none text-sm font-bold text-gray-800">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Buton Metni</label>
                        <input type="text" name="buton_metni" placeholder="Örn: Hemen Başla" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#326765]/20 focus:border-[#326765] outline-none text-sm font-medium text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Buton Linki (URL)</label>
                        <input type="text" name="buton_linki" placeholder="Örn: /kendi-kutunu-yap" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#326765]/20 focus:border-[#326765] outline-none text-sm font-medium text-gray-800">
                    </div>
                </div>
            </div>

            {{-- 2. DİNAMİK ALAN: FULL BANNER İÇİN --}}
            <div class="card p-6 md:p-8" x-show="tip === 'full_banner'" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Banner İçerikleri</h3>
                
                <div class="mb-5">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Arka Plan Görseli</label>
                    <input type="file" name="icerik_verisi[arka_plan]" accept="image/*" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#EAF1F1] file:text-[#326765] hover:file:bg-[#326765] hover:file:text-white transition-all cursor-pointer">
                </div>
                
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Banner Açıklama Metni</label>
                    <textarea name="icerik_verisi[aciklama]" rows="3" placeholder="İstediğin ürünleri seç, kişisel notunu ekle..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#326765]/20 focus:border-[#326765] outline-none text-sm font-medium text-gray-800"></textarea>
                </div>
            </div>

            {{-- 3. DİNAMİK ALAN: AVANTAJLAR İÇİN (4'lü İkon Seti) --}}
            <div class="card p-6 md:p-8" x-show="tip === 'avantajlar'" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Avantaj Kartları (4 Adet)</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @for($i = 0; $i < 4; $i++)
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        <p class="text-xs font-bold text-[#326765] mb-3">{{ $i + 1 }}. Avantaj</p>
                        <input type="text" name="icerik_verisi[avantajlar][{{ $i }}][ikon]" placeholder="FontAwesome İkonu (Örn: fa-truck-fast)" class="w-full mb-3 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                        <input type="text" name="icerik_verisi[avantajlar][{{ $i }}][baslik]" placeholder="Başlık (Örn: Hızlı Gönderim)" class="w-full mb-3 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold outline-none">
                        <input type="text" name="icerik_verisi[avantajlar][{{ $i }}][aciklama]" placeholder="Kısa Açıklama" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                    @endfor
                </div>
            </div>

            {{-- 4. DİNAMİK ALAN: KOLEKSİYON GRİD İÇİN (3'lü Resimli Kutu) --}}
            <div class="card p-6 md:p-8" x-show="tip === 'koleksiyon_grid'" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Özel Koleksiyonlar (3 Adet)</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @for($i = 0; $i < 3; $i++)
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        <p class="text-xs font-bold text-[#326765] mb-3">{{ $i + 1 }}. Koleksiyon</p>
                        
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Kapak Görseli</label>
                        <input type="file" name="icerik_verisi[koleksiyonlar][{{ $i }}][resim]" accept="image/*" class="w-full mb-3 text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#EAF1F1] file:text-[#326765] cursor-pointer">
                        
                        <input type="text" name="icerik_verisi[koleksiyonlar][{{ $i }}][baslik]" placeholder="Başlık (Örn: Minimalist Yaşam)" class="w-full mb-3 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold outline-none">
                        
                        <input type="text" name="icerik_verisi[koleksiyonlar][{{ $i }}][aciklama]" placeholder="Kısa Açıklama" class="w-full mb-3 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                        
                        <input type="text" name="icerik_verisi[koleksiyonlar][{{ $i }}][renk]" placeholder="Arka Plan Rengi (Örn: #DED6CC)" class="w-full mb-3 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                        
                        <input type="text" name="icerik_verisi[koleksiyonlar][{{ $i }}][link]" placeholder="Yönlenecek Link (Örn: /kategori)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                    @endfor
                </div>
            </div>

            {{-- 5. DİNAMİK ALAN: İLHAM GALERİSİ İÇİN (6'lı Resim Grid) --}}
            <div class="card p-6 md:p-8" x-show="tip === 'galeri'" x-cloak>
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">İlham Galerisi (6 Adet Instagram Görseli)</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @for($i = 0; $i < 6; $i++)
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl relative">
                        <span class="absolute -top-3 -left-3 w-6 h-6 rounded-full bg-[#326765] text-white flex items-center justify-center text-xs font-bold">{{ $i + 1 }}</span>
                        
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1 mt-2">Galeri Görseli <span class="text-red-500">*</span></label>
                        <input type="file" name="icerik_verisi[galeri][{{ $i }}][resim]" accept="image/*" class="w-full mb-3 text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#EAF1F1] file:text-[#326765] cursor-pointer">
                        
                        <input type="text" name="icerik_verisi[galeri][{{ $i }}][link]" placeholder="Yönlenecek Link (Opsiyonel)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none focus:border-[#326765]">
                    </div>
                    @endfor
                </div>
            </div>
            
            {{-- Hoşgeldin Mesajı (Henüz tip seçilmemişse) --}}
            <div class="card p-12 text-center border-dashed border-2 border-gray-200" x-show="tip === ''">
                <div class="w-16 h-16 rounded-full bg-[#EAF1F1] flex items-center justify-center mx-auto mb-4 text-[#326765]">
                    <i class="fa-solid fa-wand-magic-sparkles text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-2">Blok Tipi Seçin</h3>
                <p class="text-sm text-gray-400">İçerik alanlarının açılması için lütfen sağ panelden bir blok tipi belirleyin.</p>
            </div>

        </div>

        {{-- SAĞ PANEL: AYARLAR --}}
        <div class="space-y-6">
            
            <div class="card p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Blok Ayarları</h3>

                {{-- TİP SEÇİMİ (Buradaki seçim Alpine.js ile solu değiştirir) --}}
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Blok Tipi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="tip" x-model="tip" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#326765]/20 focus:border-[#326765] outline-none text-sm font-bold text-gray-800 appearance-none cursor-pointer">
                            <option value="">Lütfen Seçiniz...</option>
                            <option value="full_banner">Full Banner (Örn: Kutu Tasarla)</option>
                            <option value="avantajlar">Avantajlar (İkonlu 4'lü Kutu)</option>
                            <option value="koleksiyon_grid">Koleksiyonlar (3'lü Resimli Grid)</option>
                            <option value="kategori_vitrini">Kategori Vitrini (Sol Büyük, Sağ Küçük)</option>
                            <option value="galeri">İlham Galerisi (6'lı Instagram Grid)</option>"
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                {{-- Sıra --}}
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Anasayfa Sırası</label>
                    <input type="number" name="sira" value="0" min="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#326765]/20 focus:border-[#326765] outline-none text-sm font-bold text-gray-800">
                    <p class="text-[10px] text-gray-400 mt-1.5">Küçük rakamlar en üstte çıkar (Örn: 1, 2, 3...)</p>
                </div>

                {{-- Aktif/Pasif --}}
                <div class="flex items-center justify-between py-2 border-t border-gray-100 pt-5">
                    <div>
                        <p class="text-sm font-bold text-gray-800">Yayın Durumu</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">Anasayfada görünsün mü?</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="aktif_mi" value="1" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#326765]"></div>
                    </label>
                </div>
            </div>

            {{-- Kaydet Butonu --}}
            <button type="submit" class="w-full py-4.5 bg-[#326765] hover:bg-[#26504e] text-white rounded-xl text-sm font-bold tracking-[0.1em] uppercase transition-all shadow-lg shadow-[#326765]/30 flex items-center justify-center gap-2 group">
                <i class="fa-solid fa-check text-xs opacity-70 group-hover:scale-125 transition-transform"></i>
                BLOĞU OLUŞTUR
            </button>

        </div>
    </div>
</form>

@endsection