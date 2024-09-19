<?php

namespace App\Http\Controllers;

class NumberController extends Controller
{
    public function index()
    {
        return view('numbers.rng');
    }
}
