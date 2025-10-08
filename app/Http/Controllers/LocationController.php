<?php

namespace App\Http\Controllers;

use App\Models\Location;

class LocationController
{
    public function index()
    {
        return view('location.index');
    }

    public function create()
    {
        $location = new Location();
        
        return view('location.model', ['location' => $location]);
    }

    public function store()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
