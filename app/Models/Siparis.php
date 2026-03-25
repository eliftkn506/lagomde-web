<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siparis extends Model
{
    protected $table = 'siparisler';
    protected $guarded = ['id'];

    public function kullanici() { return $this->belongsTo(Kullanici::class, 'kullanici_id'); }
    public function teslimatAdresi() { return $this->belongsTo(Adres::class, 'teslimat_adresi_id'); }
    public function faturaAdresi() { return $this->belongsTo(Adres::class, 'fatura_adresi_id'); }
    public function kupon() { return $this->belongsTo(Kupon::class, 'kupon_id'); }
    
    public function kalemler() { return $this->hasMany(SiparisKalemi::class, 'siparis_id'); }
    public function zamanliTeslimat() { return $this->hasOne(ZamanliTeslimat::class, 'siparis_id'); }
}