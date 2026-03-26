@extends('admin.layout')

@section('page_title', 'Dashboard')

@section('admin_content')

{{-- SAYFA BAŞLIĞI --}}
<div class="mb-7">
    <h1 class="text-xl font-bold text-gray-900">Hoş Geldiniz, {{ Auth::user()->ad ?? '' }}</h1>
    <p class="text-sm text-gray-400 mt-0.5">{{ now()->locale('tr')->isoFormat('D MMMM YYYY, dddd') }}</p>
</div>

{{-- İSTATİSTİK KARTLARI --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-7">

    <div class="stat-card">
        <div class="flex items-center justify-between mb-5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <span class="text-[11px] font-semibold text-gray-400">Bugün</span>
        </div>
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Sipariş</p>
        <h3 class="text-3xl font-bold text-gray-900">{{ $todayOrders ?? 0 }}</h3>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                <i class="fa-solid fa-turkish-lira-sign"></i>
            </div>
            <span class="text-[11px] font-semibold text-gray-400">Bugün</span>
        </div>
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Kazanç</p>
        <h3 class="text-3xl font-bold text-gray-900">₺{{ number_format($todayRevenue ?? 0, 2, ',', '.') }}</h3>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-5">
            <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-500">
                <i class="fa-solid fa-box"></i>
            </div>
            <span class="text-[11px] font-semibold text-gray-400">Toplam</span>
        </div>
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Aktif Ürün</p>
        <h3 class="text-3xl font-bold text-gray-900">{{ $activeProducts ?? 0 }}</h3>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-5">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-gift"></i>
            </div>
            <span class="text-[11px] font-semibold text-gray-400">Bekliyor</span>
        </div>
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Bekleyen Kutu</p>
        <h3 class="text-3xl font-bold text-gray-900">{{ $pendingBoxes ?? 0 }}</h3>
    </div>

</div>

{{-- ALT BÖLÜM --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- SON SİPARİŞLER --}}
    <div class="xl:col-span-2 card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-800">Son Siparişler</h2>
            <a href="#" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                Tümünü Gör <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="clean w-full">
                <thead>
                    <tr>
                        <th>Sipariş No</th>
                        <th>Müşteri</th>
                        <th>Tutar</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders ?? [] as $order)
                    <tr>
                        <td class="font-semibold text-gray-700">#{{ $order->id }}</td>
                        <td>{{ $order->musteri_adi ?? '-' }}</td>
                        <td class="font-semibold">₺{{ number_format($order->toplam ?? 0, 2, ',', '.') }}</td>
                        <td class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i') }}</td>
                        <td>
                            @if($order->durum === 'tamamlandi')
                                <span class="badge badge-green">Tamamlandı</span>
                            @elseif($order->durum === 'hazirlaniyor')
                                <span class="badge badge-amber">Hazırlanıyor</span>
                            @elseif($order->durum === 'kargoda')
                                <span class="badge badge-blue">Kargoda</span>
                            @elseif($order->durum === 'iptal')
                                <span class="badge badge-red">İptal</span>
                            @else
                                <span class="badge badge-slate">{{ $order->durum }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-10">
                            <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                            Henüz sipariş bulunmuyor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SAĞ PANEL --}}
    <div class="flex flex-col gap-5">

        {{-- STOK UYARILARI --}}
        <div class="card p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-gray-800">Stok Uyarıları</h2>
                @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                    <span class="badge badge-red">{{ $lowStockProducts->count() }} ürün</span>
                @endif
            </div>

            @forelse($lowStockProducts ?? [] as $product)
            <div class="flex items-center gap-3 p-3 rounded-xl mb-2 {{ $product->stok <= 3 ? 'bg-red-50' : 'bg-amber-50' }}">
                <div class="w-8 h-8 rounded-lg {{ $product->stok <= 3 ? 'bg-red-100 text-red-500' : 'bg-amber-100 text-amber-500' }} flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-box-open text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-700 truncate">{{ $product->ad }}</p>
                    <p class="text-[10px] font-medium {{ $product->stok <= 3 ? 'text-red-500' : 'text-amber-600' }}">
                        Stok: {{ $product->stok }} adet kaldı
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-400 py-6">
                <i class="fa-solid fa-circle-check text-green-400 text-2xl mb-2 block"></i>
                <p class="text-xs">Tüm stoklar yeterli.</p>
            </div>
            @endforelse
        </div>

        {{-- HIZLI İŞLEMLER --}}
        <div class="card p-5">
            <h2 class="text-sm font-bold text-gray-800 mb-4">Hızlı İşlemler</h2>
            <div class="grid grid-cols-2 gap-2.5">
                <a href="#" class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-gray-100 hover:border-slate-300 hover:bg-slate-50 transition group text-center">
                    <i class="fa-solid fa-plus text-gray-400 group-hover:text-slate-700 transition text-sm"></i>
                    <span class="text-[11px] font-semibold text-gray-500 group-hover:text-slate-700">Ürün Ekle</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-gray-100 hover:border-slate-300 hover:bg-slate-50 transition group text-center">
                    <i class="fa-solid fa-gift text-gray-400 group-hover:text-slate-700 transition text-sm"></i>
                    <span class="text-[11px] font-semibold text-gray-500 group-hover:text-slate-700">Kutu Tasarla</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-gray-100 hover:border-slate-300 hover:bg-slate-50 transition group text-center">
                    <i class="fa-solid fa-percent text-gray-400 group-hover:text-slate-700 transition text-sm"></i>
                    <span class="text-[11px] font-semibold text-gray-500 group-hover:text-slate-700">Kupon Ekle</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-gray-100 hover:border-slate-300 hover:bg-slate-50 transition group text-center">
                    <i class="fa-solid fa-file-export text-gray-400 group-hover:text-slate-700 transition text-sm"></i>
                    <span class="text-[11px] font-semibold text-gray-500 group-hover:text-slate-700">Rapor Al</span>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection