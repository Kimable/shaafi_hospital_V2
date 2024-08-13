<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Mailer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function deleteAccount(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        //dd($user);
        if (!$user) {
            return redirect()->back()->with('error', 'No account to be Deleted! Your email does not exist in our databse.');
        }

        $data = [
            'name' => $user->first_name . " " . $user->last_name,
            'email' => $user->email,
        ];

        $mail = new Mailer($data, "Delete Your Account", $request->email);
        $result = Mail::to($request->email)->send($mail);

        return redirect()->back()->with('success', 'Success! An email has been sent to you with the link to delete your accout. In case you cant see your email, please check the spam folder.');
    }
}
