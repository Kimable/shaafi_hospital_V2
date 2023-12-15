<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactFormController extends Controller
{
    public function sendMessage(Request $request)
    {
        $user = Auth::user();



        //ContactForm::create();

    }
}
