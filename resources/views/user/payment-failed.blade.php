<x-layout>
    <x-slot:title>
      Payment Failed
      </x-slot>
  
      <div class="container text-center p-5 d-flex flex-column justify-content-center align-items-center">
        <div class="icon">
            <i style="font-size: 40px;" class="bi bi-x-circle-fill fail"></i>
        </div>
        <h1 class="fw-bolder text-primary my-3"><span class="fail">Payment Failed</span></h1>
        <p>Your Payment was not successfull. Please try again after a few minutes</p>
        <a href="/payment" class="btn btn-primary">Try Again</a>
      </div>
      <!-- Contact Footer -->
      <x-contact-footer />
  </x-layout>
  