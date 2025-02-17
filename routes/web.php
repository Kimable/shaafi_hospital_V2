<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HealthRecords;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\PaymentCtrl;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoConsultController;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $doctors = Doctor::with('user')->get();
    return view('home')->with('doctors', $doctors);
});



Route::get('/development', function () {
    return view('development');
});

// Change Language
Route::get('language/{locale}', [LangController::class, 'setLanguage'])->name('setLocale');

Route::get('/about', function () {
    $doctors = Doctor::all();
    return view('/about/about')->with('doctors', $doctors);
});

Route::get('/our-story', function () {
    $doctors = Doctor::all();
    return view('/about/our-story')->with('doctors', $doctors);
});
Route::get('/services', function () {
    return view('/services/services');
});

Route::get('/health-support-management', function () {
    return view('services/health-support-management');
});

Route::get('/life-support-training', function () {
    return view('services/life-support-training');
});

Route::get('patient-guide', function () {
    return view('patientGuide');
});

Route::get('privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('customer-support', function () {
    return view('customer-support');
});


// Doctors
Route::get('/doctors', [DoctorController::class, 'showDoctors'])->name('doctors');


Route::get('doctor/{doctorId}', [DoctorController::class, 'showSingleDoctor']);

// Contact Form
Route::get('contact', [ContactFormController::class, 'showForm'])->name('contact');
Route::post('contact', [ContactFormController::class, 'submitForm'])->name('contact');
Route::get('admin/messages', [ContactFormController::class, 'showMessages'])->name('admin/messages');
Route::get('admin/message/{id}', [ContactFormController::class, 'viewMessage'])->name('admin/message/{id}');


// User Auth Routes
// Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [UserController::class, 'Registration'])->name('register.post');
// Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [UserController::class, 'Login'])->name('login.post');
// Route::get('/talk', [UserController::class, 'showTalkToDoctor'])->name('talk');
// Route::post('/talk', [UserController::class, 'talkToDoctor'])->name('talk.post');

// Doctor Auth Routes
Route::get('doctor-profile', [DoctorController::class, 'doctorProfile'])->name('doctor-profile');
Route::get('update-doctor-profile/{id}', [DoctorController::class, 'showUpdateDoctorProfile'])->name('update-doctor-profile/{id}');
Route::put('update-doctor-profile/{id}', [DoctorController::class, 'updateDoctorProfile'])->name('update-doctor-profile.post');

// User Dashboard
Route::get('/dashboard', [UserController::class, 'showUserDashboard'])->name('dashboard');




// Admin Routes
// Managing Doctors
Route::get('admin/manage-doctors', [AdminController::class, 'showManageDoctors'])->name('admin/manage-doctors');
Route::post('admin/delete-doctor/{id}', [AdminController::class, 'deleteDoctor'])->name('admin/delete-doctor.post');
Route::get('admin/delete-doctor/{id}', [AdminController::class, 'showDeleteDoctor'])->name('admin/delete-doctor');
Route::put('admin/edit-doctor/{id}', [AdminController::class, 'editDoctor'])->name('admin/edit-doctor.post');
Route::get('admin/edit-doctor/{id}', [AdminController::class, 'showEditDoctor'])->name('admin/edit-doctor');
Route::get('admin/add-doctor', [AdminController::class, 'showAddDoctor'])->name('admin/add-doctor');
Route::post('admin/add-doctor', [AdminController::class, 'AddDoctor'])->name('admin/add-doctor.post');

// Appointment Routes
Route::get('/appointment', [AppointmentsController::class, 'showAppointmentForm'])->name('appointment');
Route::get('/appointment/{doctor_id}', [AppointmentsController::class, 'showSpecificDoctorAppointmentForm'])->name('appointment');
Route::post('/appointment/{doctor_id}', [AppointmentsController::class, 'bookAppointmentWithSpecificDoctor'])->name('appointment.post');
Route::post('/appointment', [AppointmentsController::class, 'bookAppointment'])->name('appointment.post');
Route::get('admin/manage-appointments', [AppointmentsController::class, 'manageAppointments'])->name('admin/manage-appointments');
Route::get('admin/appointment/{id}', [AppointmentsController::class, 'viewAppointment'])->name('admin/appointment/{id}');
Route::get('doctors/manage-appointments', [AppointmentsController::class, 'manageAppointmentsDoctors'])->name('doctors/manage-appointments');
Route::get('doctors/appointment/{id}', [AppointmentsController::class, 'viewAppointmentDoctors'])->name('doctors/appointment/{id}');

// Video Consult
Route::get('video-consult', function () {
    return view('video-consult');
});

Route::post('/video-consult', [VideoConsultController::class, 'bookVideoConsultWeb'])->name('video-consult.post');



// Image Upload
Route::post('/upload/{id}', [ImageController::class, 'upload'])->name('upload');

// User Routes
Route::get('dashboard', [UserController::class, 'showDashboard'])->name('dashboard');
Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserController::class, 'Registration'])->name('register.post');
Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login.post');
Route::get('profile', [UserController::class, 'profile'])->name('profile');
Route::get('update-profile/{id}', [UserController::class, 'updateProfileForm'])->name('update-profile');
Route::put('update-profile/{id}', [UserController::class, 'updateProfile'])->name('update-profile.post');
Route::get('user/appointment/{id}', [AppointmentsController::class, 'userViewAppointment'])->name('user/appointment/{id}');
Route::get('appointments', [AppointmentsController::class, 'appointments'])->name('appointments');

Route::get('create-password', [UserController::class, 'createPasswordForm'])->name('create-password');
Route::post('create-password', [UserController::class, 'createPassword'])->name('create-password.post');

// Search Filter
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::post('/search', [SearchController::class, 'search'])->name('search.search');

//  Appointment payment endpoints: Waafi Pay
Route::get('/payment', [PaymentCtrl::class, 'paymentForm'])->name('payment');
Route::post('/payment', [PaymentCtrl::class, 'appointmentPayment'])->name('payment.post');

// Video Consult payment
Route::get('/pay-video-consult', [PaymentCtrl::class, 'videoConsultForm'])->name('pay-video-consult');
Route::post('/pay-video-consult', [PaymentCtrl::class, 'videoConsultPayment'])->name('pay-video-consult.post');

Route::get('/payment-success', function () {
    return view('user/payment-success');
});
Route::get('payment-failed', function () {
    return view('/user/payment-failed');
})->name('payment-failed');

// Delete Account form
Route::get('delete-account', function () {
    return view('delete-account');
});
// Send Delete Account Email
Route::post('delete-account', [MailController::class, 'deleteAccount'])->name('delete-account');

// Delete Account
Route::get('delete', function () {
    return view('delete');
})->name('delete');
Route::post('deleteUser/{email}', [UserController::class, 'deleteAccount'])->name('deleteUser/{email}');

// Appointment Completed
Route::post('appointment-completed/{id}', function ($id) {
    $appointment = Appointment::find($id);
    if ($appointment->status == 'completed') {
        $appointment->status = 'in_progress';
        $appointment->save();
        return back()->with('success', 'Appointment changed to In progress successfully!');
    } else {
        $appointment->status = 'completed';
        $appointment->save();
        return back()->with('success', 'Appointment changed to completed successfully!');
    }
})->name('appointment-completed');

// Delete Appointment
Route::post('delete-appointment/{id}', function ($id) {
    $appointment = Appointment::find($id);
    $appointment->delete();
    return redirect('admin/manage-appointments')->with('success', 'Appointment Deleted successfully!');
})->name('delete-appointment');


// User account deleted successfully
Route::get('/delete-success', function () {
    return view('/delete_success');
});

// Logout users
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('/logout');

Route::get('/auth-fail', function () {
    return response()->json(['message' => 'Invalid token'], 401);
})->name('/auth-fail');

// Specialties Routes
Route::get('/specialties/cardiothoracic-surgery', function () {
    return view('specialties/cardiothoracic-surgery');
});

Route::get('/specialties/anathesiology', function () {
    return view('specialties/anathesiology');
});

Route::get('/specialties/liver-transplant', function () {
    return view('specialties/liver-transplant');
});

Route::get('/specialties/oncology', function () {
    return view('specialties/oncology');
});

Route::get('/specialties/diabetic-services', function () {
    return view('specialties/diabetic-services');
});

Route::get('/specialties/oncology', function () {
    return view('specialties/oncology');
});

Route::get('/specialties/surgery', function () {
    return view('specialties/surgery');
});

Route::get('/specialties/ivf', function () {
    return view('specialties/ivf');
});

Route::get('/specialties/internal-medicine', function () {
    return view('specialties/internal-medicine');
});

Route::get('/specialties/nutrition', function () {
    return view('specialties/nutrition');
});

Route::get('/specialties/pediatric', function () {
    return view('specialties/pediatric');
});

Route::get('/specialties/radiology', function () {
    return view('specialties/radiology');
});

Route::get('/specialties/ophthamology', function () {
    return view('specialties/ophthamology');
});

Route::get('/specialties/physiotheraphy', function () {
    return view('specialties/physiotheraphy');
});

// Procedure Routes
Route::get('/procedures/abdominal-surgery', function () {
    return view('procedures/abdominal-surgery');
});

Route::get('/procedures/biopsy', function () {
    return view('procedures/biopsy');
});

Route::get('/procedures/bone-marrow', function () {
    return view('procedures/bone-marrow');
});

Route::get('/procedures/chemotherapy', function () {
    return view('procedures/chemotherapy');
});

Route::get('/procedures/gastric-bypass', function () {
    return view('procedures/gastric-bypass');
});

Route::get('/procedures/heart-transplant', function () {
    return view('procedures/heart-transplant');
});

Route::get('/procedures/hysterectomy', function () {
    return view('procedures/hysterectomy');
});

Route::get('/procedures/immunotherapy', function () {
    return view('procedures/immunotherapy');
});

// Download Health Record pdf
Route::get('/health-record/{id}', [HealthRecords::class, 'generateHealthRecordPDF'])->name('health-record');

// Route::get('/no-record', function () {
//     return view('pdf/no-record');
// });

Route::fallback(function () {
    return view('404');
});
