<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
                'apiUserId' => env('API_USER_ID'),
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
                    'apiUserId' => env('API_USER_ID'),
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
                return view('user/payment-success');
            }
        } else {
            dd($data);
        }
    }
}
