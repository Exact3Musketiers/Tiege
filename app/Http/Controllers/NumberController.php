<?php

namespace App\Http\Controllers;

class NumberController extends Controller
{
    public function randomIndex()
    {
        return view('numbers.rng');
    }

    public function drivingIndex()
    {
        return view('numbers.driving');
    }
}
