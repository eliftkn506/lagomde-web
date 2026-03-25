<header class="bg-white py-4 shadow-sm sticky top-0 z-50">
    <div class="max-w-[90rem] mx-auto px-6 flex justify-between items-center">
        
        <a href="/" class="flex items-center group mr-8">
            {{-- Yükseklik h-16/20'den h-24/28 seviyesine çıkarıldı --}}
            <img src="{{ asset('logo.png') }}" alt="Lagomde Logo" class="h-20 md:h-28 w-auto transition-transform duration-300 group-hover:scale-105 object-contain">
        </a>

        <div class="flex-1 max-w-3xl mx-4">
            <div class="relative">
                <input type="text" placeholder="Hediye Ara" class="w-full bg-blue-50/50 text-gray-700 rounded-full py-2.5 px-6 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all">
                <i class="fa-solid fa-search absolute left-4 top-3 text-gray-400"></i>
            </div>
        </div>

        <div class="flex items-center space-x-6 text-gray-700 ml-4">
            <a href="#" class="flex items-center space-x-2 border border-gray-200 rounded-full px-4 py-2 hover:bg-gray-50 transition">
                <span class="text-sm font-medium hidden lg:block">Sipariş Takibi</span>
                <i class="fa-solid fa-box-open"></i>
            </a>
            <a href="#" class="hover:text-blue-600 transition" title="Destek"><i class="fa-solid fa-headset text-xl"></i></a>
            <a href="#" class="hover:text-blue-600 transition" title="Hesabım"><i class="fa-regular fa-user text-xl"></i></a>
            <a href="#" class="hover:text-blue-600 transition relative" title="Sepetim">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center">0</span>
            </a>
        </div>
    </div>
</header>

<nav class="bg-white border-b border-gray-100">
    <div class="max-w-[90rem] mx-auto px-6">
        <ul class="flex justify-center items-center space-x-4 lg:space-x-6 xl:space-x-8 py-3 text-sm font-medium text-gray-700">
            <li><a href="#" class="hover:text-blue-600 transition whitespace-nowrap">Kurumsal Hediye</a></li>
            <li><a href="#" class="hover:text-blue-600 transition whitespace-nowrap">Sevgiliye Hediye</a></li>
            <li><a href="#" class="hover:text-blue-600 transition whitespace-nowrap">Doğum Günü Hediyeleri</a></li>
            <li><a href="#" class="hover:text-blue-600 transition whitespace-nowrap">Hediye Gönder</a></li>
            <li><a href="#" class="text-yellow-600 border border-yellow-400 rounded-full px-4 py-1.5 hover:bg-yellow-50 transition font-semibold whitespace-nowrap">Kendi Kutunu Yap</a></li>
            <li><a href="#" class="hover:text-blue-600 transition whitespace-nowrap">Hediye Kutusu</a></li>
            <li><a href="#" class="hover:text-blue-600 transition whitespace-nowrap">Çiçek</a></li>
            <li><a href="#" class="hover:text-blue-600 transition whitespace-nowrap">Fotoğraf Baskı</a></li>
            <li><a href="#" class="hover:text-blue-600 transition whitespace-nowrap">Deneyim & Aktivite</a></li>
        </ul>
    </div>
</nav>

<div class="bg-white py-3 border-b border-gray-100 shadow-sm hidden md:block">
    <div class="max-w-[80rem] mx-auto px-6 flex justify-between items-center text-sm font-medium text-blue-900">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-truck-fast text-lg text-blue-500"></i>
            <span>Hızlı Gönderim</span>
        </div>
        <div class="flex items-center space-x-2">
            <span>1.000.000+ Mutlu Kişi</span>
            <div class="text-green-500 text-xs">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-box-archive text-lg text-blue-500"></i>
            <span>Koşulsuz İade</span>
        </div>
    </div>
</div>