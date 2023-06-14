<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;

class availabilityController extends Controller
{

    public $days;

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


    public function selectIndex(Request $request)
    {

        // $values = Availability::get();

        $values = Availability::where([
            ['day', '!=', Null],
            [function ($query) use ($request) {
                if (($search = $request->search)) {
                    $query->orWhere('day', 'LIKE', '%' . $search . '%')
                        ->get();
                }
            }]
        ])->get();

        return view('select2.multi-select', compact('values'));
    }

    public function selectMultiple(Request $request)
    {
        $days = new Availability;

        //json_encode used to convert array into string to store data in db
        $days->day = json_encode($request->day);

        $days->save();
        Mail::to("receiver@example.com")->send(new DemoEmail($days));
        return back();
    }
}
