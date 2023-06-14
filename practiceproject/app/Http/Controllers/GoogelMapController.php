<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogelMapController extends Controller
{
public function index()
{
    return view('map.googlemap');
}
}
