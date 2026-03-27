@extends('layouts.app')

@section('title', 'Profilim - Lagomde')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10 flex gap-8">

    {{-- Sol Sidebar --}}
    <div class="w-64 shrink-0">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4 text-center">
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl font-bold mx-auto mb-3">
                {{ strtoupper(substr(Auth::user()->ad, 0, 1)) }}
            </div>
            <p class="font-semibold text-gray-800">{{ Auth::user()->ad }} {{ Auth::user()->soyad }}</p>
            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->eposta }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <a href="{{ route('profil.siparisler') }}"
                class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition border-b border-gray-50">
                <i class="fa-solid fa-box w-4"></i> Siparişlerim
            </a>
            <a href="{{ route('profil.siparisler') }}"
                class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition border-b border-gray-50">
                <i class="fa-solid fa-building w-4"></i> Kurumsal Siparişler
            </a>
            <a href="{{ route('profil.favoriler') }}"
                class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition border-b border-gray-50">
                <i class="fa-regular fa-heart w-4"></i> Favorilerim
            </a>
            <a href="{{ route('profil.ayarlar') }}"
                class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition border-b border-gray-50">
                <i class="fa-regular fa-user w-4"></i> Hesap Ayarları
            </a>
            <form method="POST" action="{{ route('cikis') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-5 py-3.5 text-sm text-red-500 hover:bg-red-50 transition">
                    <i class="fa-solid fa-right-from-bracket w-4"></i> Çıkış Yap
                </button>
            </form>
        </div>

        {{-- Yardım & Destek --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mt-4 text-sm text-gray-500 space-y-3">
            <p class="font-semibold text-gray-700 mb-1">Yardım & Destek</p>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-phone text-blue-400"></i>
                <span>0850 000 00 00</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-green-500"></i>
                <span>WhatsApp'tan Yazın</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-envelope text-blue-400"></i>
                <span>destek@lagomde.com</span>
            </div>
        </div>
    </div>

    {{-- Sağ İçerik --}}
    <div class="flex-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h1 class="text-xl font-bold text-gray-800 mb-6">Siparişler</h1>

            {{-- Sipariş yok --}}
            <div class="text-center py-16 text-gray-300">
                <i class="fa-solid fa-box-open text-5xl mb-4"></i>
                <p class="text-gray-400 text-sm mb-6">Oluşturulan herhangi bir sipariş yok.</p>
                <a href="{{ route('home') }}"
                    class="bg-blue-600 text-white rounded-xl px-6 py-3 text-sm font-semibold hover:bg-blue-700 transition">
                    Ürünleri İncele
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
