<x-layout>
  <x-slot:title>
    Login
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


          <form action="{{ route('login-swagger.post') }}" method="post">
            @csrf
            <h3>{{__('Login')}}</h3>
            <div class="mb-3">
              <label for="email" class="form-label">{{__('Email')}}</label>
              <input type="email" class="form-control" name="emailId" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">{{__('Password')}}</label>
              <input type="password" name="password" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-primary">{{__('Login')}}</button>
            <small>
              <p class="mt-3"> {{__("Don't have an account? ")}}
                <a style="color:var(--secondary); font-weight:700" href="{{ route('register') }}">
                  {{__("Register Here")}}</a>
              </p>
            </small>
          </form>
        </div>
      </div>
    </div>

</x-layout>