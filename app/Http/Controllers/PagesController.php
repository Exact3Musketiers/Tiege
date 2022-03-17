<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function uwu()
    {
        return view('textify.uwu');
    }

    public function policy()
    {
        return view('policy');
    }
}
