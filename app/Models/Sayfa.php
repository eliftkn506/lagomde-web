<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sayfa extends Model
{
    use HasFactory;

    protected $table = 'sayfalar';

    // Mass-assignment güvenlik onayı
    protected $fillable = [
        'baslik', 
        'slug', 
        'icerik', 
        'footer_konum', 
        'aktif_mi', 
        'sira'
    ];
}