<?php

namespace App\Http\Controllers;

use App\Models\BankInfo;
use App\Models\User;
use Stripe;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Http\Request;

class BankInfoController extends Controller
{
    use LivewireAlert;
    private $stripe;
    public function __construct()
    {
        // get api_key
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function index()
    {
        $user = User::find(1);
        $bankInfo = BankInfo::where('users_id', $user->id)->first();







        return view('connectaccount.bankInfo', compact('bankInfo'));
    }



    public function connectedAccountCreate()
    {
        $error = "";
        $user = User::find(1);

        $bankInfo = BankInfo::where('users_id', $user->id)->first();

        try {
            if (!$bankInfo) {

                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

                //Create an account.....
                $account = $stripe->accounts->create([
                    'type' => 'custom',
                    'country' => 'US',
                    'email' => $user->email,
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                    ],
                ]);


                if (isset($account->id)) {
                    //save bank account..
                    $info = new BankInfo();
                    $info->users_id = $user->id;
                    $info->account_id = $account->id;
                    $info->status = "pending";
                    $info->payouts_enabled = "pending";
                    $info->save();

                    //Create an account link........
                    $link = $stripe->accountLinks->create([
                        'account' => $account->id,
                        'refresh_url' => 'http://127.0.0.1:8000/account/bankInfoError',
                        'return_url' => 'http://127.0.0.1:8000/account/bankInfoSuccess',
                        'type' => 'account_onboarding',
                    ]);

                    return redirect()->to($link->url);
                } else {

                    $error = "Error in account create.";
                }
            } else {
                $error = "Account has already connected with stripe.";
            }

            return redirect()->back()->with('error', $error);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            return redirect()->back()->with('error', $e->getMessage());
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            return redirect()->back()->with('error', $e->getMessage());
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('error', $error);
    }


    public function bankInfoSuccess()
    {
        return redirect()->route('bankinfo.index')->with('succes', 'successs');
    }

    public function bankInfoError()
    {
        return redirect()->route('bankinfo.index')->with('error', 'try again');
    }


    public function saveBankDetails(Request $request)
    {
        $request->validate(
            [
                'account_holder_name' => 'required',
                'account_number' => 'required',
                'routing_number' => 'required',
            ]
        );

        $user = User::find(1);
        $bankInfo = BankInfo::where('users_id', $user->id)->first();
        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

            //Create a bank account ...
            $bankAccount = $stripe->accounts->createExternalAccount(
                $bankInfo->account_id,
                [
                    'external_account' => [
                        "currency" => "usd",
                        "country" => "us",
                        "object" => "bank_account",
                        "account_holder_name" => $request->account_holder_name,
                        "routing_number" => $request->routing_number,
                        "account_number" => $request->account_number,
                    ]
                ],
            );

            if ($bankAccount) {
                BankInfo::where('id', $bankInfo->id)->update([
                    "account_holder_name" => $request->account_holder_name,
                    "account_number" => $request->account_number,
                    "routing_number" => $request->routing_number,
                ]);
            }

            $this->flash('success', 'Your bank details are added successfully');
            return redirect()->back();
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            return redirect()->back()->with('error', $e->getMessage());
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            return redirect()->back()->with('error', $e->getMessage());
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    /**
     * save bank detail delete.
     */
    public function connectedAccountDelete()
    {
        $user = User::find(1);
        BankInfo::where(['users_id' => $user->id])->delete();

        // need to use delete account api for stripe according to situation.....
        $this->flash('success', 'Your bank details deleted successfully');
        return redirect()->back();
    }

    // update bank details......
    public function connectedAccountUpdate()
    {

    }
}
