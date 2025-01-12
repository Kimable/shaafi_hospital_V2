<?php
// app/Mail/AppointmentConfirmation.php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
  use SerializesModels;

  public $appointment;
  public $user;
  public $doctor;

  public function __construct($appointment, $user, $doctor)
  {
    $this->appointment = $appointment;
    $this->user = $user;
    $this->doctor = $doctor;
  }

  public function build()
  {
    return $this->subject('Appointment Confirmation - ' . $this->appointment->appointment_code)
      ->view('mails.appointment-confirmation');
  }
}
