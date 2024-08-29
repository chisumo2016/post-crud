<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function payment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" =>  $request->price //'1000.00'
                    ]
                ]
            ]
        ]);

        //dd($response);

        /**Checking Id is exist*/
        if (isset($response['id']) && $response['id'] != null){
            /**looping  links*/
            foreach ($response['links'] as $link){
                /**checking if rel is approved*/
                if ($link['rel'] == 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else{
            return redirect()->route('payment.cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        //dd($response);
        /**Checking the status and complete*/
        if (isset($response['status']) && $response['status'] == 'COMPLETED'){
            return 'Paid Successfully';
        }

        return  redirect()->route('paypal.cancel');
        //dd($request->all());
    }

    public function cancel()
    {
        return 'Payment failed';
    }
}
