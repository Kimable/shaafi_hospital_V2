<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VideoConsultConfirmation;
use App\Models\User;
use App\Models\VideoConsult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class APIVideoConsultController extends Controller

{

    // Book a video consult appointment
    public function bookVideoConsult(Request $request)
    {

        try {
            $appointmentCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $user = Auth::user();

            if (!$user) {
                return response()->json(['errorMsg' => "You must be logged in to book an appointment."], 401);
            }

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
        } catch (\Throwable $th) {
            return response()->json(['errorMsg' => $th->getMessage()], 500);
        }
    }
}