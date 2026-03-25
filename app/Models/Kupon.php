<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kupon extends Model
{
    protected $table = 'kuponlar';
    protected $guarded = ['id'];

    public function siparisler() { return $this->hasMany(Siparis::class, 'kupon_id'); }
}