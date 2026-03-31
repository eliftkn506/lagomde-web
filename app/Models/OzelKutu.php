<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OzelKutu extends Model
{
    protected $table = 'ozel_kutular';
    protected $guarded = ['id'];

    public function kullanici() { return $this->belongsTo(Kullanici::class, 'kullanici_id'); }
    public function icerikler() { return $this->hasMany(OzelKutuIcerigi::class, 'ozel_kutu_id'); }
    public function kutuVaryasyon() {
        return $this->belongsTo(UrunVaryasyonu::class, 'kutu_varyasyon_id');
    }
}