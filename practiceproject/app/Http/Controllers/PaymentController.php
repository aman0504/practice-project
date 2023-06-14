<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Stripe\Stripe;
// use \Stripe\Customer;
use App\Models\User;
use App\Models\UserCard;

class PaymentController extends Controller
{


    private $stripe;
    public function __construct()
    {
        // get api_key
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        // $this->stripe = new StripeClient(config('services.stripe.secret'));
        // dd($this->stripe);
    }



    public function show()
    {
        // $this->createCustomer();

        return view('stripe.billing');
    }


    public function getCardDetails(Request $request)
    {
        $user = User::where('id', 1)->first();

        $request->validate(
            [
                'card_name' => 'required',
                'card_number' => 'required|numeric|digits:16',
                'exp_month' => 'required',
                'exp_year' => 'required',
                'cvv' => 'required|numeric|digits_between:3,4',
            ]);
                // dd($request);
            //key
        //    $stripe =  $this->stripe;
           $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                // dd($stripe);

            //.. create a card token...
            $token = $stripe->tokens->create([
                'card' => [
                    'name' => $request->card_name,
                    'number' => $request->card_number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvv,
                ],
            ]);

            // dd($token,'token');

            // create customer..
            $customer = $stripe->customers->create([
                'source' => $token['id'],
                'email' => $user->email,
                'description' => 'My name is ',
            ]);
                // dd($customer, 'customer');

                // customer id..
                $customer_id = $customer['id'];

        //    dd($customer_id);

            // save user card details
            $customerDetails = new UserCard;
            $customerDetails->users_id = $user->id;
            $customerDetails->customer_id = $customer_id;
            $customerDetails->card_id = $token->card->id;
            $customerDetails->card_name = $request->card_name;
            $customerDetails->card_number = $token->card->last4;
            $customerDetails->exp_month = $token->card->exp_month;
            $customerDetails->exp_year = $token->card->exp_year;
            $customerDetails->save();

             //charge payment
             $charge = $stripe->charges->create([
                "amount" =>  2000 ,
                "currency" => "usd",
                "customer" => $customer_id,
                "description" => "My First Test Charge from practice Project",
                "capture" => true,
            ]);

            // dd($charge);
            if($charge){
                    dd('payment charged');
            }
            else{
                dd('not charged');
            }



    }







}
