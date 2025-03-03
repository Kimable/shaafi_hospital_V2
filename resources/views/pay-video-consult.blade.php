<x-layout>
  <x-slot:title>
    Video Consult Payment
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


          <form action="{{ route('pay-video-consult.post') }}" method="post">
            @csrf
            <h3>Pay $15 to finish booking your video consult</h3>
            <input type="hidden" name="video_consult_id" value="{{ $video_consult_id }}">
            <div class="mb-3">
              <label for="phone" class="form-label">Enter the Phone Number you will use to make payments (Please Note:
                Only Somali Phone numbers are currently supported)</label>
              <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter Phone No." required>
            </div>
            {{-- <div class="mb-3">
              <label for="amount" class="form-label">Amount to Pay (In USD)</label>
              <input type="text" name="amount" class="form-control" id="amount">
            </div> --}}
            <button type="submit" class="btn btn-primary">Pay Now</button>
          </form>
        </div>
      </div>
    </div>

</x-layout>