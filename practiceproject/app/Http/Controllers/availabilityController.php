<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class availabilityController extends Controller
{

    public function index()
    {
        // $weekDays = [0,1,4,5,6];       // when we send in integer form then lockDayFilter work , not working on string '1' data.

        $featchingDaysinArrayForm = Availability::pluck('day')->toArray();
// dd($featchingDaysinArrayForm);
        // $featchingDaysinArrayForm=   array('Thursday', 'Friday');
        $dayArry = [];

        foreach ($featchingDaysinArrayForm as $day) {
            array_push($dayArry, (int) date('w', strtotime($day)));
        }
        // dd($dayArry);

        //    return $this->getData();

        return view('availability', ['dayArray' => $dayArry]);
    }

    function getDay(Request $request)
    {
        dd($request->date);
        // session(['date' => $request->date]);


        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );

        return \Response::json($response);

    }


    public function showpicker()
    {
        return view('showLitepicker');
    }
    public function enableSelectedDates()
    {
        return view('showLitepicker');
    }

}
