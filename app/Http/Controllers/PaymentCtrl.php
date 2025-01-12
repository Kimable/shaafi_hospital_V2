<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\PaymentConfirmation;
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
        if (!Auth::check()) {
            return view("payment");
        } else {
            return view("user/payment");
        }
    }
    /**
     * Start payment process
     */
    public function pay(Request $request)
    {
        $response = Http::post('https://api.waafipay.net/asm', [
            'schemaVersion' => "1.0",
            'requestId' => random_int(10000000, 99999999),
            'timestamp' => "2024-01-24 Africa",
            'channelName' => "WEB",
            'serviceName' => "API_PREAUTHORIZE",
            'serviceParams' => [
                'merchantUid' => env('MERCHANT_UID'),
                'apiUserId' => (int) env('API_USER_ID'),
                'apiKey' => env('WAAFI_API_KEY'),
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
            $commitResponse = Http::post('https://api.waafipay.net/asm', [
                'schemaVersion' => "1.0",
                'requestId' => random_int(10000000, 99999999),
                'timestamp' => "2024-01-24 Africa",
                'channelName' => "WEB",
                'serviceName' => "API_PREAUTHORIZE_COMMIT",
                'serviceParams' => [
                    'merchantUid' => env('MERCHANT_UID'),
                    'apiUserId' => (int) env('API_USER_ID'),
                    'apiKey' => env('WAAFI_API_KEY'),
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
                $videoConsultID = $request->input('video_consult_id');
                if (!$videoConsultID) {
                    return redirect()->back()->with('error', 'Error: Please select a service to pay for');
                }
                $bookedVideoConsult = VideoConsult::find($videoConsultID);
                // Update video consult status to paid and save the transaction ID
                $bookedVideoConsult->payment_id = $data['params']['transactionId'];
                $bookedVideoConsult->save();

                // send email after successful payment
                $userId = $bookedVideoConsult->user_id;
                $user = User::find($userId);

                Mail::to($user->email)->send(new PaymentConfirmation($bookedVideoConsult, $user));

                return view('user/payment-success');
            }
        } else {
            dd($data);
        }
    }
}
