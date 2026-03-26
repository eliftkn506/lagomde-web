<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kullanici extends Authenticatable
{
    use Notifiable;

    protected $table = 'kullanicilar';

    public $timestamps = false; // created_at / updated_at aktif

    protected $guarded = ['id'];

    protected $hidden = ['sifre', 'remember_token'];



    // Auth için sifre sütununu kullan
    public function getAuthPassword(): string
    {
        return $this->sifre;
    }


    // Session'a user_id olarak sayısal id'yi yaz
public function getAuthIdentifier()
{
    return $this->id;
}

// Login için eposta ile bul
public function getAuthIdentifierName(): string
{
    return 'id'; // ← bunu 'eposta'dan 'id'ye çevir
}
}
