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

              <div class="doctor-details">
                <p>Specialty: <strong class="tertiary-color">{{ $doctor['doctor']['specialty'] }}</strong></p>
                <p>Qualifications: <strong class="tertiary-color">{{ $doctor['doctor']['qualifications'] }}</strong></p>
                <p>Email: <strong class="tertiary-color">{{ $doctor['email'] }}</strong></p>
                <p>Phone Number: <strong class="tertiary-color">{{  $doctor['phone']}}</strong></p>
                <a href="/appointment/{{ $doctor['id'] }}" class="btn btn-primary">Book Appointment</a>
                <a href="/contact" class="btn btn-primary">Message Doctor</a>
              </div>
            </div>
          </div>
      </div>
    </div>
</x-layout>
