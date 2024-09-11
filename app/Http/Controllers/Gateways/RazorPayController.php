<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Razorpay\Api\Api;

class RazorPayController extends Controller
{
    public function payment(Request $request)
    {
        /*Call the Instance of Api*/
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        /*Pass the value of razorpay_payment_id from request*/
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        /*Check if  razorpay_payment_id */
        if($request->has('razorpay_payment_id') && $request->filled('razorpay_payment_id')){
            try {
                $response = $api->payment->fetch($request->razorpay_payment_id)
                    ->capture(['amount' => $payment['amount']]);

            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
        //dd($response);

        /*Check the status from response */
        if($response['status'] == 'captured'){
            return 'Payment Success!';
        }
    }

}
