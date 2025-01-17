<x-layout>
  <x-slot:title>
   Appointment Payment
    </x-slot>

    <div class="container contact-form py-5">
      <div class="row">
        <div class="col-3"></div>
        <div class="col-lg-6">

          @if (session('success'))
            <p class="text-center fw-bolder p-3 bg-success-subtle text-success rounded-3">
              {{ session('success') }}</p>
          @endif

          
          @if ($errors->any())
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('error'))
          <p class="text-center fw-bolder">{{session('error')}}</p>
          @endif
      

          <form action="{{ route('appointment-payment.post') }}" method="post">
            @csrf
            <h3>Pay for Appointment</h3>
            <!-- <div class="mb-3">
              <label for="name" class="form-label">Your Name</label>
              <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Your Email</label>
              <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                required>
            </div> -->
            <div class="mb-3">
              <label for="phone" class="form-label">Phone No</label>
              <input type="text" name="phone" class="form-control" id="phone">
            </div>
            <div class="mb-3">
              <label for="amount" class="form-label">Amount to Pay (In USD)</label>
              <input type="text" name="amount" class="form-control" id="amount">
            </div>
            <button type="submit" class="btn btn-primary">Pay Now</button>
          </form>
        </div>
      </div> 
    </div>

</x-layout>
