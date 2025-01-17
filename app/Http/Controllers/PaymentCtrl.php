<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\PaymentConfirmation;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\User;
use App\Models\VideoConsult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PaymentCtrl extends Controller
{

    public function paymentForm()
    {

        return view("payment");
    }
    /**
     * Start payment process
     */
    public function pay(Request $request)
    {
        dd($request->input('video_consult_id'));
    }

    public function appointmentPayment(Request $request)
    {
        $appointmentId = $request->input('appointment_id');
        dd($request->all(), $request->appointment_id);

        $response = Http::post('https://sandbox.waafipay.net/asm', [
            'schemaVersion' => "1.0",
            'requestId' => random_int(10000000, 99999999),
            'timestamp' => "2024-01-24 Africa",
            'channelName' => "WEB",
            'serviceName' => "API_PREAUTHORIZE",
            'serviceParams' => [
                'merchantUid' => "M0912269",
                'apiUserId' => "1000297",
                'apiKey' => "API-1901083745AHX",
                'paymentMethod' => "MWALLET_ACCOUNT",
                'payerInfo' => [
                    'accountNo' => $request->input('phone')
                ],
                'transactionInfo' => [
                    'referenceId' => "REF-" . random_int(100000, 999999),
                    'invoiceId' => "INV-" . random_int(100000, 999999),
                    'amount' => $request->input('amount'),
                    'currency' => "USD",
                    'description' => "wan diray",
                    'paymentBrand' => "WAAFI / ZAAD / SAHAL / EVCPLUS / VISA/MASTERCARD",
                    'transactionCategory' => "ECOMMERCE / AIRLINE/ APPOINTMENTS "
                ]
            ]
        ]);

        // Get the response body as an array
        $data = $response->json();

        if ($data['errorCode'] == "0") {
            // Commit Transaction
            $commitResponse = Http::post('https://sandbox.waafipay.net/asm', [
                'schemaVersion' => "1.0",
                'requestId' => random_int(10000000, 99999999),
                'timestamp' => "2024-01-24 Africa",
                'channelName' => "WEB",
                'serviceName' => "API_PREAUTHORIZE_COMMIT",
                'serviceParams' => [
                    'merchantUid' => "M0912269",
                    'apiUserId' => "1000297",
                    'apiKey' => "API-1901083745AHX",
                    'paymentMethod' => "MWALLET_ACCOUNT",
                    'transactionId' => $data['params']['transactionId'],
                    'description' => "Committed",
                    'referenceId' => $data['params']['referenceId']
                ]
            ]);
            $commitData = $commitResponse->json();


            if ($commitData['errorCode'] != "0") {
                dd($commitData);
            } else {
                // Save payment details to the database

                if (!$appointmentId) {
                    return redirect()->back()->with('error', 'Error: Please select a service to pay for');
                }
                $appointment = Appointment::find($appointmentId);
                // send email after successful payment
                $userId = $appointment->user_id;
                $user = User::find($userId);

                // Update video consult status to paid and save the transaction ID
                $payment = new Payment();
                $payment->transaction_ref =  $data['params']['transactionId'];
                $payment->transaction_status = 'paid';
                $payment->amount = $request->input('amount');
                $payment->user_id = $userId;
                $payment->appointment_id = $appointmentId;
                $payment->save();

                Mail::to($user->email)->send(new PaymentConfirmation($appointment, $user));

                return view('user/payment-success');
            }
        } else {
            dd($data);
        }
    }
}
