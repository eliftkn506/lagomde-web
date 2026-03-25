<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokHareketi extends Model
{
    protected $table = 'stok_hareketleri';
    protected $guarded = ['id'];
    public $timestamps = false; // İslem_tarihi kullanıyoruz

    public function varyasyon() { return $this->belongsTo(UrunVaryasyonu::class, 'varyasyon_id'); }
    public function siparis() { return $this->belongsTo(Siparis::class, 'siparis_id'); }
}