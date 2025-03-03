<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ContactForm;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showDashboard()
    {
        if (!Auth::check()) {
            return view('auth');
        }

        // Check if its Admin
        $user = Auth::user();
        if ($user->role == 'admin') {
            $messages = ContactForm::where('read', false);
            $appointments = Appointment::where('status', 'in_progress');
            return view('admin/dashboard', ['user' => $user, 'messages' => $messages, 'appointments' => $appointments]);
        }

        if ($user->role == 'doctor') {
            $messages = ContactForm::all()->where('read', false);
            $appointments = Appointment::where('booked_doctor_id', $user->id)->get();


            return view('doctor/doctorDashboard', ['user' => $user, 'messages' => $messages, 'appointments' => $appointments]);
        }

        return view('user/dashboard')->with('user', $user);
    }

    /**
     * Show the form for admin Registration.
     */
    public function showRegistrationForm()
    {
        return view('user/register');
    }


    public function Registration(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'nullable',
        ]);

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = $request->input('password');
        $user->avatar = '/uploads/avatar-min.jpg';

        $user->save();
        // log in the user after registration 
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    // User Login
    public function showLoginForm()
    {
        return view('user/login');
    }

    public function Login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        //dd($user);
        if (!$user) {
            return redirect()->back()->with('error', 'Your email does not exist in our databse. Please register first.');
        }

        if ($user->password == null) {
            return redirect()->route('create-password')->with(['email' => $credentials['email'], 'first_name' => $user->first_name]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }

    public function profile()
    {
        if (!Auth::check()) {
            return view('auth');
        }

        $user = Auth::user();

        return view('user/profile', ['user' => $user]);
    }

    public function updateProfileForm($id)
    {
        if (!Auth::check()) {
            return view("unauthorized");
        }

        $user = User::find($id);
        return view('user/updateProfile')->with('user', $user);
    }

    public function updateProfile(Request $request, $id)
    {
        if (!Auth::check()) {
            return view("unauthorized");
        }

        $user = User::find($id);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
    // Create Password
    public function createPasswordForm()
    {
        return view('user/createPassword');
    }

    public function createPassword(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find the user by email
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            if (Auth::attempt($credentials) || $user->password === null) {
                $user->password = $credentials['password'];
                if ($user->role === 'guest') {
                    $user->role = 'user';
                }
                $user->save();

                $request->session()->regenerate();
                return redirect()->route('dashboard')->withSuccess('You have successfully logged in!');
            } else {
                return redirect()->back()->with('error', 'Invalid email or password.');
            }
        } else {
            return redirect()->back()->with('error', 'User not found with the provided email.');
        }
    }
    // Delete User
    public function deleteAccount(Request $request, $email)
    {

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email does not exist in our database');
        }

        if ($user->delete() !== true) {
            return redirect()->back()->with('error', 'Email does not exist in our database');
        } else {
            return redirect('/delete-success');
        }
    }
}
