<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SepetKalemi extends Model
{
    protected $table = 'sepet_kalemleri';
    protected $guarded = ['id'];

    public function sepet() { return $this->belongsTo(Sepet::class, 'sepet_id'); }
    public function varyasyon() { return $this->belongsTo(UrunVaryasyonu::class, 'varyasyon_id'); }
    public function ozelKutu() { return $this->belongsTo(OzelKutu::class, 'ozel_kutu_id'); }
}