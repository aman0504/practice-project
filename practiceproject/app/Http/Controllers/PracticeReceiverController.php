<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class PracticeReceiverController extends Controller
{

public function index()
{
    return view('receiveEncydata');
}



    // decrypt data which is send by practiceController in $details variable (in array)

    public function getEncyptData(Request $request, $details)
    {
        $details = json_decode(Crypt::decryptString($details), true);

        // dd($details);
        return view('receiveEncydata',['details' => $details ] );
        // return redirect()->route('indexPage', ['details' => $details ]);
    }
}
