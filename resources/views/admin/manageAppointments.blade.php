<x-layout>
  <x-slot:title>
    Manage Appointments
    </x-slot>
    
    @if (count($appointments) == 0)
      <div class="container p-5 d-flex flex-column justify-content-center align-items-center">
        <h2 class="fw-bolder">No Appointments</h2>
        <p>There are no appointments that have been made yet!</p>
      </div>
    @else
      <div class="container my-5">
        
        @if (session('success'))
        <p class="text-center fw-bolder p-3 bg-success-subtle text-success rounded-3">
          {{ session('success') }}</p>
        @endif

        <h2>Manage Appointments</h2>
        <div class="table-responsive">
          <table class="table table-dark table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">From</th>
                <th scope="col">Email</th>
                <th scope="col">Medical Issue</th>
                <th scope="col">View Appointment</th>
              </tr>
            </thead>

            @foreach ($appointments as $appointment)
              <tr>
                <th>{{ $appointment->user->first_name }}</th>
                <td>{{ $appointment->user->email }}</td>
                <td>{{ $appointment->medical_issue }}</td>
                <td><a href="/admin/appointment/{{ $appointment->id }}" class="btn btn-tertiary">View Appointment</a>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    @endif
</x-layout>
