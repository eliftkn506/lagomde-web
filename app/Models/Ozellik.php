<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ozellik extends Model
{
    protected $table = 'ozellikler';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function degerler() { return $this->hasMany(OzellikDegeri::class, 'ozellik_id'); }
}