<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OzelKutuIcerigi extends Model
{
    protected $table = 'ozel_kutu_icerikleri';
    protected $guarded = ['id'];

    public function ozelKutu() { return $this->belongsTo(OzelKutu::class, 'ozel_kutu_id'); }
    public function varyasyon() { return $this->belongsTo(UrunVaryasyonu::class, 'varyasyon_id'); }
}