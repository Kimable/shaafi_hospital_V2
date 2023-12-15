<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use KingFlamez\Rave\Facades\Rave as Flutterwave;

class PaymentCtrl extends Controller
{

    public function paymentForm()
    {
        if (!Auth::check()) {
            return view("payment");
        } else {
            return view("user/payment");
        }

    }
    /**
     * Initialize Rave payment process
     */
    public function initialize(Request $request)
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        if (!Auth::check()) {
            $data = [
                'payment_options' => 'card,banktransfer,account,credit,mpesa',
                'amount' => intval($request->input('amount')),
                'email' => $request->input('email'),
                'tx_ref' => $reference,
                'currency' => "USD",
                'redirect_url' => route('callback'),
                'customer' => [
                    'email' => $request->input('email'),
                    "phone_number" => $request->input('phone'),
                    "name" => $request->input('name'),
                ],

                "customizations" => [
                    "title" => 'Medical Fee',
                    "description" => "Medical Fee to Shaafi Hospital"
                ]
            ];
            $payment = Flutterwave::initializePayment($data);
        } else {
            $user = Auth::user();
            // Enter the details of the payment
            $data = [
                'payment_options' => 'card,banktransfer,account,credit,mpesa',
                'amount' => intval($request->input('amount')),
                'email' => $user->email,
                'tx_ref' => $reference,
                'currency' => "USD",
                'redirect_url' => route('callback'),
                'customer' => [
                    'email' => $user->email,
                    "phone_number" => $user->phone,
                    "name" => "$user->first_name $user->last_name"
                ],

                "customizations" => [
                    "title" => 'Medical Fee',
                    "description" => "Medical Fee to Shaafi Hospital"
                ]
            ];
            $payment = Flutterwave::initializePayment($data);

        }

        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return;
        }

        return redirect($payment['data']['link']);
    }

    /**
     * Obtain Rave callback information
     * 
     */
    public function callback(Request $request)
    {

        $status = $request->input('status');
        $transactionExists = Payment::where('transaction_ref', $request->input('tx_ref'))->exists();
        if ($transactionExists) {
            return redirect('/payment');
        }
        //if payment is successful
        if ($status == 'successful') {

            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            $user = Auth::user();



            $paid = new Payment();
            $paid->transaction_ref = $data['data']['tx_ref'];
            $paid->transaction_status = $data['status'];
            $paid->amount = $data['data']['amount'];
            $paid->user_id = $user->id;
            $paid->save();


            return view('user/payment-success', ['data' => $data]);
        } else {
            //Put desired action/code after transaction has failed here
            return view('user/payment-failed');
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }
}
