<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adres extends Model
{
    protected $table = 'adresler';
    protected $guarded = ['id'];

    public function kullanici() { return $this->belongsTo(Kullanici::class, 'kullanici_id'); }
}