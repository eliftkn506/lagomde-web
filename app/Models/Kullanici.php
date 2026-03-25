<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kullanici extends Authenticatable
{
    use Notifiable;

    protected $table = 'kullanicilar';
    
    // Tasarımında created_at/updated_at var ama içerikleri NULL ise Laravel'in hata vermemesi için:
    public $timestamps = false; 

    protected $guarded = ['id'];

    // Şifre sütununun adı 'sifre' olduğu için gizliyoruz
    protected $hidden = ['sifre', 'remember_token'];

    /**
     * Oturum açarken 'email' yerine 'eposta' sütununa bak.
     */
    public function getAuthIdentifierName()
    {
        return 'eposta';
    }

    /**
     * Şifre kontrolü yaparken 'password' yerine 'sifre' sütununa bak.
     */
    public function getAuthPassword()
    {
        return $this->sifre;
    }
}