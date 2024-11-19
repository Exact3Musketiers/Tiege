<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function uwu()
    {
        return view('textify.uwu');
    }

    public function sarcasm()
    {
        return view('textify.sarcasm');
    }

    public function policy()
    {
        return view('policy');
    }
}
