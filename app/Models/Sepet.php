<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sepet extends Model
{
    protected $table = 'sepetler';
    protected $guarded = ['id'];

    public function kullanici() { return $this->belongsTo(Kullanici::class, 'kullanici_id'); }
    public function kalemler() { return $this->hasMany(SepetKalemi::class, 'sepet_id'); }
}