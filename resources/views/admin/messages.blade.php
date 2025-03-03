<x-layout>
  <x-slot:title>
    Messages
    </x-slot>

    @if (count($messages) <= 0) <div class="container p-5 d-flex flex-column justify-content-center align-items-center">
      <h2 class="fw-bolder">No New Messages</h2>
      <p>There are no new messages that have been sent!</p>
      <p>When new messages are sent you will see them here.</p>
      </div>
      @else
      <div class="container my-3">
        @if (session('success'))
        <p class="text-center fw-bolder p-3 bg-success-subtle text-success rounded-3">
          {{ session('success') }}</p>
        @endif

        @if (session('error'))
        <p class="text-center fw-bolder p-3 alert alert-danger rounded-3">
          {{ session('error') }}</p>
        @endif

        <h1>Messages</h1>
        <div class="table-responsive">
          <table class="table table-dark table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">From</th>
                <th scope="col">Email</th>
                <th scope="col">Subject</th>
                <th scope="col">Read Message</th>
              </tr>
            </thead>

            @foreach ($messages as $message)
            <tr>
              <th>{{ $message->name }}</th>
              <td>{{ $message->email }}</td>
              <td>{{ $message->message_title }}</td>
              <td>
                {{-- Open message and mark as read --}}

                <a href="/admin/message/{{ $message->id }}?read=true" class="btn btn-tertiary">Read Message</a>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
      @endif
</x-layout>