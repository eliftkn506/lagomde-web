<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degerlendirme extends Model
{
    protected $table = 'degerlendirmeler';
    protected $guarded = ['id'];

    public function urun() { return $this->belongsTo(Urun::class, 'urun_id'); }
    public function kullanici() { return $this->belongsTo(Kullanici::class, 'kullanici_id'); }
}