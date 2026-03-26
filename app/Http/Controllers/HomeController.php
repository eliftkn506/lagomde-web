<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index()
    {
        // Vitrin: üst seviye kategorilerden ilk 7 tanesi
        $vitrinKategorileri = Kategori::whereNull('ust_kategori_id')->take(7)->get();

        return view('welcome', compact('vitrinKategorileri'));
    }
}