<?php

namespace App\Http\Controllers;

use App\Models\UserAlpine;
use Illuminate\Http\Request;

class UserAlpineController extends Controller
{
    public function index()
    {
        return view('alpine.index');
    }
    public function create(Request $request)
    {
        $user = new UserAlpine;
        $user->
    }
}
