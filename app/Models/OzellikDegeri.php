<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OzellikDegeri extends Model
{
    protected $table = 'ozellik_degerleri';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function ozellik() { return $this->belongsTo(Ozellik::class, 'ozellik_id'); }
    public function varyasyonlar() { return $this->belongsToMany(UrunVaryasyonu::class, 'varyasyon_deger_eslesmeleri', 'ozellik_deger_id', 'varyasyon_id'); }
}