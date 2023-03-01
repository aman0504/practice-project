<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detail;
use Illuminate\Support\Facades\Crypt;

class PracticeController extends Controller
{

    public function index1()
    {

        return view('googleautofiller');
    }


    //Encrypt Decrypt code practice

    public function create(Request $request)
    {

        $userDetail = new Detail;
        $userDetail->name = $request->name;
        // dd($userDetail->name);
        $userDetail->email = $request->email;
        $userDetail->code = $request->code;
        // $userDetail->save();
           //its optial if u donot want to save in db , u can directly send data through URL in encrypted form

        $encrypted = Crypt::encryptString(json_encode($userDetail));
        // dd($encrypted);
        return redirect()->route('getEncyptData', ['details' => $encrypted]);
        // return back();
    }


// increment decrement page

public function incDecr()
{
    return view('increment');
}


}
