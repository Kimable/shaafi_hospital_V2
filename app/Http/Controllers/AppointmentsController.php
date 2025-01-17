<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointmentsController extends Controller
{

    public function showAppointmentForm()
    {
        $doctors = Doctor::with('user')->get();

        if (!Auth::check()) {
            return view('appointment', ['doctors' => $doctors]);
        }


        return view('user/appointment', ['doctors' => $doctors]);
    }

    public function bookAppointment(Request $request)
    {
        $appointmentCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $appointment = new Appointment();

        if (!Auth::check()) {

            $emailExists = User::where('email', $request->input('email'))->get();
            dd($emailExists);
            if ($emailExists) {
                $appointment->date = $request->input('date');
                $appointment->time = $request->input('time');
                $appointment->gender = $request->input('gender');
                $appointment->medical_issue = $request->input('medical_issue');
                $appointment->description = $request->input('description');
                $appointment->appointment_code = $appointmentCode;
                $appointment->user_id = $emailExists->id;
                $appointment->booked_doctor_id = $request->input('booked_doctor_id');
                $appointment->save();

                // Send confirmation email
                $doctor = User::find($appointment->booked_doctor_id);
                Mail::to($emailExists->email)->send(new AppointmentConfirmation($appointment, $emailExists, $doctor));

                return redirect()->route('appointment.post')->with('success', 'Your appointment was booked successfully! Please check your email for deatails.');
            }


            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->role = 'guest';
            $user->save();

            $appointment->date = $request->input('date');
            $appointment->time = $request->input('time');
            $appointment->gender = $request->input('gender');
            $appointment->medical_issue = $request->input('medical_issue');
            $appointment->description = $request->input('description');
            $appointment->appointment_code = $appointmentCode;
            $appointment->user_id = $user->id;
            $appointment->booked_doctor_id = $request->input('booked_doctor_id');
            $appointment->save();

            // Send confirmation email
            $doctor = User::find($appointment->booked_doctor_id);
            Mail::to($user->email)->send(new AppointmentConfirmation($appointment, $user, $doctor));

            return redirect()->route('appointment.post')->with('success', 'Your appointment was booked successfully! Please check your email for deatails.');
        }

        $user = Auth::user();
        $appointment->date = $request->input('date');
        $appointment->time = $request->input('time');
        $appointment->gender = $request->input('gender');
        $appointment->medical_issue = $request->input('medical_issue');
        $appointment->description = $request->input('description');
        $appointment->appointment_code = $appointmentCode;
        $appointment->user_id = $user->id;
        $appointment->booked_doctor_id = $request->input('booked_doctor_id');
        $appointment->save();

        // Send confirmation email
        $doctor = User::find($appointment->booked_doctor_id);
        Mail::to($user->email)->send(new AppointmentConfirmation($appointment, $user, $doctor));

        return redirect()->route('appointment.post')->with('success', 'Your appointment was booked successfully! Please check your email for deatails.');
    }

    // For Admin
    public function manageAppointments()
    {
        if (!Auth::check()) {
            return view('unauthorized');
        }

        $appointments = Appointment::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin/manageAppointments')->with('appointments', $appointments);
    }

    // Admin
    public function viewAppointment($id)
    {
        if (!Auth::check()) {
            return view('unauthorized');
        }

        $appointment = Appointment::with('user')->find($id);

        $doctor = User::find($appointment->booked_doctor_id);

        if (!$doctor || $appointment->booked_doctor_id == null) {
            $doctor = null;
        }

        return view('admin/viewAppointment', ['appointment' => $appointment, 'doctor' => $doctor]);
    }

    // For doctors
    public function manageAppointmentsDoctors()
    {
        if (!Auth::check()) {
            return view('unauthorized');
        }

        $doctor = Auth::user();

        $appointments = Appointment::all()->where('booked_doctor_id', $doctor->id);
        $users = User::all();

        return view('doctor/manageAppointments', ['appointments' => $appointments, 'users' => $users]);
    }

    public function viewAppointmentDoctors($id)
    {
        if (!Auth::check()) {
            return view('unauthorized');
        }


        $appointment = Appointment::with('user')->find($id);
        // dd($appointment);
        return view('doctor/viewAppointment')->with('appointment', $appointment);
    }

    // All user appointments
    public function appointments()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return view('auth');
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


            return view('user/appointments', ['appointments' => $mergedAppointments]);
        } catch (\Throwable $th) {
            return redirect()->back(['error' => $th->getMessage()], 500);
        }
    }

    // View an appointment for a user
    public function userViewAppointment($id)
    {
        if (!Auth::check()) {
            return view("unauthorized");
        }

        $appointment = Appointment::with('user')->find($id);

        $doctor = User::find($appointment->booked_doctor_id);

        return view('user/viewAppointment', ['doctor' => $doctor, 'appointment' => $appointment]);
    }


    // Book Specific doctor
    public function showSpecificDoctorAppointmentForm($doctorId)
    {

        $doctor = User::with('doctor')->find($doctorId);
        return view('specifiedDoctorAppointment', ['doctor' => $doctor]);
    }

    public function bookAppointmentWithSpecificDoctor(Request $request)
    {
        $appointmentCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $appointment = new Appointment();

        if (!Auth::check()) {
            $checkEmail = User::where('email', $request->input('email'))->exists();

            if (!$checkEmail) {
                $user = new User();
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->email = $request->input('email');
                $user->phone = $request->input('phone');
                $user->role = 'guest';
                $user->save();

                $appointment->date = $request->input('date');
                $appointment->time = $request->input('time');
                $appointment->gender = $request->input('gender');
                $appointment->medical_issue = $request->input('medical_issue');
                $appointment->description = $request->input('description');
                $appointment->appointment_code = $appointmentCode;
                $appointment->user_id = $user->id;
                $appointment->booked_doctor_id = $request->input('booked_doctor_id');

                $appointment->save();
            } else {
                $user = User::where('email', $request->input('email'))->get();
                $appointment->date = $request->input('date');
                $appointment->time = $request->input('time');
                $appointment->gender = $request->input('gender');
                $appointment->medical_issue = $request->input('medical_issue');
                $appointment->description = $request->input('description');
                $appointment->appointment_code = $appointmentCode;
                $appointment->user_id = $user->id;
                $appointment->booked_doctor_id = $request->input('booked_doctor_id');
                $appointment->save();
            }
            return redirect()->route('appointment.post')->with('success', 'Congratulations! Your booking was successful!');
        }

        $user = Auth::user();
        $appointment->date = $request->input('date');
        $appointment->time = $request->input('time');
        $appointment->gender = $request->input('gender');
        $appointment->medical_issue = $request->input('medical_issue');
        $appointment->description = $request->input('description');
        $appointment->appointment_code = $appointmentCode;
        $appointment->user_id = $user->id;
        $appointment->booked_doctor_id = $request->input('booked_doctor_id');
        $appointment->save();

        return redirect()->route('appointment.post')->with('success', 'Congratulations! Your booking was successful!');
    }
}
