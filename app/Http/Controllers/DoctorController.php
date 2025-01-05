<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    // General Doctor Logic
    public function showDoctors()
    {
        $doctors = Doctor::with('user')->get();

        return view('doctors', ['doctors' => $doctors]);
    }

    public function showSingleDoctor($id)
    {
        $user = User::with('doctor')->find($id);

        $doctor = $user->toArray();

        if (Auth::check() && Auth::user()->role == 'admin') {
            return view("admin/viewDoctor", ['doctor' => $doctor]);
        }

        return view("singleDoctor", ['doctor' => $doctor]);
    }

    public function doctorDashboard()
    {
        if (!Auth::check()) {
            return view('auth');
        }

        $doctor = Auth::user();
        if ($doctor->role !== 'doctor') {
            return view('doctor/auth');
        }

        if ($doctor) {
            $appointments = Appointment::all()->where('user_id', $doctor->id);
            return view('doctor/doctorDashboard', ['doctor' => $doctor, 'appointments' => $appointments]);
        }
    }

    public function doctorLogin()
    {
        return view('user/login');
    }

    public function doctorProfile()
    {

        if (Auth::user()->role !== 'doctor') {
            return view('doctor/auth');
        }

        $doctor = Auth::user();
        $doctorInfo = Doctor::where('user_id', $doctor->id)->first();

        return view('doctor/doctorProfile', ['doctor' => $doctor, 'doctorInfo' => $doctorInfo]);
    }


    public function showUpdateDoctorProfile($id)
    {
        if (Auth::user()->role !== 'doctor') {
            return view('doctor/auth');
        }
        $doctor = User::find($id);
        return view('doctor/updateProfile')->with('doctor', $doctor);
    }


    public function updateDoctorProfile(Request $request, $id)
    {

        if (Auth::user()->role !== 'doctor') {
            return view('doctor/auth');
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin/manage-doctors')->with('error', 'Doctor not found.');
        }


        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'specialty' => 'required',
            'qualifications' => 'nullable',
            'languages' => 'required',
            'description' => 'nullable',
        ]);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->save();

        $doctor = Doctor::where('user_id', $user->id)->first();
        // Update doctor profile
        $doctor->specialty = $request->input('specialty');
        $doctor->qualifications = $request->input('qualifications');
        $doctor->languages = $request->input('languages');
        $doctor->description = $request->input('description');
        $doctor->save();

        return redirect()->route("doctor-profile")->with('success', 'Profile updated successfully.');
    }

    // Book Specific doctor
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
