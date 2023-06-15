<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Stripe\Stripe;
use \Stripe\Customer;
use App\Models\User;
use App\Models\UserCard;
use App\Models\payment;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PaymentController extends Controller
{
    use LivewireAlert;

    private $stripe;
    public function __construct()
    {
        // get api_key
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        // dd($this->stripe);
    }



    public function show()
    {
        $cardDetails =  User::with('userCard', 'payment')->find('1');

        // $cardDetails = UserCard::get();
        // $payments = payment::get();
        if ($cardDetails) {
            return view('stripe.billing', compact('cardDetails'));
        }
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
            ]
        );

        $userHas = UserCard::where('users_id', $user->id)->first();
        if ($userHas) {
            // dd('already exist');
            // charge a stripe customer
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

            $charge = $stripe->charges->create([
                "amount" =>  4000 * 100,
                "currency" => "usd",
                "customer" => $userHas->customer_id,
                "description" => "Do charge a stripe customer",
                "capture" => true,
            ]);
            // dd($chargeCustomer);
            if ($charge) {
                // dd('payment charged');
                $userDetail = payment::where('users_id', $userHas->id)->first();
                // $userDetail->users_id = $user->id;
                $userDetail->amount = $charge->amount;
                $userDetail->customer = $charge->customer;
                $userDetail->balance_transaction = $charge->balance_transaction;
                $userDetail->currency = $charge->currency;
                $userDetail->transaction_id = $charge->id;
                $userDetail->payment_status = $charge->status;
                // $userDetail->user_cards_id =$token->card->id;
                $userDetail->save();
                return redirect()->route('payment.show');
            }


        } else {
            try {
                //key
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

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

                // dd($token,'token');             // using details it will create a unique token 'id'

                // create customer..
                $customer = $stripe->customers->create([
                    'source' => $token['id'],
                    'email' => $user->email,
                    'description' => 'My name is ',
                ]);
                // dd($customer, 'customer');

                //using token 'id' it will create a customer_id, this customer_id used for charge the custmor, or we can perform any strip task with this customer_id

                // customer id..
                $customer_id = $customer['id'];

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
                    "amount" =>  2000 * 100,
                    "currency" => "usd",
                    "customer" => $customer_id,
                    "description" => "My First Test Charge from practice Project",
                    "capture" => true,
                ]);
                // dd($charge);

                if ($charge) {
                    // dd('payment charged');
                    $userDetail = new payment;
                    $userDetail->users_id = $user->id;
                    $userDetail->amount = $charge->amount;
                    $userDetail->customer = $charge->customer;
                    $userDetail->balance_transaction = $charge->balance_transaction;
                    $userDetail->currency = $charge->currency;
                    $userDetail->transaction_id = $charge->id;
                    $userDetail->payment_status = $charge->status;
                    $userDetail->user_cards_id =$token->card->id;
                    $userDetail->save();
                    return redirect()->route('payment.show');
                } else {
                    dd('not charged');
                }

                return redirect()->route('payment.show');
            } catch (\Stripe\Exception\RateLimitException $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Exception\AuthenticationException $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $error = $e->getMessage();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if (@$error) {
                $this->cart_error = $error;
            }
        }
    }



    public function cardEdit($id)
    {
        $userDetails = UserCard::find($id);;

        return view('stripe.updateCard', compact('userDetails'));
    }

    public function updateCard(Request $request, $id)
    {

        $userDetail = UserCard::find($id);

        $userDetail->card_name = $request->card_name;
        $userDetail->card_number = $request->card_number;
        $userDetail->exp_month = $request->exp_month;
        $userDetail->exp_year = $request->exp_year;
        $userDetail->save();

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $updateCard = $stripe->customers->updateSource(
            $userDetail->customer_id,
            $userDetail->card_id,
            [
                'name' => 'Jenny Rosen',
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
            ]
        );

        // dd($updateCard);
        return redirect()->back()->with('success', 'Card updated successfully');
    }

    public function delete($id)
    {
        $userCard = UserCard::find($id);

        // delete card from strip account
        if ($userCard) {
            try {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

                $cardDelete = $stripe->customers->deleteSource(
                    $userCard->customer_id,
                    $userCard->card_id,
                    []
                );

                $userCard->delete();
                // dd($cardDelete);
                return redirect()->back()->with('danger', 'Card deleted successfully');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }
}
