<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactFormController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function submitForm(Request $request)
    {
        $msg = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message_title' => 'required|string|max:255',
            'message' => 'nullable',
        ]);

        ContactForm::create($msg);

        // You can add any logic you need here, such as sending emails, notifications, etc.

        return redirect()->route('contact')->with('success', 'Message sent successfully! We will get back to you shortly.');
    }

    // Text specific doctor
    public function showDoctorForm()
    {
        $doctors = Doctor::with('user')->get();

        return view('/user/talkToDoctor')->with('doctors', $doctors);
    }
    public function submitDoctorForm(Request $request)
    {
        $msg = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message_title' => 'required|string|max:255',
            'message' => 'nullable',
        ]);

        ContactForm::create($msg);

        // You can add any logic you need here, such as sending emails, notifications, etc.

        return redirect()->route('doctor')->with('success', 'Message sent successfully! We will get back to you shortly.');
    }

    public function showMessages()
    {
        if (!Auth::check()) {
            return view('unauthorized');
        }

        $messages = ContactForm::all()->where('read', false);
        return view('admin/messages')->with('messages', $messages);
    }

    public function viewMessage($id)
    {
        if (!Auth::check()) {
            return view('unauthorized');
        }

        $message = ContactForm::find($id);
        if (!$message) {
            return redirect()->route('admin/messages')->with('error', 'That message does not exist!');
        }
        if (!$message->read) {
            $message->read = true;
            $message->save();
        }
        return view('admin/viewMessage')->with('message', $message);
    }

    public function deleteMessage($id)
    {
        if (!Auth::check()) {
            return view('unauthorized');
        }



        $message = ContactForm::find($id);

        if (!$message) {
            return redirect()->route('admin/messages')->with('error', 'That message does not exist!');
        }


        $message->delete();

        return redirect()->route('admin/messages')->with('success', 'Message deleted successfully!');
    }
}
