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

      <div class="row">
        <div class="col-3"></div>
        <div class="col-md-6">
          <h2 class="mb-3">Appointment</h2>
          <div class="card view-appointment">
            <div class="card-body">
              <h5 class="fw-bold">Medical Issue: <span class="tertiary-color">{{ $appointment->medical_issue }}</span>
              </h5>

              <hr>

              <p class="fw-bold">From: <span class="tertiary-color">{{ $appointment->user->first_name }} {{
                  $appointment->user->last_name }}</span></p>
              <p class="fw-bold">Email: <span class="tertiary-color">{{ $appointment->user->email }}</span></p>
              <p class="fw-bold">Phone: <span class="tertiary-color">{{ $appointment->user->phone }}</span></p>
              <p class="fw-bold">Gender: <span class="tertiary-color">{{ $appointment->gender }}</span></p>
              <p class="fw-bold">Date: <span class="tertiary-color">{{ $appointment->date }}</span></p>
              <p class="fw-bold">Time: <span class="tertiary-color">{{ $appointment->time }}</span></p>
              <p class="fw-bold">Details: <span class="tertiary-color">{{ $appointment->description }}</span></p>
              <button class="btn btn-primary" id="healthRecord">Make a Record</button>
            </div>

          </div>
        </div>
      </div>

    </div>
    @endif
    <x-health-record />
</x-layout>