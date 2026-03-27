@extends('layouts.app')

@section('title', 'Hesap Ayarları - Lagomde')

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
            <a href="{{ route('profil.siparisler') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-600 hover:bg-gray-50 transition border-b border-gray-50">
                <i class="fa-solid fa-box w-4"></i> Siparişlerim
            </a>
            <a href="{{ route('profil.siparisler') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-600 hover:bg-gray-50 transition border-b border-gray-50">
                <i class="fa-solid fa-building w-4"></i> Kurumsal Siparişler
            </a>
            <a href="{{ route('profil.favoriler') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-600 hover:bg-gray-50 transition border-b border-gray-50">
                <i class="fa-regular fa-heart w-4"></i> Favorilerim
            </a>
            <a href="{{ route('profil.ayarlar') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-900 bg-gray-50 border-b border-gray-100">
                <i class="fa-regular fa-user w-4"></i> Hesap Ayarları
            </a>
            <form method="POST" action="{{ route('cikis') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-sm text-red-500 hover:bg-red-50 transition">
                    <i class="fa-solid fa-right-from-bracket w-4"></i> Çıkış Yap
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mt-4 text-sm text-gray-500 space-y-3">
            <p class="font-semibold text-gray-700 mb-1">Yardım & Destek</p>
            <div class="flex items-center gap-2"><i class="fa-solid fa-phone text-blue-400"></i><span>0850 000 00 00</span></div>
            <div class="flex items-center gap-2"><i class="fa-brands fa-whatsapp text-green-500"></i><span>WhatsApp'tan Yazın</span></div>
            <div class="flex items-center gap-2"><i class="fa-solid fa-envelope text-blue-400"></i><span>destek@lagomde.com</span></div>
        </div>
    </div>

    {{-- Sağ İçerik --}}
    <div class="flex-1 space-y-6">

        {{-- Kullanıcı Bilgileri --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-lg font-bold text-gray-800 mb-6 pb-4 border-b border-gray-100">Kullanıcı Bilgileri</h2>

            @if(session('success_bilgi'))
            <div class="mb-5 bg-green-50 text-green-600 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success_bilgi') }}
            </div>
            @endif

            <form method="POST" action="{{ route('profil.bilgiler.guncelle') }}">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Ad</label>
                        <input type="text" name="ad" value="{{ old('ad', $kullanici->ad) }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                        @error('ad') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Soyad</label>
                        <input type="text" name="soyad" value="{{ old('soyad', $kullanici->soyad) }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                        @error('soyad') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">E-posta</label>
                    <input type="email" name="eposta" value="{{ old('eposta', $kullanici->eposta) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition">
                    @error('eposta') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="bg-gray-900 text-white rounded-xl px-6 py-3 text-sm font-semibold hover:bg-black transition-all duration-200 tracking-wide">
                    Değişiklikleri Kaydet
                </button>
            </form>
        </div>

        {{-- Şifre Değiştir --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-lg font-bold text-gray-800 mb-6 pb-4 border-b border-gray-100">Şifre Değiştir</h2>

            @if(session('success_sifre'))
            <div class="mb-5 bg-green-50 text-green-600 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success_sifre') }}
            </div>
            @endif

            <form method="POST" action="{{ route('profil.sifre.degistir') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Mevcut Şifre</label>
                    <input type="password" name="mevcut_sifre"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition"
                        placeholder="••••••">
                    @error('mevcut_sifre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Yeni Şifre</label>
                        <input type="password" name="yeni_sifre"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition"
                            placeholder="En az 6 karakter">
                        @error('yeni_sifre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Şifre Tekrar</label>
                        <input type="password" name="yeni_sifre_confirmation"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition"
                            placeholder="Şifreyi tekrar girin">
                    </div>
                </div>
                <button type="submit" class="bg-gray-900 text-white rounded-xl px-6 py-3 text-sm font-semibold hover:bg-black transition-all duration-200 tracking-wide">
                    Şifremi Güncelle
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
