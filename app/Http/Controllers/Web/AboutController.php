<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        // kalau nanti mau tarik Setting/skills dari DB, tinggal kirimkan di sini
        return view('about');
    }
}
