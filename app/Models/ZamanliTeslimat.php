<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZamanliTeslimat extends Model
{
    protected $table = 'zamanli_teslimatlar';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function siparis() { return $this->belongsTo(Siparis::class, 'siparis_id'); }
}