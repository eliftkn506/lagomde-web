<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use SoftDeletes;
    protected $table = 'urunler';
    protected $guarded = ['id'];

    public function kategoriler() { return $this->belongsToMany(Kategori::class, 'kategori_urun', 'urun_id', 'kategori_id'); }
    public function varyasyonlar() { return $this->hasMany(UrunVaryasyonu::class, 'urun_id'); }
    public function gorseller() { return $this->hasMany(UrunGorseli::class, 'urun_id')->orderBy('sira'); }
    public function degerlendirmeler() { return $this->hasMany(Degerlendirme::class, 'urun_id'); }
}