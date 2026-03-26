<footer class="bg-gray-50 border-t border-gray-200 mt-16">

    <div class="max-w-[90rem] mx-auto px-6 py-12">

        {{-- Ana Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10">

            {{-- Logo & Açıklama --}}
            <div class="col-span-2 md:col-span-1">
                <img src="{{ asset('logo.png') }}" alt="Lagomde" class="h-12 w-auto mb-4 object-contain">
                <p class="text-gray-400 text-sm leading-relaxed">
                    Anlamlı hediyeler, <br>mutlu anlar.
                </p>
                <div class="flex items-center gap-3 mt-5">
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition"><i class="fa-brands fa-instagram text-lg"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition"><i class="fa-brands fa-facebook-f text-lg"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition"><i class="fa-brands fa-tiktok text-lg"></i></a>
                </div>
            </div>

            {{-- Alışveriş --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-800 mb-4">Alışveriş</p>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-blue-600 transition">Kurumsal Hediye</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Sevgiliye Hediye</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Doğum Günü</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Hediye Kutusu</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Çiçek & Fotoğraf</a></li>
                </ul>
            </div>

            {{-- Yardım --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-800 mb-4">Yardım</p>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-blue-600 transition">Sipariş Takibi</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">İade & Değişim</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">S.S.S.</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Canlı Destek</a></li>
                </ul>
            </div>

            {{-- İletişim --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-800 mb-4">İletişim</p>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-phone w-4 text-blue-400"></i> 0850 000 00 00</li>
                    <li class="flex items-center gap-2"><i class="fa-brands fa-whatsapp w-4 text-green-500"></i> WhatsApp</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-envelope w-4 text-blue-400"></i> destek@lagomde.com</li>
                </ul>
            </div>

        </div>

        {{-- Alt çizgi --}}
        <div class="border-t border-gray-200 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-gray-400">
            <p>© {{ date('Y') }} Lagomde. Tüm hakları saklıdır.</p>
            <div class="flex items-center gap-5">
                <a href="#" class="hover:text-gray-600 transition">Gizlilik Politikası</a>
                <a href="#" class="hover:text-gray-600 transition">Kullanım Koşulları</a>
                <a href="#" class="hover:text-gray-600 transition">KVKK</a>
            </div>
        </div>

    </div>

</footer>
