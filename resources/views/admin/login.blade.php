<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lagomde | Yönetici Portalı</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            background-image: radial-gradient(#cbd5e1 0.5px, transparent 0.5px);
            background-size: 34px 34px;
        }
        .modern-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid #f1f5f9;
        }
        /* Logodaki asil koyu tonu butona ve detaylara taşıyoruz */
        .brand-color { color: #1e293b; }
        .btn-brand {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            box-shadow: 0 12px 24px -6px rgba(30, 41, 59, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="max-w-[440px] w-full">
        
        <div class="text-center mb-10">
            <img src="{{ asset('logo.png') }}" alt="Lagomde" class="h-44 w-auto mx-auto object-contain pointer-events-none">
        </div>

        <div class="modern-card rounded-[2.8rem] shadow-[0_45px_110px_-25px_rgba(0,0,0,0.06)] p-10 md:p-14">
            
            <div class="mb-10 text-center">
                <h2 class="brand-color text-3xl font-extrabold tracking-tight">Yönetici Girişi</h2>
                <div class="h-1 w-8 bg-slate-200 mx-auto mt-4 rounded-full"></div>
                <p class="text-slate-400 mt-4 text-xs font-semibold tracking-wider italic">Güvenli Yönetim Sistemi</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-xs flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-3 text-lg"></i>
                    <span class="font-bold">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-7">
                @csrf
                
                <div class="space-y-2.5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Kullanıcı Tanımı</label>
                    <div class="relative group">
                        <input type="email" name="email" required 
                               class="w-full pl-12 pr-4 py-4.5 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-slate-100 focus:bg-white focus:border-slate-800 outline-none transition-all duration-300 text-slate-900 font-semibold placeholder:text-slate-300"
                               placeholder="admin@lagomde.com">
                        <i class="fa-solid fa-fingerprint absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-slate-800 transition-colors"></i>
                    </div>
                </div>

                <div class="space-y-2.5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Erişim Şifresi</label>
                    <div class="relative group">
                        <input type="password" name="password" required 
                               class="w-full pl-12 pr-4 py-4.5 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-slate-100 focus:bg-white focus:border-slate-800 outline-none transition-all duration-300 text-slate-900 font-semibold placeholder:text-slate-300"
                               placeholder="••••••••">
                        <i class="fa-solid fa-shield-halved absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-slate-800 transition-colors"></i>
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="relative flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="sr-only peer">
                        <div class="w-5 h-5 bg-slate-50 border border-slate-200 rounded-lg peer-checked:bg-slate-800 peer-checked:border-slate-800 transition-all"></div>
                        <i class="fa-solid fa-check absolute text-[10px] text-white opacity-0 peer-checked:opacity-100 left-[5px]"></i>
                        <span class="ml-3 text-xs font-bold text-slate-400 group-hover:text-slate-800 transition-colors select-none">Beni Hatırla</span>
                    </label>
                    <a href="#" class="text-[10px] font-bold text-slate-300 hover:text-slate-800 transition-colors tracking-tighter">Yardım Merkezi</a>
                </div>

                <button type="submit" 
                        class="btn-brand w-full text-white font-bold py-5 rounded-[1.4rem] hover:brightness-110 transform transition-all active:scale-[0.98] flex items-center justify-center group uppercase tracking-[0.25em] text-[11px]">
                    <span>Doğrula ve Giriş Yap</span>
                    <i class="fa-solid fa-chevron-right ml-3 text-[10px] opacity-60 group-hover:translate-x-1.5 transition-transform"></i>
                </button>
            </form>
        </div>

        <div class="mt-14 text-center">
            <p class="text-slate-300 text-[9px] font-bold tracking-[0.5em] uppercase">
                Secure Terminal &bull; {{ date('Y') }} Lagomde
            </p>
        </div>
    </div>

</body>
</html>