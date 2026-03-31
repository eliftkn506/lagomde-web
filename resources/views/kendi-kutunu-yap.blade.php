@extends('layouts.app')

@section('title', 'Kendi Kutunu Yap — Lagomde')

@section('content')

<style>
    /* Özelleştirilmiş Scrollbar ve Animasyonlar */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    .step-btn {
        position: relative;
        transition: all 0.3s ease;
    }
    .step-btn::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        width: 0;
        height: 2px;
        background: var(--teal);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    .step-btn.active { color: var(--teal); font-weight: 800; }
    .step-btn.active::after { width: 100%; }

    .sticky-sidebar {
        position: sticky;
        top: 100px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }
    .sticky-sidebar::-webkit-scrollbar { width: 4px; }
    .sticky-sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }

    /* Kutu İçi Ürün Kartı Efektleri */
    .gift-card { transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); }
    .gift-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
</style>

<div x-data="kutuYapApp()" class="bg-[#F8F9F8] min-h-screen pb-16" x-cloak>
    
    {{-- ═══ HERO BÖLÜMÜ ═══ --}}
    <div class="bg-[var(--teal-dk)] text-white py-14 relative overflow-hidden mb-10">
        <div class="absolute inset-0 bg-black/20 z-10"></div>
        <div class="absolute inset-0 z-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-[1440px] mx-auto px-5 lg:px-10 relative z-20 text-center">
            <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-[var(--copper)] mb-3">KİŞİYE ÖZEL DENEYİM</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold mb-4">Kendi Kutunu Yap</h1>
            <p class="text-sm text-white/70 max-w-xl mx-auto">Sevdikleriniz için en anlamlı hediyeyi tasarlayın. Önce kutunuzu seçin, içini en güzel ürünlerle doldurun ve kişisel notunuzu ekleyin.</p>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-5 lg:px-10 grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- ═══ SOL ALAN: ADIMLAR VE ÜRÜNLER (8 Kolon) ═══ --}}
        <div class="lg:col-span-8">
            
            {{-- İlerleme Çubuğu (Tabs) --}}
            <div class="flex items-center justify-between md:justify-start gap-4 md:gap-10 border-b border-gray-200 mb-8 pb-4 overflow-x-auto hide-scrollbar">
                <button @click="step = 1" :class="step === 1 ? 'active' : 'text-gray-400 hover:text-gray-600'" class="step-btn pb-2 text-sm font-semibold flex items-center gap-2 whitespace-nowrap">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[11px]" :class="step === 1 ? 'bg-[var(--teal)] text-white' : 'bg-gray-100'">1</span> 
                    Kutu Seçimi
                </button>
                <button @click="if(box) step = 2" :class="step === 2 ? 'active' : 'text-gray-400 hover:text-gray-600'" class="step-btn pb-2 text-sm font-semibold flex items-center gap-2 whitespace-nowrap" :disabled="!box">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[11px]" :class="step === 2 ? 'bg-[var(--teal)] text-white' : 'bg-gray-100'">2</span> 
                    Hediyeler
                </button>
                <button @click="if(items.length > 0) step = 3" :class="step === 3 ? 'active' : 'text-gray-400 hover:text-gray-600'" class="step-btn pb-2 text-sm font-semibold flex items-center gap-2 whitespace-nowrap" :disabled="items.length === 0">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[11px]" :class="step === 3 ? 'bg-[var(--teal)] text-white' : 'bg-gray-100'">3</span> 
                    Not & Tamamla
                </button>
            </div>

            {{-- ADIM 1: BOŞ KUTU SEÇİMİ --}}
            <div x-show="step === 1" x-transition.opacity.duration.300ms>
                <h2 class="font-display text-2xl font-bold text-[var(--ink)] mb-6">Önce Hediye Kutunuzu Seçin</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                    @forelse($kutular as $kutu)
                        @php 
                            $v = $kutu->varyasyonlar->first(); 
                            $fiyat = $v->indirimli_fiyat ?? $v->normal_fiyat;
                            $gorsel = $kutu->gorseller->first() ? asset($kutu->gorseller->first()->gorsel_url) : '';
                        @endphp
                        <div class="gift-card bg-white rounded-[20px] p-4 cursor-pointer border-2 transition-all"
                             :class="box && box.id === {{ $v->id }} ? 'border-[var(--teal)] ring-4 ring-[var(--teal-lt)]' : 'border-transparent'"
                             @click="selectBox({{ $v->id }}, '{{ addslashes($kutu->ad) }}', {{ $fiyat }}, '{{ $gorsel }}')">
                            
                            <div class="aspect-square rounded-xl bg-gray-50 mb-4 overflow-hidden">
                                <img src="{{ $gorsel }}" alt="{{ $kutu->ad }}" class="w-full h-full object-cover">
                            </div>
                            <h3 class="text-sm font-bold text-[var(--ink)] line-clamp-2 leading-tight mb-2">{{ $kutu->ad }}</h3>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="font-display text-lg font-bold text-[var(--teal)]">₺{{ number_format($fiyat, 2, ',', '.') }}</span>
                                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-colors"
                                     :class="box && box.id === {{ $v->id }} ? 'bg-[var(--teal)] text-white' : 'bg-gray-100 text-gray-400'">
                                    <i class="fa-solid" :class="box && box.id === {{ $v->id }} ? 'fa-check' : 'fa-plus'"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500 py-10">Henüz boş kutu eklenmemiş.</p>
                    @endforelse
                </div>
            </div>

            {{-- ADIM 2: İÇERİK (HEDİYE) SEÇİMİ --}}
            <div x-show="step === 2" style="display: none;" x-transition.opacity.duration.300ms>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display text-2xl font-bold text-[var(--ink)]">Kutunuza Neler Eklemek İstersiniz?</h2>
                </div>

                {{-- Kategori Filtreleri --}}
                <div class="flex gap-2 overflow-x-auto hide-scrollbar mb-6 pb-2">
                    @foreach($icerikKategorileri as $kat)
                        <button @click="activeCat = {{ $kat->id }}"
                                :class="activeCat === {{ $kat->id }} ? 'bg-[var(--ink)] text-white border-[var(--ink)]' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300'"
                                class="px-5 py-2.5 rounded-full text-xs font-bold border transition whitespace-nowrap">
                            {{ $kat->ad }}
                        </button>
                    @endforeach
                </div>

                {{-- Ürünler Grid'i --}}
                <div>
                    @foreach($icerikKategorileri as $kat)
                        <div x-show="activeCat === {{ $kat->id }}" class="grid grid-cols-2 md:grid-cols-3 gap-5" style="display: none;">
                            @foreach($kat->urunler as $urun)
                                @php 
                                    $uv = $urun->varyasyonlar->first(); 
                                    if(!$uv) continue;
                                    $uFiyat = $uv->indirimli_fiyat ?? $uv->normal_fiyat;
                                    $uGorsel = $urun->gorseller->first() ? asset($urun->gorseller->first()->gorsel_url) : '';
                                @endphp
                                <div class="gift-card bg-white rounded-[20px] p-4 flex flex-col border border-gray-100 shadow-sm relative">
                                    
                                    {{-- Miktar Rozeti (Üstte) --}}
                                    <div x-show="getItemQty({{ $uv->id }}) > 0" class="absolute -top-2 -right-2 w-7 h-7 bg-[var(--copper)] text-white rounded-full flex items-center justify-center text-xs font-bold z-10 shadow-md" x-text="getItemQty({{ $uv->id }})"></div>

                                    <div class="aspect-square rounded-xl bg-gray-50 mb-4 overflow-hidden">
                                        <img src="{{ $uGorsel }}" alt="{{ $urun->ad }}" class="w-full h-full object-cover">
                                    </div>
                                    <p class="text-[9px] font-bold tracking-widest uppercase text-gray-400 mb-1">{{ $kat->ad }}</p>
                                    <h3 class="text-sm font-semibold text-[var(--ink)] line-clamp-2 leading-tight mb-3">{{ $urun->ad }}</h3>
                                    
                                    <div class="mt-auto flex items-center justify-between gap-2">
                                        <span class="font-display text-[17px] font-bold text-[var(--ink)]">₺{{ number_format($uFiyat, 2, ',', '.') }}</span>
                                        
                                        {{-- Ekle/Çıkar Butonları --}}
                                        <div class="flex items-center">
                                            {{-- Eklendiyse Miktar Kontrolü Görünür --}}
                                            <div x-show="getItemQty({{ $uv->id }}) > 0" class="flex items-center bg-gray-100 rounded-full h-8">
                                                <button @click="removeItem({{ $uv->id }})" class="w-8 h-full flex items-center justify-center text-gray-600 hover:text-red-500"><i class="fa-solid fa-minus text-[10px]"></i></button>
                                                <span class="w-6 text-center text-xs font-bold" x-text="getItemQty({{ $uv->id }})"></span>
                                                <button @click="addItem({{ $uv->id }}, '{{ addslashes($urun->ad) }}', {{ $uFiyat }}, '{{ $uGorsel }}')" class="w-8 h-full flex items-center justify-center text-[var(--teal)]"><i class="fa-solid fa-plus text-[10px]"></i></button>
                                            </div>
                                            
                                            {{-- Hiç Eklenmediyse Sadece Ekle Butonu --}}
                                            <button x-show="getItemQty({{ $uv->id }}) === 0" 
                                                    @click="addItem({{ $uv->id }}, '{{ addslashes($urun->ad) }}', {{ $uFiyat }}, '{{ $uGorsel }}')" 
                                                    class="w-8 h-8 rounded-full bg-[var(--teal-lt)] text-[var(--teal)] flex items-center justify-center hover:bg-[var(--teal)] hover:text-white transition">
                                                <i class="fa-solid fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ADIM 3: NOT & ONAY --}}
            <div x-show="step === 3" style="display: none;" x-transition.opacity.duration.300ms>
                <div class="bg-white rounded-[24px] p-6 md:p-10 border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-full bg-[#FAF0E6] text-[var(--copper)] flex items-center justify-center text-xl">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div>
                            <h2 class="font-display text-2xl font-bold text-[var(--ink)]">Hediye Notunuz</h2>
                            <p class="text-sm text-gray-500">Sevdiklerinize iletmek istediğiniz özel mesajı yazın. (Ücretsiz)</p>
                        </div>
                    </div>
                    
                    <textarea x-model="note" rows="5" maxlength="300"
                              class="w-full p-5 rounded-2xl border-2 border-gray-100 focus:border-[var(--teal)] focus:ring-4 focus:ring-[var(--teal-lt)] outline-none transition text-sm font-medium resize-none bg-gray-50 focus:bg-white" 
                              placeholder="Örn: Doğum günün kutlu olsun canım arkadaşım! Yeni yaşın sana güzellikler getirsin..."></textarea>
                    
                    <div class="text-right mt-2 text-xs text-gray-400 font-medium">
                        <span x-text="note.length"></span> / 300 karakter
                    </div>
                </div>
            </div>

        </div>

        {{-- ═══ SAĞ ALAN: KUTU ÖZETİ (STICKY) (4 Kolon) ═══ --}}
        <div class="lg:col-span-4">
            <div class="sticky-sidebar bg-white rounded-[28px] border border-gray-100 shadow-[0_8px_30px_rgba(24,32,31,0.06)] flex flex-col h-fit">
                
                <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50 rounded-t-[28px]">
                    <h3 class="font-bold text-[var(--ink)] flex items-center gap-2">
                        <i class="fa-solid fa-box-open text-[var(--copper)]"></i> Kutunuz
                    </h3>
                    <span class="text-xs font-bold px-2 py-1 bg-gray-200 text-gray-600 rounded-md" x-text="totalItemCount + ' Ürün'"></span>
                </div>

                <div class="p-6 flex-1 overflow-y-auto max-h-[400px] hide-scrollbar">
                    
                    {{-- Boş Durum --}}
                    <div x-show="!box && items.length === 0" class="text-center py-10 opacity-60">
                        <i class="fa-solid fa-box text-5xl text-gray-300 mb-4"></i>
                        <p class="text-sm font-medium text-gray-500">Kutunuz şu an boş.<br>Sol taraftan bir kutu seçerek başlayın.</p>
                    </div>

                    {{-- Seçili Kutu --}}
                    <div x-show="box" class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100" style="display: none;">
                        <img :src="box?.image" class="w-14 h-14 rounded-xl object-cover bg-gray-50 border border-gray-100">
                        <div class="flex-1">
                            <p class="text-[10px] font-bold text-[var(--copper)] uppercase tracking-wider mb-0.5">Ambalaj</p>
                            <p class="text-xs font-bold text-[var(--ink)] leading-tight line-clamp-1" x-text="box?.name"></p>
                            <p class="text-xs text-gray-500 mt-1 font-semibold">₺<span x-text="formatPrice(box?.price)"></span></p>
                        </div>
                        <button @click="removeBox()" class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition flex items-center justify-center" title="Kutuyu Değiştir">
                            <i class="fa-solid fa-trash text-[10px]"></i>
                        </button>
                    </div>

                    {{-- Eklenen Ürünler Listesi --}}
                    <div class="space-y-3">
                        <template x-for="item in items" :key="item.id">
                            <div class="flex items-center gap-3 group">
                                <div class="relative">
                                    <img :src="item.image" class="w-12 h-12 rounded-xl object-cover bg-gray-50 border border-gray-100">
                                    <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-[var(--ink)] text-white text-[10px] font-bold rounded-full flex items-center justify-center" x-text="item.qty"></span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-[var(--ink)] leading-tight line-clamp-2" x-text="item.name"></p>
                                    <p class="text-[11px] text-gray-500 mt-0.5 font-semibold">₺<span x-text="formatPrice(item.price)"></span></p>
                                </div>
                                <button @click="removeItem(item.id)" class="w-6 h-6 rounded-full text-gray-400 hover:bg-red-50 hover:text-red-500 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Alt Bilgi & Toplam & Buton --}}
                <div class="p-6 bg-gray-50/50 rounded-b-[28px] border-t border-gray-100">
                    <div class="flex justify-between items-end mb-5">
                        <span class="text-sm font-bold text-gray-500">Ara Toplam:</span>
                        <div class="text-right">
                            <p class="font-display text-3xl font-bold text-[var(--ink)]">₺<span x-text="formatPrice(total)"></span></p>
                            <p class="text-[10px] text-gray-400 font-medium">KDV Dahil</p>
                        </div>
                    </div>

                    {{-- Yönlendirme Butonları --}}
                    <button x-show="step === 1" @click="step = 2" class="w-full py-4 rounded-xl text-sm font-bold transition shadow-md flex items-center justify-center gap-2"
                            :class="box ? 'bg-[var(--teal)] text-white hover:bg-[var(--teal-dk)]' : 'bg-gray-200 text-gray-400 cursor-not-allowed'" :disabled="!box">
                        İçerikleri Seç <i class="fa-solid fa-arrow-right"></i>
                    </button>

                    <button x-show="step === 2" @click="step = 3" class="w-full py-4 rounded-xl text-sm font-bold transition shadow-md flex items-center justify-center gap-2"
                            :class="items.length > 0 ? 'bg-[var(--teal)] text-white hover:bg-[var(--teal-dk)]' : 'bg-gray-200 text-gray-400 cursor-not-allowed'" :disabled="items.length === 0">
                        Devam Et <i class="fa-solid fa-arrow-right"></i>
                    </button>

                    <button x-show="step === 3" @click="submitBox()" class="w-full py-4 rounded-xl text-sm font-bold transition shadow-[0_8px_20px_rgba(192,122,79,0.3)] flex items-center justify-center gap-2"
                            :class="isSubmitting ? 'bg-gray-400 cursor-not-allowed' : 'bg-[var(--copper)] text-white hover:bg-[#A86940]'" :disabled="isSubmitting">
                        <span x-show="!isSubmitting"><i class="fa-solid fa-bag-shopping"></i> Kutuyu Sepete Ekle</span>
                        <span x-show="isSubmitting"><i class="fa-solid fa-circle-notch fa-spin"></i> Ekleniyor...</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('kutuYapApp', () => ({
        step: 1,
        activeCat: {{ $icerikKategorileri->first()->id ?? 0 }},
        box: null, 
        items: [], 
        note: '',
        isSubmitting: false,

        // Getter: Toplam Fiyat
        get total() {
            let t = this.box ? parseFloat(this.box.price) : 0;
            this.items.forEach(i => t += (parseFloat(i.price) * i.qty));
            return t;
        },

        // Getter: Toplam Ürün (Kutu + Hediyeler)
        get totalItemCount() {
            let count = this.box ? 1 : 0;
            this.items.forEach(i => count += i.qty);
            return count;
        },

        // Format: 1250.50 -> 1.250,50
        formatPrice(val) {
            if(!val) return '0,00';
            return parseFloat(val).toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        },

        selectBox(id, name, price, image) {
            this.box = {id, name, price, image};
            // Kullanıcı kutuyu seçince otomatik olarak yumuşak bir geçişle 2. adıma atlat
            setTimeout(() => {
                this.step = 2;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 350);
        },

        removeBox() {
            this.box = null;
            this.step = 1; // Kutu silinince zorunlu olarak başa dönmeli
        },

        addItem(id, name, price, image) {
            let existing = this.items.find(i => i.id === id);
            if (existing) {
                existing.qty++;
            } else {
                this.items.push({id, name, price, image, qty: 1});
            }
        },

        removeItem(id) {
            let index = this.items.findIndex(i => i.id === id);
            if (index > -1) {
                if (this.items[index].qty > 1) {
                    this.items[index].qty--;
                } else {
                    this.items.splice(index, 1);
                    // Eğer son ürün silindiyse ve 3. adımdaysak 2. adıma geri at
                    if (this.items.length === 0 && this.step === 3) {
                        this.step = 2;
                    }
                }
            }
        },

        getItemQty(id) {
            let item = this.items.find(i => i.id === id);
            return item ? item.qty : 0;
        },

        submitBox() {
            this.isSubmitting = true;

            const payload = {
                kutu_varyasyon_id: this.box.id,
                kutu_fiyat: this.box.price,
                not: this.note,
                icerikler: this.items.map(i => ({
                    id: i.id,
                    adet: i.qty,
                    fiyat: i.price
                }))
            };

            fetch('{{ route("kutu.sepete.ekle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Animasyonlu başarı bildirimi ve sepete yönlendirme
                    const notif = document.createElement('div');
                    notif.style.cssText = 'position:fixed;bottom:24px;right:24px;background:var(--teal);color:white;padding:16px 28px;border-radius:20px;font-size:14px;font-weight:700;z-index:9999;box-shadow:0 12px 40px rgba(42,107,105,.4);transform:translateY(30px);opacity:0;transition:all .35s cubic-bezier(.22,1,.36,1);display:flex;align-items:center;gap:10px;';
                    notif.innerHTML = '<i class="fa-solid fa-check"></i> ' + data.message;
                    document.body.appendChild(notif);
                    
                    requestAnimationFrame(() => { notif.style.transform = 'translateY(0)'; notif.style.opacity = '1'; });
                    
                    setTimeout(() => { 
                        window.location.href = '/sepet'; // Kendi sepet URL'inize göre güncelleyebilirsiniz.
                    }, 1200);
                } else {
                    alert('Hata: Bilgileri kontrol edip tekrar deneyin.');
                    this.isSubmitting = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Bir iletişim hatası oluştu.');
                this.isSubmitting = false;
            });
        }
    }));
});
</script>

@endsection