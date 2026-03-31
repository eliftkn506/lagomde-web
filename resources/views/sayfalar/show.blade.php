@extends('layouts.app')

@section('title', $sayfa->baslik . ' | Lagomde')

@section('content')

{{-- ══════ HERO ══════ --}}
<div class="relative pt-20 pb-36 md:pt-28 md:pb-52 overflow-hidden" style="background: var(--bg);">

    {{-- Decorative blurs --}}
    <div class="absolute -top-32 -right-16 w-[500px] h-[500px] rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(46,112,109,0.12) 0%, transparent 70%);"></div>
    <div class="absolute bottom-0 -left-24 w-80 h-80 rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(200,132,90,0.1) 0%, transparent 70%);"></div>

    {{-- Subtle grid texture --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.03]"
         style="background-image: linear-gradient(var(--ink) 1px, transparent 1px), linear-gradient(90deg, var(--ink) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 max-w-[760px] mx-auto px-6 text-center">
        <span class="inline-flex items-center gap-2 text-[10px] font-bold tracking-[0.22em] uppercase mb-6 px-4 py-2 rounded-full"
              style="color: var(--teal); background: var(--teal-pale); border: 1px solid rgba(46,112,109,0.15);">
            <i class="fa-solid fa-circle-info text-[9px]"></i>
            Lagomde Bilgi Merkezi
        </span>

        <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-bold leading-[1.1] mb-7" style="color: var(--ink);">
            {{ $sayfa->baslik }}
        </h1>

        <nav class="flex items-center justify-center gap-2 text-[11px] font-semibold uppercase tracking-widest" style="color: var(--ink-soft);">
            <a href="/" class="transition-colors" style="color: var(--ink-soft);"
               onmouseover="this.style.color='var(--teal)'" onmouseout="this.style.color='var(--ink-soft)'">Anasayfa</a>
            <i class="fa-solid fa-chevron-right text-[8px]" style="color: var(--border);"></i>
            <span style="color: var(--teal);">{{ $sayfa->baslik }}</span>
        </nav>
    </div>
</div>

{{-- ══════ CONTENT CARD ══════ --}}
<div class="relative z-20 max-w-[900px] mx-auto px-5 sm:px-6 -mt-20 md:-mt-28 mb-28">

    <div class="rounded-[32px] md:rounded-[40px] p-8 sm:p-12 md:p-16"
         style="background: var(--surface); border: 1px solid var(--border-soft); box-shadow: 0 32px 80px rgba(22,18,14,0.07), 0 2px 0 rgba(255,255,255,0.8) inset;">

        {{-- Reading progress accent line --}}
        <div class="w-12 h-1 rounded-full mb-10" style="background: linear-gradient(90deg, var(--teal), var(--copper));"></div>

        {{-- Page content --}}
        <div class="custom-prose max-w-none">
            {!! $sayfa->icerik !!}
        </div>

        {{-- CTA footer --}}
        <div class="mt-16 pt-10 flex flex-col sm:flex-row items-center justify-between gap-6"
             style="border-top: 1px solid var(--border-soft);">
            <div>
                <p class="text-sm font-bold" style="color: var(--ink);">Aklınıza takılan bir şey mi var?</p>
                <p class="text-xs mt-1" style="color: var(--ink-soft);">Ekibimiz size yardımcı olmaktan mutluluk duyar.</p>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="/" class="flex-1 sm:flex-none text-center px-6 py-3.5 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all duration-200 hover:scale-[1.02]"
                   style="background: var(--bg); color: var(--ink-soft); border: 1px solid var(--border);">
                    Anasayfa
                </a>
                <a href="mailto:destek@lagomde.com"
                   class="flex-1 sm:flex-none text-center px-6 py-3.5 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all duration-200 hover:scale-[1.02] hover:shadow-lg"
                   style="background: var(--teal); color: #fff; box-shadow: 0 4px 16px rgba(46,112,109,0.25);">
                    Bize Ulaşın
                </a>
            </div>
        </div>

    </div>
</div>

{{-- ══════ CUSTOM PROSE STYLES ══════ --}}
<style>
    .custom-prose { color: var(--ink-soft); font-size: 1.05rem; line-height: 1.88; }

    .custom-prose h1, .custom-prose h2, .custom-prose h3, .custom-prose h4 {
        font-family: 'Playfair Display', serif;
        color: var(--ink);
    }
    .custom-prose h2 {
        font-size: 2rem; font-weight: 700;
        margin-top: 2.2em; margin-bottom: 0.8em;
        padding-bottom: 0.5em;
        border-bottom: 1px solid var(--border-soft);
    }
    .custom-prose h3 {
        font-size: 1.4rem; font-weight: 600;
        margin-top: 1.6em; margin-bottom: 0.5em;
        color: var(--teal);
    }
    .custom-prose p { margin-bottom: 1.5em; }
    .custom-prose strong { color: var(--ink); font-weight: 700; }
    .custom-prose a {
        color: var(--teal);
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1.5px solid rgba(46,112,109,0.3);
        transition: all 0.25s;
    }
    .custom-prose a:hover { color: var(--copper); border-color: var(--copper); }

    .custom-prose ul { list-style: none; padding-left: 0; margin-bottom: 1.5em; }
    .custom-prose ul li { position: relative; padding-left: 1.6em; margin-bottom: 0.8em; }
    .custom-prose ul li::before {
        content: '';
        position: absolute;
        left: 0; top: 11px;
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--teal-pale);
        border: 2px solid var(--teal);
    }

    .custom-prose ol { padding-left: 1.5em; margin-bottom: 1.5em; }
    .custom-prose ol li { margin-bottom: 0.8em; }

    .custom-prose blockquote {
        border-left: 3px solid var(--copper);
        background: var(--bg);
        padding: 1.5rem 2rem;
        border-radius: 0 20px 20px 0;
        margin: 2.5rem 0;
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        line-height: 1.65;
        color: var(--teal);
        font-style: italic;
    }
</style>

@endsection