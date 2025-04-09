<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Razorpay\Api\Api;
use Session;  

class RazorpayController extends Controller
{
    public function index()

    {
        return view('razorpayView');
    }

    public function store(Request $request)
    {
        $api = new Api(config('rzp_test_h0AzufwoRok6hc'),config('JRyz7Mm008aj1yOIQzRMbdoO'));
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if($payment->status == 'authorized')
        {
            $payment->capture(['amount'=>$payment->amount]);
            return back()->with('success','payment successfully');
        }

        return back()->with('error','payment failed');

    }

}
