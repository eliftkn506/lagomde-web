<footer class="bg-white border-t mt-20 relative" style="border-color: var(--border);">
    
    {{-- Üst Bülten (Newsletter) Alanı --}}
    <div class="border-b" style="border-color: var(--border); background: #fbfbfb;">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10 py-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                <div class="hidden md:flex w-16 h-16 rounded-full bg-[#EAF1F1] items-center justify-center text-[#326765]">
                    <i class="fa-regular fa-envelope-open text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-display text-2xl lg:text-3xl font-bold mb-1 text-gray-900">Özel İndirimleri Kaçırmayın</h3>
                    <p class="text-sm text-gray-500">Yeni hediye kutuları ve kampanyalardan ilk siz haberdar olun.</p>
                </div>
            </div>
            <div class="w-full md:w-auto flex items-center relative max-w-md flex-1">
                <input type="email" placeholder="E-posta adresiniz" class="w-full px-6 py-4 rounded-full text-sm outline-none border border-gray-200 transition-all focus:border-[#326765] focus:ring-4 focus:ring-[#EAF1F1] text-gray-800 placeholder-gray-400">
                <button class="absolute right-1.5 top-1.5 bottom-1.5 px-7 rounded-full text-white text-xs font-bold tracking-wider uppercase transition-all duration-300 hover:shadow-lg hover:scale-[1.02] active:scale-95" style="background: #326765;">
                    Abone Ol
                </button>
            </div>
        </div>
    </div>

    {{-- Ana Footer Grid --}}
    <div class="max-w-[1440px] mx-auto px-6 lg:px-10 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-14 lg:gap-8">

            {{-- Sütun 1: Logo & Hakkımızda --}}
            <div class="lg:col-span-4 lg:pr-12">
                <img src="{{ asset('logo.svg') }}" alt="Lagomde" class="h-24 md:h-32 w-auto mb-8 object-contain origin-left transition-transform hover:scale-[1.02] duration-500">
                
                <p class="text-[14px] leading-relaxed mb-8 text-gray-500 font-medium">
                    Sevdiklerinize sıradan bir hediye değil, özenle tasarlanmış anılar armağan edin. Lagomde ile her an, her duygu için anlamlı bir kutu var.
                </p>
                
                <div class="flex items-center gap-3">
                    @foreach([['fa-instagram','#'],['fa-facebook-f','#'],['fa-tiktok','#'],['fa-pinterest-p','#']] as [$icon, $url])
                        <a href="{{ $url }}" class="w-10 h-10 rounded-full flex items-center justify-center border border-gray-200 text-gray-500 transition-all duration-300 hover:-translate-y-1 hover:border-[#326765] hover:bg-[#326765] hover:text-white hover:shadow-md">
                            <i class="fa-brands {{ $icon }} text-base"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Sütun 2: Kurumsal (Dinamik) --}}
            <div class="lg:col-span-2 lg:pt-5">
                <p class="text-[12px] font-extrabold uppercase tracking-[0.15em] mb-8 text-gray-900">Kurumsal</p>
                <ul class="space-y-4">
                    @forelse($footerKurumsal as $sayfa)
                    <li>
                        <a href="{{ route('sayfa.goster', $sayfa->slug) }}" class="group flex items-center text-[14px] text-gray-500 transition-all font-medium">
                            <span class="w-0 overflow-hidden group-hover:w-4 transition-all duration-300 ease-out text-[#326765] flex items-center">
                                <i class="fa-solid fa-angle-right text-[11px]"></i>
                            </span>
                            <span class="group-hover:text-[#326765] group-hover:translate-x-1 transition-transform duration-300">{{ $sayfa->baslik }}</span>
                        </a>
                    </li>
                    @empty
                    <li><span class="text-sm text-gray-400">İçerik bekleniyor...</span></li>
                    @endforelse
                </ul>
            </div>

            {{-- Sütun 3: Müşteri Hizmetleri (Dinamik) --}}
            <div class="lg:col-span-3 lg:pt-5">
                <p class="text-[12px] font-extrabold uppercase tracking-[0.15em] mb-8 text-gray-900">Müşteri Hizmetleri</p>
                <ul class="space-y-4">
                    @forelse($footerYardim as $sayfa)
                    <li>
                        <a href="{{ route('sayfa.goster', $sayfa->slug) }}" class="group flex items-center text-[14px] text-gray-500 transition-all font-medium">
                            <span class="w-0 overflow-hidden group-hover:w-4 transition-all duration-300 ease-out text-[#326765] flex items-center">
                                <i class="fa-solid fa-angle-right text-[11px]"></i>
                            </span>
                            <span class="group-hover:text-[#326765] group-hover:translate-x-1 transition-transform duration-300">{{ $sayfa->baslik }}</span>
                        </a>
                    </li>
                    @empty
                    <li><span class="text-sm text-gray-400">İçerik bekleniyor...</span></li>
                    @endforelse
                </ul>
            </div>

            {{-- Sütun 4: İletişim --}}
            <div class="lg:col-span-3 lg:pt-5">
                <p class="text-[12px] font-extrabold uppercase tracking-[0.15em] mb-8 text-gray-900">Bize Ulaşın</p>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0 bg-[#EAF1F1] text-[#326765] transition-transform hover:scale-110 duration-300">
                            <i class="fa-solid fa-headset text-lg"></i>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-[15px] font-bold text-gray-900">0850 000 00 00</p>
                            <p class="text-xs mt-1 text-gray-500">Hafta içi: 09:00 - 18:00</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0 bg-[#E8F5E9] text-green-600 transition-transform hover:scale-110 duration-300">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </div>
                        <div class="pt-0.5">
                            <a href="#" class="text-[15px] font-bold text-gray-900 transition-colors hover:text-green-600 inline-block">WhatsApp Destek</a>
                            <p class="text-xs mt-1 text-gray-500">Hızlı yanıt hattı</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0 bg-[#EAF1F1] text-[#326765] transition-transform hover:scale-110 duration-300">
                            <i class="fa-regular fa-envelope text-lg"></i>
                        </div>
                        <div class="flex items-center h-11 pt-0.5">
                            <a href="mailto:destek@lagomde.com" class="text-[15px] font-bold text-gray-900 transition-colors hover:text-[#326765]">destek@lagomde.com</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════ ALT BANT (Sözleşmeler & Rozetler) ═══════════════ --}}
    <div class="border-t border-gray-200 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10 py-7 flex flex-col lg:flex-row items-center justify-between gap-6">
            
            <p class="text-[13px] font-medium text-gray-500">
                &copy; {{ date('Y') }} Lagomde. Tüm hakları saklıdır.
            </p>

            {{-- Dinamik Sözleşmeler --}}
            <div class="flex flex-wrap justify-center gap-5 md:gap-8 text-[13px] font-medium">
                @foreach($footerSozlesmeler as $sayfa)
                    <a href="{{ route('sayfa.goster', $sayfa->slug) }}" class="text-gray-500 transition-colors hover:text-[#326765]">
                        {{ $sayfa->baslik }}
                    </a>
                @endforeach
            </div>

            {{-- Kredi Kartı Logoları --}}
            <div class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                <i class="fa-brands fa-cc-visa text-3xl text-blue-800"></i>
                <i class="fa-brands fa-cc-mastercard text-3xl text-red-600"></i>
                <i class="fa-brands fa-cc-amex text-3xl text-blue-500"></i>
                <div class="flex items-center gap-2 ml-2 pl-3 border-l border-gray-300">
                    <i class="fa-solid fa-shield-halved text-green-600 text-lg"></i>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-green-700">256-BİT SSL</span>
                </div>
            </div>

        </div>
    </div>
</footer>