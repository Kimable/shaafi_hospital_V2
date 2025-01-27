<?php
// app/Mail/AppointmentConfirmation.php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
  use SerializesModels;

  public $payment;
  public $user;


  public function __construct($payment, $user)
  {
    $this->payment = $payment;
    $this->user = $user;
  }

  public function build()
  {
    return $this->subject('Payment Confirmation - ' . $this->payment->transaction_ref)
      ->view('mails.payment-confirmation');
  }
}
