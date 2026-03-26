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
    public function girisYap(Request $request): RedirectResponse
    {
        $request->validate([
            'eposta' => ['required', 'string', 'email'],
            'sifre'  => ['required', 'string'],
        ], [
            'eposta.required' => 'E-posta adresi gereklidir.',
            'eposta.email'    => 'Geçerli bir e-posta adresi girin.',
            'sifre.required'  => 'Şifre gereklidir.',
        ]);

        $throttleKey = Str::lower($request->input('eposta')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, maxAttempts: 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'eposta' => "Çok fazla giriş denemesi yaptınız. {$seconds} saniye sonra tekrar deneyin.",
            ]);
        }

        $kullanici = Kullanici::where('eposta', $request->input('eposta'))->first();

        if (! $kullanici || ! Hash::check($request->input('sifre'), $kullanici->sifre)) {
            RateLimiter::hit($throttleKey, 60);
            throw ValidationException::withMessages([
                'eposta' => 'E-posta adresi veya şifre hatalı.',
            ]);
        }

        RateLimiter::clear($throttleKey);
        Auth::login($kullanici, $request->boolean('beni_hatirla'));
        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with('success', 'Hoş geldiniz, ' . $kullanici->ad . '! 👋');
    }

    public function kayitOl(Request $request): RedirectResponse
    {
        $request->validate([
            'ad'     => ['required', 'string', 'max:100'],
            'soyad'  => ['required', 'string', 'max:100'],
            'eposta' => ['required', 'string', 'email', 'max:255', 'unique:kullanicilar,eposta'],
            'sifre'  => ['required', 'string', 'min:6', 'confirmed'],
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

        $kullanici = Kullanici::create([
            'ad'     => $request->input('ad'),
            'soyad'  => $request->input('soyad'),
            'eposta' => $request->input('eposta'),
            'sifre'  => Hash::make($request->input('sifre')),
        ]);

        Auth::login($kullanici);
        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('success', 'Hesabınız oluşturuldu! Hoş geldiniz, ' . $kullanici->ad . ' 🎉');
    }

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
        return view('profil', compact('kullanici'));
    }

    /*
    |--------------------------------------------------------------------------
    | HESAP AYARLARI — Sayfayı göster
    |--------------------------------------------------------------------------
    */
    public function ayarlarSayfasi(): \Illuminate\View\View
    {
        $kullanici = Auth::user();
        return view('profil-ayarlar', compact('kullanici'));
    }

    /*
    |--------------------------------------------------------------------------
    | HESAP AYARLARI — Ad / Soyad / E-posta güncelle
    |--------------------------------------------------------------------------
    */
    public function bilgileriGuncelle(Request $request): RedirectResponse
    {
        $kullanici = Auth::user();

        $request->validate([
            'ad'     => ['required', 'string', 'max:100'],
            'soyad'  => ['required', 'string', 'max:100'],
            'eposta' => ['required', 'string', 'email', 'max:255', 'unique:kullanicilar,eposta,' . $kullanici->id],
        ], [
            'ad.required'     => 'Ad alanı gereklidir.',
            'soyad.required'  => 'Soyad alanı gereklidir.',
            'eposta.required' => 'E-posta adresi gereklidir.',
            'eposta.email'    => 'Geçerli bir e-posta adresi girin.',
            'eposta.unique'   => 'Bu e-posta adresi başka bir hesapta kullanılıyor.',
        ]);

        $kullanici->ad     = $request->input('ad');
        $kullanici->soyad  = $request->input('soyad');
        $kullanici->eposta = $request->input('eposta');
        $kullanici->save();

        return redirect()
            ->route('profil.ayarlar')
            ->with('success_bilgi', 'Bilgileriniz başarıyla güncellendi.');
    }

    /*
    |--------------------------------------------------------------------------
    | HESAP AYARLARI — Şifre değiştir
    |--------------------------------------------------------------------------
    */
    public function sifreDegistir(Request $request): RedirectResponse
    {
        $kullanici = Auth::user();

        $request->validate([
            'mevcut_sifre'          => ['required', 'string'],
            'yeni_sifre'            => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'mevcut_sifre.required'  => 'Mevcut şifrenizi girin.',
            'yeni_sifre.required'    => 'Yeni şifre gereklidir.',
            'yeni_sifre.min'         => 'Yeni şifre en az 6 karakter olmalıdır.',
            'yeni_sifre.confirmed'   => 'Şifreler eşleşmiyor.',
        ]);

        // Mevcut şifre doğru mu?
        if (! Hash::check($request->input('mevcut_sifre'), $kullanici->sifre)) {
            return back()
                ->withErrors(['mevcut_sifre' => 'Mevcut şifreniz hatalı.'])
                ->withInput();
        }

        $kullanici->sifre = Hash::make($request->input('yeni_sifre'));
        $kullanici->save();

        return redirect()
            ->route('profil.ayarlar')
            ->with('success_sifre', 'Şifreniz başarıyla değiştirildi.');
    }
}
