<x-layout>
  <x-slot:title>
    View Appointment
    </x-slot>

    @if (!$appointment)
      <div class="container p-5 d-flex flex-column justify-content-center align-items-center">
        <h2 class="fw-bolder">No Appointment</h2>
        <p>There is no appointment here!</p>
      </div>
    @else
      <div class="container my-5">
        @if (session('success'))
        <p class="text-center fw-bolder p-3 bg-success-subtle text-success rounded-3">
          {{ session('success') }}</p>
        @endif
        <div class="row">
          <div class="col-3"></div>
          <div class="col-md-6">
            <h2 class="mb-3">Appointment</h2>
            <div class="card view-appointment">
              <div class="card-body">
                <h5 class="fw-bold">Medical Issue: <span class="tertiary-color">{{ $appointment->medical_issue }}</span></h5>
                <hr>
                <p class="fw-bold">From: <span class="tertiary-color">{{ $appointment->user->first_name}} {{$appointment->user->last_name}}</span></p>
                <p class="fw-bold">Email: <span class="tertiary-color">{{ $appointment->user->email }}</span></p>
                <p class="fw-bold">Phone: <span class="tertiary-color">{{ $appointment->user->phone }}</span></p>
                <p class="fw-bold">Gender: <span class="tertiary-color">{{ $appointment->gender }}</span></p>
                <p class="fw-bold">Date: <span class="tertiary-color">{{ $appointment->date }}</span></p>
                <p class="fw-bold">Time: <span class="tertiary-color">{{ $appointment->time }}</span></p>
                <p class="fw-bold">Details: <span class="tertiary-color">{{ $appointment->description }}</span></p>

                @if($doctor)
                <p class="fw-bold">Doctor Booked: <span class="tertiary-color">Dr. {{ $doctor->first_name }}
                    {{ $doctor->last_name }}</span>
                </p>
                @endif
                <div class="row">
                <form class="col-6" action="{{ route('appointment-completed', $appointment->id) }}" method="post">
                  @csrf
                  @if($appointment->status == 'completed')
                   <button class="btn btn-tertiary">Mark Incomplete</button>
                  @else
                   <button class="btn btn-tertiary">Mark Completed</button>
                  @endif
                </form>

                <form class="col-6" action="{{ route('delete-appointment', $appointment->id) }}" method="post">
                  @csrf
                   <button style="color: red;" class="btn">Delete Appointment</button>
                </form>
              </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    @endif

</x-layout>
