<x-layout>
    <x-slot:title> Appointment </x-slot>

        <div class="appointment">
            <div class="hero">
                <div class="container text-center">
                    <p class="subtitle">{{ __("Always here for You") }}</p>
                    <h1 class="fw-bolder">{{ __("Book an Appointment") }}</h1>
                </div>
            </div>
        </div>

        <!-- Apontment Form -->
        <div class="appointment">
            <div class="container my-5">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-lg-8">
                        @if (session('success'))
                        <p class="text-center fw-bolder p-3 bg-success-subtle text-success rounded-3">
                            {{ session("success") }}
                        </p>
                        @endif @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with
                            your inputs.<br /><br />
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('appointment.post') }}" method="post">
                            @csrf
                            <h3>{{ __("Book an Appointment Here") }}</h3>

                            <div class="mb-3">
                                <label class="form-label" for="first_name">{{
                                    __("First Name")
                                    }}</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="last_name">{{
                                    __("Last Name")
                                    }}</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" required />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{
                                    __("Email address")
                                    }}</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    aria-describedby="emailHelp" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">{{
                                    __("Phone Number")
                                    }}</label>
                                <input type="text" class="form-control" name="phone" id="phone" required />
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">{{
                                    __("Date")
                                    }}</label>
                                <input type="date" class="form-control" name="date" id="date"
                                    aria-describedby="emailHelp" required />
                            </div>

                            <div class="mb-3">
                                <label for="time" class="form-label">{{
                                    __("Time")
                                    }}</label>
                                <select class="form-select" name="time" id="time">
                                    <option value="Unspecified">
                                        --{{__('Choose Time')}}--
                                    </option>
                                    <option value="7am">7:00 a.m</option>
                                    <option value="8am">8:00 a.m</option>
                                    <option value="9am">9:00 a.m</option>
                                    <option value="10am">10:00 a.m</option>
                                    <option value="11am">11:00 a.m</option>
                                    <option value="12pm">12:00 p.m</option>
                                    <option value="1pm">1:00 p.m</option>
                                    <option value="2pm">2:00 p.m</option>
                                    <option value="3pm">3:00 p.m</option>
                                    <option value="4pm">4:00 p.m</option>
                                    <option value="5pm">5:00 p.m</option>
                                    <option value="6pm">6:00 p.m</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">{{
                                    __("Gender")
                                    }}</label>
                                <select class="form-select" name="gender" id="gender">
                                    <option value="Unknown">
                                        --{{__('Choose Gender')}}--
                                    </option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="doctor_email" class="form-label">{{
                                    __("Preffered Doctor")
                                    }}</label>

                                <select class="form-select" name="booked_doctor_id" id="doctor_email">
                                    <option value='0'>
                                        --{{ __("Choose Doctor") }}--
                                    </option>
                                    @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->user->id }}">
                                        Dr.
                                        {{ $doctor->user->first_name }}
                                        ({{ $doctor->specialty }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="medical_issue">{{
                                    __("Medical Concern")
                                    }}</label>
                                <input type="text" class="form-control" name="medical_issue" id="medical_issue"
                                    required />
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{
                                    __("Describe Condition")
                                    }}</label>
                                <textarea class="form-control" name="description" id="description" style="height: 100px"
                                    required></textarea>
                            </div>

                            <button class="btn btn-primary w-100 py-2 my-3" type="submit">
                                {{ __("Book Appointment") }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact Footer -->
        <x-contact-footer />
</x-layout>