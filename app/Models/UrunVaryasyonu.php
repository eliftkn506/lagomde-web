<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrunVaryasyonu extends Model
{
    protected $table = 'urun_varyasyonlari';
    protected $guarded = ['id'];

    public function urun() { return $this->belongsTo(Urun::class, 'urun_id'); }
    public function ozellikDegerleri() { return $this->belongsToMany(OzellikDegeri::class, 'varyasyon_deger_eslesmeleri', 'varyasyon_id', 'ozellik_deger_id'); }
    public function gorseller() { return $this->hasMany(UrunGorseli::class, 'varyasyon_id'); }
    public function stokHareketleri() { return $this->hasMany(StokHareketi::class, 'varyasyon_id'); }
}