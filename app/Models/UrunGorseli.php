<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrunGorseli extends Model
{
    protected $table = 'urun_gorselleri';
    protected $guarded = ['id'];
    public $timestamps = false; // Migration'da timestamp yoktu

    public function urun() { return $this->belongsTo(Urun::class, 'urun_id'); }
    public function varyasyon() { return $this->belongsTo(UrunVaryasyonu::class, 'varyasyon_id'); }
}