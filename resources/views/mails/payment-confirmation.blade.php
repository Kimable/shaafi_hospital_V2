<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body
        style="
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        "
    >
        <div
            style="
                background-color: #00a551;
                color: white;
                padding: 20px;
                text-align: center;
                border-radius: 5px 5px 0 0;
            "
        >
            <h1 style="margin: 0; font-size: 24px">Payment Successful!</h1>
        </div>

        <div
            style="
                background-color: #f9f9f9;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 0 0 5px 5px;
            "
        >
            <p style="margin: 0 0 15px 0; font-weight: 700">
                Dear {{ $user->first_name }} {{ $user->last_name }},
            </p>

            <p style="margin: 0 0 15px 0">
                Your payment has been received and your appointment booked
                successfully. You can use the transaction ID below as proof of payment.
            </p>

            <div
                style="
                    font-size: 24px;
                    color: #00a551;
                    text-align: center;
                    margin: 20px 0;
                    padding: 15px;
                    background-color: #fff;
                    border-radius: 5px;
                "
            >
                Transaction Id: {{ $payment->transaction_ref }}
            </div>

            <p style="margin: 0 0 15px 0">
                If you have any questions or need to make changes to your
                appointment, please contact our support team at
                info@shaafihsoptital.so
            </p>
        </div>

        <div
            style="
                text-align: center;
                margin-top: 20px;
                font-size: 12px;
                color: #666;
            "
        >
            <p style="margin: 0 0 5px 0">
                This is an automated message, please do not reply to this email.
            </p>
            <p style="margin: 0">
                © {{ date("Y") }} Shaafi Hospital. All rights reserved.
            </p>
        </div>
    </body>
</html>
