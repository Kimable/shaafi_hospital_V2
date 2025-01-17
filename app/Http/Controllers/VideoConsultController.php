<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VideoConsultConfirmation;
use App\Models\User;
use App\Models\VideoConsult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VideoConsultController extends Controller

{
    // Show Video Payment Page

    public function showVideoPaymentPage()
    {
        return view('video_payment');
    }
    // Book a video consult appointment for Mobile API
    public function bookVideoConsult(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }


        $appointmentCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'medical_issue' => 'required',
        ]);

        $appointment = new VideoConsult();
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->medical_issue = $request->medical_issue;
        //$appointment->booked_doctor_id = $request->booked_doctor_id;
        $appointment->appointment_code = $appointmentCode;
        $appointment->user_id = $user->id;
        $appointment->save();

        // Send confirmation email
        //$doctor = User::find($appointment->booked_doctor_id);
        Mail::to($user->email)->send(new VideoConsultConfirmation($appointment, $user));

        return response()->json([
            'message' => 'Appointment booked successfully',
            'appointment' => $appointment
        ], 201);
    }

    // Book a video consult appointment for Website
    public function bookVideoConsultWeb(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('video-consult.post')->with('error', 'You must be logged in to book a video consult');
        }


        $appointmentCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'medical_issue' => 'required',
        ]);

        $appointment = new VideoConsult();
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->medical_issue = $request->medical_issue;
        //$appointment->booked_doctor_id = $request->booked_doctor_id;
        $appointment->appointment_code = $appointmentCode;
        $appointment->user_id = $user->id;
        $appointment->save();

        // Send confirmation email
        //$doctor = User::find($appointment->booked_doctor_id);
        Mail::to($user->email)->send(new VideoConsultConfirmation($appointment, $user));

        return redirect()->route('video-consult.post')->with('success', 'Congratulations! Your booking was successful! Check your email for details.');
    }
}
