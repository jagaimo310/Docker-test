<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    //
    public function autocomplete()
    {
        return view('Maps.autocomlete');
    }
}
