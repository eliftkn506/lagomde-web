@extends('admin.layout')

@section('page_title', 'Sayfayı Düzenle')

@section('admin_content')

{{-- ÜST BAŞLIK VE GERİ BUTONU --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Sayfayı Düzenle</h1>
        <p class="text-sm text-gray-400 mt-0.5">"{{ $sayfa->baslik }}" sayfasının içeriğini ve ayarlarını güncelliyorsunuz.</p>
    </div>
    <a href="{{ route('admin.sayfalar.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
        <i class="fa-solid fa-arrow-left text-xs"></i> Vazgeç ve Geri Dön
    </a>
</div>

{{-- HATA MESAJLARI --}}
@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3">
    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
    <div>
        <h3 class="text-sm font-bold text-red-800 mb-1">Lütfen aşağıdaki hataları düzeltin:</h3>
        <ul class="text-xs text-red-600 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- FORM ALANI --}}
<form action="{{ route('admin.sayfalar.update', $sayfa->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- SOL PANEL: ANA İÇERİK --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6 md:p-8">
                
                {{-- Başlık --}}
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2" for="baslik">
                        Sayfa Başlığı <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="baslik" name="baslik" value="{{ old('baslik', $sayfa->baslik) }}" required
                           placeholder="Örn: Biz Kimiz?, İade Koşulları"
                           class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-800 focus:border-slate-800 focus:bg-white outline-none transition-all text-sm font-semibold text-gray-800 placeholder:text-gray-400">
                </div>

                {{-- İçerik (CKEditor) --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2" for="icerik">
                        Sayfa İçeriği <span class="text-red-500">*</span>
                    </label>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <textarea id="icerik" name="icerik">{{ old('icerik', $sayfa->icerik) }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        {{-- SAĞ PANEL: AYARLAR --}}
        <div class="space-y-6">
            
            <div class="card p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-5 border-b border-gray-100 pb-3">Yayın Ayarları</h3>

                {{-- Konum --}}
                <div class="mb-5">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2" for="footer_konum">
                        Footer Konumu <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="footer_konum" name="footer_konum" required
                                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-800 focus:border-slate-800 focus:bg-white outline-none transition-all text-sm font-semibold text-gray-800 appearance-none cursor-pointer">
                            <option value="kurumsal" {{ old('footer_konum', $sayfa->footer_konum) == 'kurumsal' ? 'selected' : '' }}>Kurumsal</option>
                            <option value="yardim" {{ old('footer_konum', $sayfa->footer_konum) == 'yardim' ? 'selected' : '' }}>Yardım</option>
                            <option value="sozlesmeler" {{ old('footer_konum', $sayfa->footer_konum) == 'sozlesmeler' ? 'selected' : '' }}>Sözleşmeler & Politikalar</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                {{-- Sıra --}}
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2" for="sira">
                        Menü Sırası
                    </label>
                    <input type="number" id="sira" name="sira" value="{{ old('sira', $sayfa->sira) }}" min="0"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-800 focus:border-slate-800 focus:bg-white outline-none transition-all text-sm font-semibold text-gray-800">
                </div>

                {{-- Aktif/Pasif Toggle --}}
                <div class="flex items-center justify-between py-2 border-t border-gray-100 pt-5">
                    <div>
                        <p class="text-sm font-bold text-gray-800">Sayfa Durumu</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="aktif_mi" value="1" class="sr-only peer" {{ old('aktif_mi', $sayfa->aktif_mi) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-800"></div>
                    </label>
                </div>
            </div>

            {{-- Güncelle Butonu --}}
            <button type="submit" class="w-full py-4 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold tracking-wide transition shadow-lg flex items-center justify-center gap-2 group">
                <i class="fa-solid fa-rotate text-xs opacity-70 group-hover:rotate-180 transition-transform duration-500"></i>
                DEĞİŞİKLİKLERİ GÜNCELLE
            </button>

        </div>
    </div>
</form>

{{-- CKEditor CDN ve Başlatma --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
            .create(document.querySelector('#icerik'), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ],
            })
            .then(editor => {
                editor.ui.view.editable.element.style.minHeight = '300px';
                editor.ui.view.editable.element.style.fontSize = '14px';
                editor.ui.view.editable.element.style.color = '#374151';
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>

@endsection