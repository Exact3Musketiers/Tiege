<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LastfmController extends Controller
{
    public function index()
    {
        return view('lastfm.index');
    }
}
