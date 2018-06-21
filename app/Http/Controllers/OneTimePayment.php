<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Stripe;

class OneTimePayment extends Controller
{
     public function getCharge()
     {
         return view('one_time_payment');
     }
    public function postCharge(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $customer = Customer::create([
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ]);
            Charge::create([
                'customer' => $customer->id,
                'amount' => '100',
                'currency' => 'usd'
            ]);
            return 'Charge successful, you can join the team!';
        }
        catch (Card $e)
        {
            $body = $e->getJsonBody();
            $err = $body['error'];
            return $err;
        }
    }
}
