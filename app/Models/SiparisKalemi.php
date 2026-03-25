<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiparisKalemi extends Model
{
    protected $table = 'siparis_kalemleri';
    protected $guarded = ['id'];

    public function siparis() { return $this->belongsTo(Siparis::class, 'siparis_id'); }
    public function varyasyon() { return $this->belongsTo(UrunVaryasyonu::class, 'varyasyon_id'); }
    public function ozelKutu() { return $this->belongsTo(OzelKutu::class, 'ozel_kutu_id'); }
}