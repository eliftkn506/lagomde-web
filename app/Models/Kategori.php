<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoriler';
    protected $guarded = ['id'];
    protected $fillable = ['ad', 'slug', 'ust_kategori_id', 'gorsel','ozel_kutuda_goster'];

    public function ustKategori() { return $this->belongsTo(Kategori::class, 'ust_kategori_id'); }
    public function altKategoriler() { return $this->hasMany(Kategori::class, 'ust_kategori_id'); }
    public function urunler() { return $this->belongsToMany(Urun::class, 'kategori_urun', 'kategori_id', 'urun_id'); }
}