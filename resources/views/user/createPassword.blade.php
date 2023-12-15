<x-layout>
    <x-slot:title>
      Create Password
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
               <p>{{session('error')}}</p>
            @endif
           
            <p class="text-center fw-bolder">Hi {{session('first_name')}}, You don't have a password yet! Please create one below</p>
  
            <form action="{{ route('create-password.post') }}" method="post">
              @csrf
              <h3>Create Your Password</h3>
              <div class="mb-3">
                <label for="email" class="form-label">{{session('email')}}</label>
                <input type="email" name="email" class="form-control" id="email">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
              </div>
              <button type="submit" class="btn btn-primary">Save Password</button>
            </form>
          </div>
        </div>
      </div>
  
  </x-layout>
  