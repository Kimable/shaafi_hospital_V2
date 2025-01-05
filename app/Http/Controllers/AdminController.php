<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAdminDashboard()
    {
        if (!Auth::check()) {
            return view('auth');
        }

        if (Auth::user()->role !== "admin") {
            return view('unauthorized');
        }

        $user = Auth::guard('admin')->user();
        $messages = ContactForm::all();
        $appointments = Appointment::all();
        return view('admin/dashboard', ['user' => $user, 'messages' => $messages, 'appointments' => $appointments]);
    }

    // Admin Doctor Logic
    public function showManageDoctors()
    {
        if (!Auth::check()) {
            return view('auth');
        }

        if (Auth::user()->role !== 'admin') {
            return view('unauthorized');
        }

        $doctors = Doctor::with('user')->get();
        return view('admin/manageDoctors', ['doctors' => $doctors]);
    }

    public function showAddDoctor()
    {
        if (!Auth::check()) {
            return view('auth');
        }
        if (Auth::user()->role != 'admin') {
            return view('unauthorized');
        }

        return view("admin/addDoctor");
    }

    public function addDoctor(Request $request)
    {
        if (!Auth::check()) {
            return view('auth');
        }


        if (Auth::user()->role != 'admin') {
            return view("unauthorized");
        }

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'qualifications' => 'nullable',
            'specialty' => 'required',
            'languages' => 'required',
            'description' => 'nullable',
        ]);

        $user = new User();
        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name");
        $user->email = $request->input("email");
        $user->phone = $request->input("phone");
        $user->avatar = '/uploads/doctor-illustration.jpg';
        $user->role = 'doctor';
        $user->save();


        $doctor = new Doctor();
        $doctor->qualifications = $request->input('qualifications');
        $doctor->specialty = $request->input('specialty');
        $doctor->languages = $request->input('languages');
        $doctor->description = $request->input('description');
        $doctor->user_id = $user->id;
        $doctor->save();

        return redirect()->route('admin/add-doctor')->with('success', "Doctor added successfully!");
    }

    // Delete a doctor
    public function showDeleteDoctor($id)
    {
        if (!Auth::check()) {
            return view('auth');
        }

        if (Auth::user()->role != 'admin') {
            return view("unauthorized");
        }
        $doctor = User::find($id);
        return view('admin/deleteDoctor')->with('doctor', $doctor);
    }

    public function deleteDoctor($id)
    {
        if (!Auth::check()) {
            return view('auth');
        }

        if (Auth::user()->role != 'admin') {
            return view("unauthorized");
        }

        $doctor = User::find($id);

        if (!$doctor) {
            return redirect()->route('admin/manage-doctors')->with('error', 'Doctor not found.');
        }

        $doctor->delete();

        return redirect()->route('admin/manage-doctors')->with('success', 'Doctor deleted successfully.');
    }

    // Update a doctor
    public function showEditDoctor($id)
    {
        if (!Auth::check()) {
            return view('auth');
        }

        if (Auth::user()->role != 'admin') {
            return view("unauthorized");
        }

        $doctor = User::with('doctor')->find($id);

        return view('admin/editDoctor')->with('doctor', $doctor);
    }

    public function editDoctor(Request $request, $id)
    {
        if (!Auth::check()) {
            return view('auth');
        }


        if (Auth::user()->role != 'admin') {
            return view("unauthorized");
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
        $doctor->specialty = $request->input('specialty');
        $doctor->qualifications = $request->input('qualifications');
        $doctor->languages = $request->input('languages');
        $doctor->description = $request->input('description');
        $doctor->save();


        return redirect()->route('admin/manage-doctors')->with('success', 'Doctor updated successfully.');
    }
}
