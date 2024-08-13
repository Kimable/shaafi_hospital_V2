<x-layout>
  <x-slot:title>
    Delete Your Account
    </x-slot>

    <div class="container contact-form py-5">
      <div class="row">
        <div class="col-3"></div>
        <div class="col-lg-6">
          @if (session('error'))
          <p class="text-center fw-bolder p-3 bg-danger-subtle text-danger rounded-3">
            {{ session('error') }}</p>
        @endif
          @if (session('success'))
            <p class="text-center fw-bolder p-3 bg-success-subtle text-success rounded-3">
              {{ session('success') }}</p>
          @endif
          <form action="{{ route('delete-account') }}" method="post">
            @csrf
            <h3>{{ __('Delete Your Account') }}</h3>
            <p>Enter the email you registered with to delete your account</p>

            <div class="mb-3">
              <label for="email" class="form-label">{{ __('Email address') }}</label>
              <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                required>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Delete Account') }}</button>
          </form>
        </div>
      </div>
    </div>

</x-layout>
