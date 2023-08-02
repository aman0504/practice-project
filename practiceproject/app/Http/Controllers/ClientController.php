<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function pdfIndex()
    {
        return view('pdfUpload');
    }

    public function create()
    {
        $clients = Client::latest()->get();
        return view('spatieimage.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $client = Client::create($input);
        if($request->hasFile('image') && $request->file('image')->isValid()){

            $client->addMediaFromRequest('image')->toMediaCollection('image');
        }
        return redirect()->route('spatieimage.create');
    }

}
