@extends('layouts.app')

@section('title', $sayfa->baslik . ' | Lagomde')

@section('content')

{{-- ÜST BAŞLIK ALANI (HERO) --}}
<div class="bg-gray-50 border-b border-gray-200 py-16 md:py-24 mt-1">
    <div class="max-w-[800px] mx-auto px-6 text-center">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $sayfa->baslik }}</h1>
        {{-- Logomuzun rengiyle uyumlu çizgi --}}
        <div class="w-12 h-1 bg-[#326765] mx-auto rounded-full"></div>
    </div>
</div>

{{-- METİN İÇERİĞİ --}}
<div class="max-w-[800px] mx-auto px-6 py-16 md:py-20">
    
    {{-- Admin panelinden CKEditor ile eklenen HTML içerik --}}
    <div class="prose prose-slate prose-lg max-w-none text-gray-600">
        {!! $sayfa->icerik !!}
    </div>

    {{-- Geri Dön Butonu --}}
    <div class="mt-16 pt-8 border-t border-gray-100 text-center">
        <a href="/" class="inline-flex items-center gap-2 text-sm font-bold tracking-widest uppercase text-gray-400 hover:text-[#326765] transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Ana Sayfaya Dön
        </a>
    </div>
</div>

{{-- CKEditor Çıktısı İçin CSS Yaması (Yazıların düzgün hizalanması için) --}}
<style>
    .prose h1, .prose h2, .prose h3, .prose h4 { color: #111827; font-weight: 700; margin-top: 2em; margin-bottom: 1em; }
    .prose h2 { font-size: 1.75em; }
    .prose h3 { font-size: 1.25em; }
    .prose p { margin-bottom: 1.25em; line-height: 1.8; }
    .prose ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1.25em; }
    .prose ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1.25em; }
    .prose li { margin-bottom: 0.5em; }
    .prose strong { color: #111827; font-weight: 600; }
    .prose a { color: #326765; text-decoration: underline; font-weight: 500; }
    .prose blockquote { border-left: 4px solid #326765; padding-left: 1em; font-style: italic; color: #4b5563; }
</style>

@endsection