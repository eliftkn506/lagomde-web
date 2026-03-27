@extends('admin.layout')

@section('page_title', 'Sayfa Yönetimi')

@section('admin_content')

{{-- ÜST BAŞLIK VE EKLE BUTONU --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Sayfa Yönetimi</h1>
        <p class="text-sm text-gray-400 mt-0.5">Sitenizin alt kısmında (footer) yer alan bilgilendirme sayfalarını yönetin.</p>
    </div>
    <a href="{{ route('admin.sayfalar.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold tracking-wide hover:bg-slate-900 transition shadow-lg shadow-slate-200 group">
        <i class="fa-solid fa-plus text-xs group-hover:rotate-90 transition-transform duration-300"></i> YENİ SAYFA EKLE
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

{{-- SAYFALAR TABLOSU --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="clean w-full">
            <thead>
                <tr>
                    <th class="w-12 text-center">ID</th>
                    <th>Sayfa Başlığı</th>
                    <th>Footer Konumu</th>
                    <th class="text-center">Sıra</th>
                    <th class="text-center">Durum</th>
                    <th class="text-right pr-8">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sayfalar as $sayfa)
                <tr>
                    <td class="text-center text-gray-400 font-semibold">{{ $sayfa->id }}</td>
                    
                    {{-- Başlık ve Link --}}
                    <td>
                        <p class="font-bold text-gray-800 mb-0.5">{{ $sayfa->baslik }}</p>
                        <a href="{{ route('sayfa.goster', $sayfa->slug) }}" target="_blank" class="text-[11px] font-medium text-blue-500 hover:text-blue-700 hover:underline flex items-center gap-1 w-max transition">
                            lagomde.com/s/{{ $sayfa->slug }} <i class="fa-solid fa-arrow-up-right-from-square text-[9px] mb-0.5"></i>
                        </a>
                    </td>
                    
                    {{-- Konum Rozetleri --}}
                    <td>
                        @if($sayfa->footer_konum == 'kurumsal')
                            <span class="badge badge-blue"><i class="fa-regular fa-building mr-1.5"></i> Kurumsal</span>
                        @elseif($sayfa->footer_konum == 'yardim')
                            <span class="badge badge-amber"><i class="fa-regular fa-circle-question mr-1.5"></i> Yardım</span>
                        @elseif($sayfa->footer_konum == 'sozlesmeler')
                            <span class="badge badge-slate"><i class="fa-regular fa-file-lines mr-1.5"></i> Sözleşmeler</span>
                        @else
                            <span class="badge badge-slate">{{ $sayfa->footer_konum }}</span>
                        @endif
                    </td>
                    
                    {{-- Sıra --}}
                    <td class="text-center font-bold text-gray-600">
                        {{ $sayfa->sira }}
                    </td>
                    
                    {{-- Aktif/Pasif Durumu --}}
                    <td class="text-center">
                        @if($sayfa->aktif_mi)
                            <span class="badge badge-green">Aktif</span>
                        @else
                            <span class="badge badge-red">Pasif</span>
                        @endif
                    </td>
                    
                    {{-- İşlem Butonları --}}
                    <td class="text-right pr-6">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Düzenle Butonu (Route tanımlanacak) --}}
                            <a href="{{ route('admin.sayfalar.edit', $sayfa->id) }}" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 text-slate-500 hover:text-slate-800 hover:border-slate-300 flex items-center justify-center transition" title="Düzenle">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            
                            {{-- Sil Butonu --}}
                            <form action="{{ route('admin.sayfalar.destroy', $sayfa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ $sayfa->baslik }} sayfasını silmek istediğinize emin misiniz? Bu işlem geri alınamaz.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 border border-red-100 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition" title="Sil">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                {{-- Boş Durum (Veri Yoksa) --}}
                <tr>
                    <td colspan="6" class="text-center py-16">
                        <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-300">
                            <i class="fa-regular fa-file-lines text-2xl"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">Henüz Sayfa Eklenmemiş</h3>
                        <p class="text-xs text-gray-400 mb-5">Sitenizin alt kısmı için ilk bilgilendirme sayfanızı oluşturun.</p>
                        <a href="{{ route('admin.sayfalar.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition shadow-sm">
                            <i class="fa-solid fa-plus text-slate-400"></i> İlk Sayfayı Ekle
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection