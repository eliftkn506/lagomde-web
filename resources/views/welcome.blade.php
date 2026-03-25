@extends('layouts.app')

@section('title', 'Lagomde - Anasayfa')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-4">
        
        <div class="lg:w-1/3 h-[500px] relative rounded-2xl overflow-hidden group cursor-pointer shadow-md">
            <img src="https://images.unsplash.com/photo-1513201099705-a9746e1e201f?q=80&w=800&auto=format&fit=crop" alt="Doğum Günü" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
            <div class="absolute inset-0 gradient-overlay"></div>
            <div class="absolute bottom-6 left-0 w-full text-center">
                <h2 class="text-white text-2xl font-bold tracking-wide">Doğum Günü Hediyeleri</h2>
            </div>
        </div>

        <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-3 gap-4 h-[500px]">
            <div class="relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm">
                <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=600&auto=format&fit=crop" alt="Erkeğe" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 gradient-overlay"></div>
                <h3 class="absolute bottom-4 left-0 w-full text-center text-white font-semibold text-lg">Erkeğe Hediye</h3>
            </div>
            
            <div class="relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm">
                <img src="https://images.unsplash.com/photo-1542314546-527e02df357e?q=80&w=600&auto=format&fit=crop" alt="Kadına" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 gradient-overlay"></div>
                <h3 class="absolute bottom-4 left-0 w-full text-center text-white font-semibold text-lg">Kadına Hediye</h3>
            </div>

            <div class="relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm bg-gray-900">
                <img src="https://images.unsplash.com/photo-1497032205916-ac775f0649ae?q=80&w=600&auto=format&fit=crop" alt="Yeni İş" class="w-full h-full object-cover opacity-80 transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 gradient-overlay"></div>
                <h3 class="absolute bottom-4 left-0 w-full text-center text-white font-semibold text-lg">Yeni İş Hediyeleri</h3>
            </div>

            <div class="relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm">
                <img src="https://images.unsplash.com/photo-1512413914856-12151121d120?q=80&w=600&auto=format&fit=crop" alt="Kendi Kutunu Yap" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 gradient-overlay"></div>
                <h3 class="absolute bottom-4 left-0 w-full text-center text-white font-semibold text-lg">Kendi Kutunu Yap</h3>
            </div>

            <div class="relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm bg-red-900">
                <img src="https://images.unsplash.com/photo-1518199266791-5375a83190b7?q=80&w=600&auto=format&fit=crop" alt="Sevgiliye" class="w-full h-full object-cover opacity-90 transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 gradient-overlay"></div>
                <h3 class="absolute bottom-4 left-0 w-full text-center text-white font-semibold text-lg">Sevgiliye Hediye</h3>
            </div>

            <div class="relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=600&auto=format&fit=crop" alt="Kurumsal" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 gradient-overlay"></div>
                <h3 class="absolute bottom-4 left-0 w-full text-center text-white font-semibold text-lg">Kurumsal Hediye</h3>
            </div>
        </div>
    </div>
</div>
@endsection