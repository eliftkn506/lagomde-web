<div id="authModal"
    class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative">

        {{-- Kapat --}}
        <button onclick="closeAuthModal()"
            class="absolute top-4 right-4 text-gray-300 hover:text-gray-500 transition z-10">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        {{-- Üst --}}
        <div class="px-8 pt-8 pb-4 text-center">
            <img src="{{ asset('logo.png') }}" alt="Lagomde" class="h-12 mx-auto mb-2 object-contain">
            <p class="text-gray-400 text-sm">Hediye dünyasına hoş geldiniz 🎁</p>
        </div>

        {{-- Tabs --}}
        <div class="flex border-b border-gray-100 mx-8 mb-6">
            <button id="tab-giris" onclick="switchTab('giris')"
                class="flex-1 pb-3 text-sm font-semibold text-blue-600 border-b-2 border-blue-500 transition">
                Giriş Yap
            </button>
            <button id="tab-kayit" onclick="switchTab('kayit')"
                class="flex-1 pb-3 text-sm text-gray-400 border-b-2 border-transparent transition">
                Üye Ol
            </button>
        </div>

        {{-- Flash / Validation hataları --}}
        @if ($errors->any())
        <div class="mx-8 mb-4 bg-red-50 text-red-500 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ $errors->first() }}
        </div>
        @endif

        @if (session('success'))
        <div class="mx-8 mb-4 bg-green-50 text-green-600 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
        @endif

        {{-- GİRİŞ FORMU --}}
        <div id="form-giris" class="px-8 pb-8">
            <form method="POST" action="{{ route('giris') }}">
                @csrf
                <input type="hidden" name="_form" value="giris">

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">E-posta</label>
                    <input type="email" name="eposta" value="{{ old('eposta') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition"
                        placeholder="ornek@mail.com">
                </div>

                <div class="mb-3">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Şifre</label>
                    <input type="password" name="sifre"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition"
                        placeholder="••••••">
                </div>

                <div class="flex items-center justify-between mb-6 text-xs text-gray-400">
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input type="checkbox" name="beni_hatirla" class="rounded text-blue-500">
                        Beni hatırla
                    </label>
                    <a href="#" class="text-blue-500 hover:underline">Şifremi unuttum</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white rounded-xl py-3 text-sm font-semibold hover:bg-blue-700 transition">
                    Giriş Yap
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-5">
                Hesabın yok mu?
                <button onclick="switchTab('kayit')" class="text-blue-500 font-medium hover:underline">Üye ol</button>
            </p>
        </div>

        {{-- KAYIT FORMU --}}
        <div id="form-kayit" class="px-8 pb-8 hidden">
            <form method="POST" action="{{ route('kayit') }}">
                @csrf
                <input type="hidden" name="_form" value="kayit">

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Ad</label>
                        <input type="text" name="ad" value="{{ old('ad') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
                            placeholder="Adınız">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Soyad</label>
                        <input type="text" name="soyad" value="{{ old('soyad') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
                            placeholder="Soyadınız">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">E-posta</label>
                    <input type="email" name="eposta" value="{{ old('eposta') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
                        placeholder="ornek@mail.com">
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Şifre</label>
                    <input type="password" name="sifre"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
                        placeholder="En az 6 karakter">
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Şifre Tekrar</label>
                    <input type="password" name="sifre_confirmation"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
                        placeholder="Şifreyi tekrar girin">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white rounded-xl py-3 text-sm font-semibold hover:bg-blue-700 transition">
                    Üye Ol
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-5">
                Zaten hesabın var mı?
                <button onclick="switchTab('giris')" class="text-blue-500 font-medium hover:underline">Giriş yap</button>
            </p>
        </div>

    </div>
</div>

<script>
function openAuthModal(tab = 'giris') {
    document.getElementById('authModal').classList.remove('hidden');
    switchTab(tab);
}

function closeAuthModal() {
    document.getElementById('authModal').classList.add('hidden');
}

function switchTab(tab) {
    // Form göster/gizle
    document.getElementById('form-giris').classList.toggle('hidden', tab !== 'giris');
    document.getElementById('form-kayit').classList.toggle('hidden', tab !== 'kayit');

    // Tab stilleri
    const girisTab = document.getElementById('tab-giris');
    const kayitTab = document.getElementById('tab-kayit');

    if (tab === 'giris') {
        girisTab.className = 'flex-1 pb-3 text-sm font-semibold text-blue-600 border-b-2 border-blue-500 transition';
        kayitTab.className = 'flex-1 pb-3 text-sm text-gray-400 border-b-2 border-transparent transition';
    } else {
        kayitTab.className = 'flex-1 pb-3 text-sm font-semibold text-blue-600 border-b-2 border-blue-500 transition';
        girisTab.className = 'flex-1 pb-3 text-sm text-gray-400 border-b-2 border-transparent transition';
    }
}

// Hata varsa otomatik aç
@if ($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        const form = '{{ old('_form', 'giris') }}';
        openAuthModal(form);
    });
@endif

// Modal dışına tıklayınca kapat
document.getElementById('authModal').addEventListener('click', function(e) {
    if (e.target === this) closeAuthModal();
});
</script>
