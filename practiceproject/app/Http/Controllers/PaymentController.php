<?php

namespace App\Http\Controllers;

use App\Models\BankInfo;
use Illuminate\Http\Request;
use \Stripe\Stripe;
use \Stripe\Customer;
use App\Models\User;
use App\Models\UserCard;
use App\Models\payment;
use Stripe\Transfer;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PaymentController extends Controller
{
    use LivewireAlert;

    private $stripe;
    public $amountCharged;

    public function __construct()
    {
        // get api_key
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function show()
    {

        $cardDetails =  User::with('userCard', 'payment')->first();
        // dd($cardDetails->toArray());
        return view('stripe.billing', compact('cardDetails'));
    }


    public function getCardDetails(Request $request)
    {
        $user = User::find(3);

        $request->validate(
            [
                'card_name' => 'required',
                'card_number' => 'required|numeric|digits:16',
                'exp_month' => 'required',
                'exp_year' => 'required',
                'cvv' => 'required|numeric|digits_between:3,4',
            ]
        );

        $isUserCardSaved = UserCard::where('users_id', $user->id)->first();
        if ($isUserCardSaved) {

            try {
                // charge a stripe customer..... card already saved
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

                $charge = $stripe->charges->create([
                    "amount" =>  4000 * 100,        // Convert amount to cents
                    "currency" => "usd",
                    "customer" => $isUserCardSaved->customer_id,    //fetch from db bcz already exist
                    "description" => "Do charge a stripe customer",
                    "capture" => true,
                ]);

                $userDetail = payment::where('users_id', $isUserCardSaved->users_id)->first();
                // $userDetail->users_id = $user->id;
                $userDetail->amount = $charge->amount;
                $userDetail->customer = $charge->customer;
                $userDetail->balance_transaction = $charge->balance_transaction;
                $userDetail->currency = $charge->currency;
                $userDetail->transaction_id = $charge->id;
                $userDetail->payment_status = $charge->status;
                // $userDetail->user_cards_id =$token->card->id;
                $userDetail->save();


                //......................//.......................//......................
                // Retrieve the customer and seller details
                // $customer = Customer::where('email', $customerEmail)->first();
                // $seller = BankInfo::where('users_id', $isUserCardSaved->users_id)->first(); // Replace with the appropriate logic to fetch the seller

                // // Create a transfer from the charge to the seller's account
                // $transfer = Transfer::create([
                //     'amount' => $charge->amount,
                //     'currency' => 'usd',
                //     'source_transaction' => $charge->id,
                //     'destination' => $seller->account_id,
                // ]);

                // // dd($transfer , 'transfer');
                // $adminGetPayment = payment::where('users_id', $isUserCardSaved->users_id)->first();
                // $adminGetPayment->admin_getpaymenttransfer_id =$transfer->id;
                // $adminGetPayment->status = 'admin_payment';
                // $adminGetPayment->save();

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
        } else {
            try {
                //api key....
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
                // using details it will create a unique token 'id'

                // create customer.....
                $customer = $stripe->customers->create([
                    'source' => $token['id'],
                    'email' => $user->email,
                    'description' => 'My name is ',
                ]);

                //using token 'id' it will create a customer_id, this customer_id used for charge the custmor, or we can perform any strip task with this customer_id

                // customer id......
                $customer_id = $customer['id'];

                // save user card details.....
                $userCard = new UserCard;
                $userCard->users_id = $user->id;
                $userCard->customer_id = $customer_id;
                $userCard->card_id = $token->card->id;
                $userCard->card_name = $request->card_name;
                $userCard->card_number = $token->card->last4;
                $userCard->exp_month = $token->card->exp_month;
                $userCard->exp_year = $token->card->exp_year;
                $userCard->save();

                //charge payment.....
                $charge = $stripe->charges->create([
                    "amount" =>  4 * 100,   // Convert amount to cents
                    "currency" => "usd",
                    "customer" => $customer_id,
                    "description" => "My First Test Charge from practice Project",
                    "capture" => true,
                ]);

                $this->amountCharged = $charge->amount;

                $userPayments = new payment;
                $userPayments->users_id = $user->id;
                $userPayments->amount = $charge->amount;
                $userPayments->customer = $charge->customer;
                $userPayments->balance_transaction = $charge->balance_transaction;
                $userPayments->currency = $charge->currency;
                $userPayments->transaction_id = $charge->id;
                $userPayments->payment_status = $charge->status;
                $userPayments->user_cards_id = $token->card->id;
                $userPayments->save();

                //......................//.......................//......................
                // Retrieve the customer and seller details
                // $customer = Customer::where('email', $customerEmail)->first();
                // $seller = BankInfo::where('users_id', $isUserCardSaved->users_id)->first(); // Replace with the appropriate logic to fetch the seller

                // Create a transfer from the charge to the seller's account
                // $transfer = Transfer::create([
                //     'amount' => $charge->amount,
                //     'currency' => 'usd',
                //     'source_transaction' => $charge->id,
                //     'destination' => $seller->account_id,
                // ]);

                // // dd($transfer , 'transfer');
                // $adminGetPayment = payment::where('users_id', $isUserCardSaved->users_id)->first();
                // $adminGetPayment->admin_getpaymenttransfer_id =$transfer->id;
                // $adminGetPayment->status = 'admin_payment';
                // $adminGetPayment->save();

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
        $userCardDetails = UserCard::find($id);

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $updateCard = $stripe->customers->updateSource(
            $userCardDetails->customer_id,
            $userCardDetails->card_id,
            [
                'name' => 'Jenny Rosen',
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
            ]
        );
        $userCardDetails->card_name = $request->card_name;
        $userCardDetails->card_number = $request->card_number;
        $userCardDetails->exp_month = $request->exp_month;
        $userCardDetails->exp_year = $request->exp_year;
        $userCardDetails->save();
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
                return redirect()->back()->with('danger', 'Card deleted successfully');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }

    // Retrieve a refund
    public function refundCharges($id)
    {
        $paymentDetail = payment::find($id);

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        //Create a refund..
        $createRefund = $stripe->refunds->create([
            'charge' => $paymentDetail->transaction_id,
        ]);

        //Retrieve a refund.....
        $amountRefund = $stripe->refunds->retrieve(
            $createRefund->id,
            []
        );

        dd($amountRefund);
    }


    //stripe admin transfer(payout) to worker(in connect account).....
    public function payByAdminToWorker()
    {
        $user = User::find(3);
        $userCard = UserCard::where('users_id', $user->id)->first();
        // Retrieve the customer and seller details
        // $customer = Customer::where('email', $customerEmail)->first();
        $userPayment = payment::where('users_id', $userCard->users_id)->first();
        $seller = BankInfo::where('users_id', $userCard->users_id)->first(); // Replace with the appropriate logic to fetch the seller

        try {
            // Create a transfer from the charge to the seller's account
            $transfer = Transfer::create([
                'amount' => 1 * 100,
                'currency' => 'usd',
                'source_transaction' => $userPayment->transaction_id,
                'destination' => $seller->account_id,
            ]);

            $adminGetPayment = payment::where('users_id', $userCard->users_id)->first();
            $adminGetPayment->admin_getpaymenttransfer_id = $transfer->id;
            $adminGetPayment->status = 'admin_payout_done';
            $adminGetPayment->save();
            // dd($adminGetPayment, 'transfer');

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
            dd( $this->cart_error);
        }
    }
}
