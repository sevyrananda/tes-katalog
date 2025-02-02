<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CctvController extends Controller
{
    public function index()
    {
        return view('pages.katalog.cctv');
    }
}
