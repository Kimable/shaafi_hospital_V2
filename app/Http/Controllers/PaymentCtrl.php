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

    // payment controller
    public function paymentForm(Request $request)
    {
        $appointment_id = $request->query('appointment_id');
        return view("payment", ['appointment_id' => $appointment_id]);
    }

    public function appointmentPayment(Request $request)
    {
        $appointmentId = $request->input('appointment_id');

        $response = Http::post('https://api.waafipay.net/asm', [
            'schemaVersion' => "1.0",
            'requestId' => random_int(10000000, 99999999),
            'timestamp' => "2024-01-24 Africa",
            'channelName' => "WEB",
            'serviceName' => "API_PREAUTHORIZE",
            'serviceParams' => [
                'merchantUid' => env('MWALLET_MERCHANT_ID'),
                'apiUserId' => env('MWALLET_API_USER_ID'),
                'apiKey' => env('MWALLET_API_KEY'),
                'paymentMethod' => "MWALLET_ACCOUNT",
                'payerInfo' => [
                    'accountNo' => $request->input('phone')
                ],
                'transactionInfo' => [
                    'referenceId' => "REF-" . random_int(100000, 999999),
                    'invoiceId' => "INV-" . random_int(100000, 999999),
                    'amount' => 10,
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
            $commitResponse = Http::post('https://api.waafipay.net/asm', [
                'schemaVersion' => "1.0",
                'requestId' => random_int(10000000, 99999999),
                'timestamp' => "2024-01-24 Africa",
                'channelName' => "WEB",
                'serviceName' => "API_PREAUTHORIZE_COMMIT",
                'serviceParams' => [
                    'merchantUid' => env('MWALLET_MERCHANT_ID'),
                    'apiUserId' => env('MWALLET_API_USER_ID'),
                    'apiKey' => env('MWALLET_API_KEY'),
                    'paymentMethod' => "MWALLET_ACCOUNT",
                    'transactionId' => $data['params']['transactionId'],
                    'description' => "Committed",
                    'referenceId' => $data['params']['referenceId']
                ]
            ]);
            $commitData = $commitResponse->json();


            if ($commitData['errorCode'] != "0") {
                //dd($commitData);
                return redirect('/payment-failed');
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
                $payment->amount = 10;
                $payment->user_id = $userId;
                $payment->appointment_id = $appointmentId;
                $payment->save();

                Mail::to($user->email)->send(new PaymentConfirmation($payment, $user));

                return view('user/payment-success');
            }
        } else {
            //dd($data);
            return redirect('/payment-failed');
        }
    }

    // Video Consult Payment
    public function videoConsultForm(Request $request)
    {
        $videoConsultId = $request->query('video_consult_id');
        return view("pay-video-consult", ['video_consult_id' => $videoConsultId]);
    }


    public function videoConsultPayment(Request $request)
    {
        $videoConsultId = $request->input('video_consult_id');

        $response = Http::post('https://api.waafipay.net/asm', [
            'schemaVersion' => "1.0",
            'requestId' => random_int(10000000, 99999999),
            'timestamp' => "2024-01-24 Africa",
            'channelName' => "WEB",
            'serviceName' => "API_PREAUTHORIZE",
            'serviceParams' => [
                'merchantUid' => env('MWALLET_MERCHANT_ID'),
                'apiUserId' => env('MWALLET_API_USER_ID'),
                'apiKey' => env('MWALLET_API_KEY'),
                'paymentMethod' => "MWALLET_ACCOUNT",
                'payerInfo' => [
                    'accountNo' => $request->input('phone')
                ],
                'transactionInfo' => [
                    'referenceId' => "REF-" . random_int(100000, 999999),
                    'invoiceId' => "INV-" . random_int(100000, 999999),
                    'amount' => 15,
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
            $commitResponse = Http::post('https://api.waafipay.net/asm', [
                'schemaVersion' => "1.0",
                'requestId' => random_int(10000000, 99999999),
                'timestamp' => "2024-01-24 Africa",
                'channelName' => "WEB",
                'serviceName' => "API_PREAUTHORIZE_COMMIT",
                'serviceParams' => [
                    'merchantUid' => env('MWALLET_MERCHANT_ID'),
                    'apiUserId' => env('MWALLET_API_USER_ID'),
                    'apiKey' => env('MWALLET_API_KEY'),
                    'paymentMethod' => "MWALLET_ACCOUNT",
                    'transactionId' => $data['params']['transactionId'],
                    'description' => "Committed",
                    'referenceId' => $data['params']['referenceId']
                ]
            ]);
            $commitData = $commitResponse->json();

            if ($commitData['errorCode'] != "0") {
                return redirect('/payment-failed');
            } else {
                // Save payment details to the database

                if (!$videoConsultId) {
                    return redirect()->back()->with('error', 'Error: Please select a service to pay for');
                }
                $videoConsult = VideoConsult::find($videoConsultId);
                // send email after successful payment
                $userId = $videoConsult->user_id;
                $user = User::find($userId);

                // Update video consult status to paid and save the transaction ID

                $videoConsult->transaction_ref =  $data['params']['transactionId'];
                $videoConsult->amount = 15;
                $videoConsult->user_id = $userId;
                $videoConsult->save();

                Mail::to($user->email)->send(new PaymentConfirmation($videoConsult, $user));
                return view('user/payment-success');
            }
        } else {
            return redirect('/payment-failed');
            //dd($data);
        }
    }
}
