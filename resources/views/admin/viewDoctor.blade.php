<x-layout>
  <x-slot:title>
    View Doctor
    </x-slot>
    <div class="my-5">
      <div class="container">
  
          <div class="row">
            <div class="col-3"></div>
            <div class="col-md-6">

              <x-flash-messages />

              <h3 class="text-primary">Dr. {{ $doctor['first_name'] }} {{  $doctor['last_name']}}</h3>
              <img class="doctor-avatar" src="{{ asset($doctor['avatar']) }}" width="300px"
                alt="Dr. {{  $doctor['first_name'] }}">

              <form class="my-2" action="{{ route('upload', $doctor['id']) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <input class="form-control" type="file" id="formFile" name="image">
                  <button class="btn btn-primary mt-2" type="submit">Update Image</button>
                </div>
              </form>

              <div class="doctor-details">
                <p>Specialty: <strong class="tertiary-color">{{ $doctor['doctor']['specialty'] }}</strong></p>
                <p>Qualifications: <strong class="tertiary-color">{{ $doctor['doctor']['qualifications'] }}</strong></p>
                <p>Email: <strong class="tertiary-color">{{ $doctor['email'] }}</strong></p>
                <p>Phone Number: <strong class="tertiary-color">{{  $doctor['phone']}}</strong></p>
                <a href="/admin/edit-doctor/{{  $doctor['id'] }}" class="btn btn-primary">Update Doctor</a>
              </div>
            </div>
          </div>
      </div>
    </div>
</x-layout>
