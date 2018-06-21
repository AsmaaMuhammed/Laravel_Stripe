<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Plan;
use Stripe\Product;
use Stripe\Stripe;

class RecurringPayment extends Controller
{
    public function getCharge()
    {
        return view('recurring_payment');
    }
    public function createProduct()
    {
        $pubKey = config('services.stripe.key');
        Stripe::setApiKey($pubKey);

        $product = Product::create([
            'name' => 'joining team',
            'type' => 'service',
        ]);
        $plan = Plan::create([
            'currency' => 'usd',
            'interval' => 'month',
            'product' => $product->id,
            'nickname' => 'monthly',
            'amount' => 3000,
        ]);
    }
    public function postCharge(Request $request)
    {
        $pubKey = config('services.stripe.key');
        Stripe::setApiKey($pubKey);
        $user = auth()->user();
        try {
            $user->newSubscription('main', 'plan_D5YWvAQZ1DDHhv')->create($request->stripeToken);
            return 'Subscription successful, you can join the team!';
        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
}
