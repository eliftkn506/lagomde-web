@extends('admin.layout')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Mağazanızın bugünkü özeti')

@section('admin_content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    <div class="stat-card">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                <i class="fa-solid fa-bag-shopping text-lg"></i>
            </div>
            <span class="badge bg-green-50 text-green-600">
                <i class="fa-solid fa-arrow-trend-up mr-1 text-[10px]"></i>+12%
            </span>
        </div>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Bugünkü Sipariş</p>
        <h3 class="text-3xl font-bold text-slate-800">12</h3>
        <p class="text-[11px] text-slate-400 mt-1">Dün: 10 sipariş</p>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                <i class="fa-solid fa-turkish-lira-sign text-lg"></i>
            </div>
            <span class="badge bg-green-50 text-green-600">
                <i class="fa-solid fa-arrow-trend-up mr-1 text-[10px]"></i>+8%
            </span>
        </div>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Günlük Kazanç</p>
        <h3 class="text-3xl font-bold text-slate-800">₺4.250</h3>
        <p class="text-[11px] text-slate-400 mt-1">Dün: ₺3.930</p>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-violet-50 flex items-center justify-center text-violet-500">
                <i class="fa-solid fa-box text-lg"></i>
            </div>
            <span class="badge bg-slate-100 text-slate-500">
                Aktif
            </span>
        </div>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Aktif Ürünler</p>
        <h3 class="text-3xl font-bold text-slate-800">452</h3>
        <p class="text-[11px] text-slate-400 mt-1">3 ürün stok dışı</p>
    </div>

    <div class="stat-card">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-gift text-lg"></i>
            </div>
            <span class="badge bg-red-50 text-red-500">
                <i class="fa-solid fa-clock mr-1 text-[10px]"></i>Bekliyor
            </span>
        </div>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Bekleyen Kutu</p>
        <h3 class="text-3xl font-bold text-slate-800">5</h3>
        <p class="text-[11px] text-slate-400 mt-1">En eskisi 2 gün önce</p>
    </div>

</div>

{{-- ALT BÖLÜM --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- Son Siparişler --}}
    <div class="xl:col-span-2 bg-white border border-[#ede9e3] rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#f1ede8]">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Son Siparişler</h2>
                <p class="text-[11px] text-slate-400">Bugün gelen son 5 sipariş</p>
            </div>
            <a href="#" class="text-[11px] font-semibold text-amber-600 hover:text-amber-700 transition">
                Tümünü Gör <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
            </a>
        </div>
        <table class="data-table w-full">
            <thead>
                <tr>
                    <th class="text-left">Sipariş No</th>
                    <th class="text-left">Müşteri</th>
                    <th class="text-left">Ürün</th>
                    <th class="text-left">Tutar</th>
                    <th class="text-left">Durum</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-semibold text-slate-700">#10042</td>
                    <td>Ayşe Kaya</td>
                    <td class="text-slate-500">Özel Kutu x2</td>
                    <td class="font-semibold">₺480</td>
                    <td><span class="badge bg-green-50 text-green-600">Tamamlandı</span></td>
                </tr>
                <tr>
                    <td class="font-semibold text-slate-700">#10041</td>
                    <td>Mehmet Yılmaz</td>
                    <td class="text-slate-500">Hediyelik Set x1</td>
                    <td class="font-semibold">₺320</td>
                    <td><span class="badge bg-amber-50 text-amber-600">Hazırlanıyor</span></td>
                </tr>
                <tr>
                    <td class="font-semibold text-slate-700">#10040</td>
                    <td>Fatma Demir</td>
                    <td class="text-slate-500">Mini Kutu x3</td>
                    <td class="font-semibold">₺750</td>
                    <td><span class="badge bg-blue-50 text-blue-600">Kargoda</span></td>
                </tr>
                <tr>
                    <td class="font-semibold text-slate-700">#10039</td>
                    <td>Ali Çelik</td>
                    <td class="text-slate-500">Doğum Günü x1</td>
                    <td class="font-semibold">₺210</td>
                    <td><span class="badge bg-green-50 text-green-600">Tamamlandı</span></td>
                </tr>
                <tr>
                    <td class="font-semibold text-slate-700">#10038</td>
                    <td>Zeynep Arslan</td>
                    <td class="text-slate-500">Özel Kutu x1</td>
                    <td class="font-semibold">₺290</td>
                    <td><span class="badge bg-red-50 text-red-500">İptal</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Sağ Panel --}}
    <div class="flex flex-col gap-5">

        {{-- Hızlı İşlemler --}}
        <div class="bg-white border border-[#ede9e3] rounded-2xl p-5">
            <h2 class="text-sm font-bold text-slate-800 mb-4">Hızlı İşlemler</h2>
            <div class="grid grid-cols-2 gap-3">
                <a href="#" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-slate-50 hover:bg-amber-50 hover:border-amber-200 border border-transparent transition group text-center">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 group-hover:border-amber-300 group-hover:bg-amber-50 flex items-center justify-center text-slate-500 group-hover:text-amber-600 transition">
                        <i class="fa-solid fa-plus text-sm"></i>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-600 group-hover:text-amber-700">Ürün Ekle</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-slate-50 hover:bg-amber-50 hover:border-amber-200 border border-transparent transition group text-center">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 group-hover:border-amber-300 group-hover:bg-amber-50 flex items-center justify-center text-slate-500 group-hover:text-amber-600 transition">
                        <i class="fa-solid fa-gift text-sm"></i>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-600 group-hover:text-amber-700">Kutu Tasarla</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-slate-50 hover:bg-amber-50 hover:border-amber-200 border border-transparent transition group text-center">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 group-hover:border-amber-300 group-hover:bg-amber-50 flex items-center justify-center text-slate-500 group-hover:text-amber-600 transition">
                        <i class="fa-solid fa-percent text-sm"></i>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-600 group-hover:text-amber-700">Kupon Ekle</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-slate-50 hover:bg-amber-50 hover:border-amber-200 border border-transparent transition group text-center">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 group-hover:border-amber-300 group-hover:bg-amber-50 flex items-center justify-center text-slate-500 group-hover:text-amber-600 transition">
                        <i class="fa-solid fa-chart-bar text-sm"></i>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-600 group-hover:text-amber-700">Rapor Al</span>
                </a>
            </div>
        </div>

        {{-- Stok Uyarıları --}}
        <div class="bg-white border border-[#ede9e3] rounded-2xl p-5 flex-1">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800">Stok Uyarıları</h2>
                <span class="badge bg-red-50 text-red-500">3 ürün</span>
            </div>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                        <i class="fa-solid fa-box-open text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-slate-700 truncate">Ahşap Hediye Kutusu</p>
                        <p class="text-[10px] text-red-500 font-medium">Stok: 2 adet kaldı</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-xl">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-500 flex-shrink-0">
                        <i class="fa-solid fa-box-open text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-slate-700 truncate">Mini Sürpriz Set</p>
                        <p class="text-[10px] text-amber-600 font-medium">Stok: 5 adet kaldı</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-xl">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-500 flex-shrink-0">
                        <i class="fa-solid fa-box-open text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-slate-700 truncate">Doğum Günü Paketi</p>
                        <p class="text-[10px] text-amber-600 font-medium">Stok: 7 adet kaldı</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection