<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolKitController extends Controller
{
    public function index()
    {
        return view('pages.katalog.toolkit');
    }
}
