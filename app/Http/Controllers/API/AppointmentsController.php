<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    public function bookAppointment(Request $request)
    {
        try {
            $appointmentCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $user = Auth::user();

            if (!$user) {
                return response()->json(['errorMsg' => "You must be logged in to book an appointment."], 401);
            }

            $appointment = new Appointment();

            $appointment->date = $request->input('date');
            $appointment->time = $request->input('time');
            $appointment->gender = $request->input('gender');
            $appointment->medical_issue = $request->input('medical_issue');
            $appointment->description = $request->input('description');
            $appointment->appointment_code = $appointmentCode . $user->id;
            $appointment->user_id = $user->id;
            $appointment->booked_doctor_id = $request->input('booked_doctor_id');
            $appointment->save();

            return response()->json(['successMsg' => 'Your appointment was booked successfully!'], 201);
        } catch (\Throwable $th) {
            return response()->json(['errorMsg' => $th->getMessage()], 500);
        }
    }

    public function appointments()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['errorMsg' => "You must be logged in to see appointments."], 401);
            }

            $appointments = Appointment::orderBy('created_at', 'desc')->where('user_id', $user->id)->get();
            $doctors = User::with('doctor')->where('role', 'doctor')->get();

            // Extract doctor IDs from the appointments
            $doctorIds = $appointments->pluck('booked_doctor_id')->unique()->toArray();

            // Filter doctors based on the extracted doctor IDs
            $filteredDoctors = $doctors->whereIn('id', $doctorIds);

            $mergedAppointments = $appointments->map(function ($appointment) use ($filteredDoctors) {
                $doctor = $filteredDoctors->firstWhere('id', $appointment->booked_doctor_id);
                return [
                    'appointment' => $appointment,
                    'doctor' => $doctor,
                ];
            });



            if ($appointments->count() === 0) {
                return response()->json(['errorMsg' => "You have no appointmets yet!", "status" => 404], 404);
            }


            return response()->json(['appointments' => $mergedAppointments], 200);
        } catch (\Throwable $th) {
            return response()->json(['errorMsg' => $th->getMessage()], 500);
        }
    }
}
