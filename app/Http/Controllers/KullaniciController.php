<?php

namespace App\Http\Controllers;

use App\Models\Kullanici;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class KullaniciController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GİRİŞ YAP
    |--------------------------------------------------------------------------
    | - Rate limiting: aynı IP + eposta 5 denemeden sonra 60sn kilitlenir
    | - Hash::check ile manuel doğrulama (sütun adı 'sifre' olduğu için
    |   Auth::attempt() kullanılmıyor)
    | - Auth::login() + session regenerate (session fixation koruması)
    */
    public function girisYap(Request $request): RedirectResponse
    {
        // 1) Validasyon
        $request->validate([
            'eposta' => ['required', 'string', 'email'],
            'sifre'  => ['required', 'string'],
        ], [
            'eposta.required' => 'E-posta adresi gereklidir.',
            'eposta.email'    => 'Geçerli bir e-posta adresi girin.',
            'sifre.required'  => 'Şifre gereklidir.',
        ]);

        // 2) Rate limiting — 5 başarısız deneme → 60 saniye bekleme
        $throttleKey = Str::lower($request->input('eposta')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, maxAttempts: 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'eposta' => "Çok fazla giriş denemesi yaptınız. {$seconds} saniye sonra tekrar deneyin.",
            ]);
        }

        // 3) Kullanıcıyı bul
        $kullanici = Kullanici::where('eposta', $request->input('eposta'))->first();

        // 4) Şifre kontrolü
        if (! $kullanici || ! Hash::check($request->input('sifre'), $kullanici->sifre)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'eposta' => 'E-posta adresi veya şifre hatalı.',
            ]);
        }

        // 5) Başarılı giriş — rate limiter sıfırla
        RateLimiter::clear($throttleKey);

        // 6) Oturumu aç + session regenerate (session fixation önlemi)
        Auth::login($kullanici, $request->boolean('beni_hatirla'));
        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with('success', 'Hoş geldiniz, ' . $kullanici->ad . '! 👋');
    }

    /*
    |--------------------------------------------------------------------------
    | KAYIT OL
    |--------------------------------------------------------------------------
    | - E-posta unique kontrolü DB seviyesinde
    | - Şifre Hash::make ile hashlenerek kaydedilir
    | - Kayıt sonrası otomatik giriş yapılır
    */
    public function kayitOl(Request $request): RedirectResponse
    {
        // 1) Validasyon
        $request->validate([
            'ad'     => ['required', 'string', 'max:100'],
            'soyad'  => ['required', 'string', 'max:100'],
            'eposta' => ['required', 'string', 'email', 'max:255', 'unique:kullanicilar,eposta'],
            'sifre'  => ['required', 'string', 'min:6', 'confirmed'],
            // 'confirmed' → 'sifre_confirmation' alanıyla eşleşmeli
        ], [
            'ad.required'      => 'Ad alanı gereklidir.',
            'soyad.required'   => 'Soyad alanı gereklidir.',
            'eposta.required'  => 'E-posta adresi gereklidir.',
            'eposta.email'     => 'Geçerli bir e-posta adresi girin.',
            'eposta.unique'    => 'Bu e-posta adresi zaten kayıtlı.',
            'sifre.required'   => 'Şifre gereklidir.',
            'sifre.min'        => 'Şifre en az 6 karakter olmalıdır.',
            'sifre.confirmed'  => 'Şifreler eşleşmiyor.',
        ]);

        // 2) Kullanıcıyı oluştur (şifre hashlenir)
        $kullanici = Kullanici::create([
            'ad'     => $request->input('ad'),
            'soyad'  => $request->input('soyad'),
            'eposta' => $request->input('eposta'),
            'sifre'  => Hash::make($request->input('sifre')),
        ]);

        // 3) Otomatik giriş yap + session regenerate
        Auth::login($kullanici);
        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('success', 'Hesabınız oluşturuldu! Hoş geldiniz, ' . $kullanici->ad . ' 🎉');
    }

    /*
    |--------------------------------------------------------------------------
    | ÇIKIŞ YAP
    |--------------------------------------------------------------------------
    | - Auth::logout() → guard'ı temizler
    | - session invalidate → tüm session verisini siler
    | - session regenerateToken → CSRF token'ı yeniler
    */
    public function cikisYap(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function profilSayfasi(): \Illuminate\View\View
{
    $kullanici = Auth::user();

    // İleride siparişler buraya gelecek
    // $siparisler = $kullanici->siparisler()->latest()->get();

    return view('profil', compact('kullanici'));
}
}
