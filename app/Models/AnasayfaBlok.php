<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnasayfaBlok extends Model
{
    use HasFactory;

    protected $table = 'anasayfa_bloklari';

    protected $fillable = [
        'tip',
        'baslik',
        'alt_baslik',
        'buton_metni',
        'buton_linki',
        'icerik_verisi',
        'aktif_mi',
        'sira'
    ];

    // JSON formatındaki veriyi otomatik olarak Array'e çevirir (ve tam tersi)
    protected $casts = [
        'icerik_verisi' => 'array',
        'aktif_mi' => 'boolean'
    ];
}