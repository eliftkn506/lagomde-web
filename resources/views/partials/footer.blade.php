<footer style="background: var(--ink, #16120E);" class="relative mt-24 overflow-hidden">

    {{-- Decorative top glow --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[1px]"
         style="background: linear-gradient(90deg, transparent, rgba(46,112,109,0.5), rgba(200,132,90,0.4), transparent);"></div>

    {{-- ═══ NEWSLETTER SECTION ═══ --}}
    <div class="border-b" style="border-color: rgba(255,255,255,0.07);">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10 py-16">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-10">
                
                {{-- Left text --}}
                <div class="text-center lg:text-left max-w-lg">
                    <p class="text-[11px] font-bold tracking-[0.2em] uppercase mb-3" style="color: var(--copper, #C8845A);">
                        Bültenimize Katılın
                    </p>
                    <h3 class="font-display text-3xl lg:text-4xl font-bold text-white leading-tight mb-3">
                        Özel İndirimleri İlk Siz Öğrenin
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: rgba(255,255,255,0.45);">
                        Yeni koleksiyonlar, sezonluk kampanyalar ve sürpriz indirimler için e-posta listemize katılın.
                    </p>
                </div>

                {{-- Subscribe form --}}
                <div class="w-full lg:w-auto flex-shrink-0 lg:min-w-[420px]">
                    <div class="flex items-center p-2 rounded-2xl" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);">
                        <input
                            type="email"
                            placeholder="E-posta adresinizi girin"
                            class="flex-1 bg-transparent outline-none text-sm font-medium text-white placeholder-white/30 px-4 py-3"
                        >
                        <button
                            class="flex-shrink-0 px-7 py-3.5 rounded-xl text-white text-[12px] font-bold tracking-wider uppercase transition-all duration-300 hover:scale-[1.03] hover:shadow-lg active:scale-95"
                            style="background: var(--teal, #2E706D); box-shadow: 0 4px 20px rgba(46,112,109,0.35);"
                        >
                            Abone Ol
                        </button>
                    </div>
                    <p class="text-[11px] mt-3 text-center lg:text-left" style="color: rgba(255,255,255,0.25);">
                        Spam yok, istediğiniz zaman çıkabilirsiniz.
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- ═══ MAIN FOOTER GRID ═══ --}}
    <div class="max-w-[1440px] mx-auto px-6 lg:px-10 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">

            {{-- Col 1: Brand --}}
            <div class="lg:col-span-4 lg:pr-10">
                <img src="{{ asset('logo.svg') }}" alt="Lagomde" class="h-16 w-auto mb-7 object-contain bg-white">

                <p class="text-sm leading-relaxed mb-8" style="color: rgba(255,255,255,0.4); max-width: 300px;">
                    Sevdiklerinize sıradan bir hediye değil, özenle tasarlanmış anılar armağan edin. Her duygu için özel bir kutu.
                </p>

                {{-- Social icons --}}
                <div class="flex items-center gap-3">
                    @foreach([['fa-instagram', '#'], ['fa-facebook-f', '#'], ['fa-tiktok', '#'], ['fa-pinterest-p', '#']] as [$icon, $url])
                        <a href="{{ $url }}"
                           class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:scale-110"
                           style="background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.08);"
                           onmouseover="this.style.background='var(--teal,#2E706D)'; this.style.color='#fff'; this.style.borderColor='var(--teal)';"
                           onmouseout="this.style.background='rgba(255,255,255,0.07)'; this.style.color='rgba(255,255,255,0.5)'; this.style.borderColor='rgba(255,255,255,0.08)';"
                        >
                            <i class="fa-brands {{ $icon }} text-base"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Col 2: Kurumsal --}}
            <div class="lg:col-span-2 lg:pt-2">
                <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] mb-8" style="color: rgba(255,255,255,0.35);">
                    Kurumsal
                </p>
                <ul class="space-y-4">
                    @forelse($footerKurumsal as $sayfa)
                        <li>
                            <a href="{{ route('sayfa.goster', $sayfa->slug) }}"
                               class="group flex items-center gap-2 text-sm font-medium transition-all duration-200"
                               style="color: rgba(255,255,255,0.55);"
                               onmouseover="this.style.color='var(--teal-light,#3D8E8A)'"
                               onmouseout="this.style.color='rgba(255,255,255,0.55)'"
                            >
                                <span class="w-0 group-hover:w-3 overflow-hidden transition-all duration-200" style="color:var(--copper,#C8845A);">→</span>
                                {{ $sayfa->baslik }}
                            </a>
                        </li>
                    @empty
                        <li><span class="text-xs" style="color:rgba(255,255,255,0.2)">Yakında...</span></li>
                    @endforelse
                </ul>
            </div>

            {{-- Col 3: Müşteri Hizmetleri --}}
            <div class="lg:col-span-3 lg:pt-2">
                <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] mb-8" style="color: rgba(255,255,255,0.35);">
                    Müşteri Hizmetleri
                </p>
                <ul class="space-y-4">
                    @forelse($footerYardim as $sayfa)
                        <li>
                            <a href="{{ route('sayfa.goster', $sayfa->slug) }}"
                               class="group flex items-center gap-2 text-sm font-medium transition-all duration-200"
                               style="color: rgba(255,255,255,0.55);"
                               onmouseover="this.style.color='var(--teal-light,#3D8E8A)'"
                               onmouseout="this.style.color='rgba(255,255,255,0.55)'"
                            >
                                <span class="w-0 group-hover:w-3 overflow-hidden transition-all duration-200" style="color:var(--copper,#C8845A);">→</span>
                                {{ $sayfa->baslik }}
                            </a>
                        </li>
                    @empty
                        <li><span class="text-xs" style="color:rgba(255,255,255,0.2)">Yakında...</span></li>
                    @endforelse
                </ul>
            </div>

            {{-- Col 4: Contact --}}
            <div class="lg:col-span-3 lg:pt-2">
                <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] mb-8" style="color: rgba(255,255,255,0.35);">
                    Bize Ulaşın
                </p>
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background: rgba(46,112,109,0.2); color: var(--teal-light,#3D8E8A);">
                            <i class="fa-solid fa-headset text-lg"></i>
                        </div>
                        <div>
                            <p class="text-base font-bold text-white">0850 000 00 00</p>
                            <p class="text-[12px] mt-0.5" style="color: rgba(255,255,255,0.35);">
                                Hft. içi 09:00 – 18:00
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background: rgba(46,112,109,0.2); color: var(--teal-light,#3D8E8A);">
                            <i class="fa-regular fa-envelope text-lg"></i>
                        </div>
                        <div class="flex items-center h-11">
                            <a href="mailto:destek@lagomde.com"
                               class="text-sm font-semibold transition-colors text-white/70 hover:text-white">
                                destek@lagomde.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══ BOTTOM BAR ═══ --}}
    <div class="border-t" style="border-color: rgba(255,255,255,0.07);">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-10 py-7 flex flex-col lg:flex-row items-center justify-between gap-5">

            {{-- Copyright --}}
            <p class="text-[12px] font-medium" style="color: rgba(255,255,255,0.3);">
                &copy; {{ date('Y') }} Lagomde. Tüm hakları saklıdır.
            </p>

            {{-- Legal links --}}
            <div class="flex flex-wrap justify-center gap-5 text-[12px] font-medium">
                @foreach($footerSozlesmeler as $sayfa)
                    <a href="{{ route('sayfa.goster', $sayfa->slug) }}"
                       class="transition-colors"
                       style="color: rgba(255,255,255,0.3);"
                       onmouseover="this.style.color='rgba(255,255,255,0.7)'"
                       onmouseout="this.style.color='rgba(255,255,255,0.3)'"
                    >
                        {{ $sayfa->baslik }}
                    </a>
                @endforeach
            </div>

            {{-- Payment & Security --}}
            <div class="flex items-center gap-4" style="opacity: 0.45;" 
                 onmouseover="this.style.opacity='0.9'"
                 onmouseout="this.style.opacity='0.45'"
                 style="transition: opacity 0.3s; opacity: 0.45;">
                <i class="fa-brands fa-cc-visa text-3xl text-white"></i>
                <i class="fa-brands fa-cc-mastercard text-3xl text-white"></i>
                <div class="flex items-center gap-2 pl-4 border-l" style="border-color:rgba(255,255,255,0.15);">
                    <i class="fa-solid fa-shield-halved text-green-400 text-sm"></i>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-green-400">256-BİT SSL</span>
                </div>
            </div>

        </div>
    </div>

    {{-- Decorative bottom glow --}}
    <div class="absolute bottom-0 right-0 w-96 h-96 pointer-events-none"
         style="background: radial-gradient(circle, rgba(46,112,109,0.08) 0%, transparent 70%);"></div>
</footer>