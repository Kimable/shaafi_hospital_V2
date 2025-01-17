<x-layout>
  <x-slot:title> Video Consult </x-slot>

  <!-- Apontment Form -->
  <div class="appointment">
      <div class="container my-5">
          <div class="row">
              <div class="col-2"></div>
              <div class="col-lg-8">
                @if (session('error'))
                <p
                    class="alert alert-danger text-center"
                >
                    {{ session("error") }}
                </p>
                @endif
                  @if (session('success'))
                  <p
                      class="text-center fw-bolder p-3 bg-success-subtle text-success rounded-3"
                  >
                      {{ session("success") }}
                  </p>
                  @endif @if ($errors->any())
                  <div class="alert alert-danger text-center">
                      <strong>Whoops!</strong> There were some problems with
                      your inputs.<br /><br />
                      <ul>
                          @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                  @endif

                  <form
                      action="{{ route('video-consult.post') }}"
                      method="post"
                  >
                      @csrf
                      <h3>{{ __("Book Video Consult") }}</h3>

                      <div class="mb-3">
                          <label for="date" class="form-label">{{
                              __("Date")
                          }}</label>
                          <input
                              type="date"
                              class="form-control"
                              name="date"
                              id="date"
                              aria-describedby="emailHelp"
                              required
                          />
                      </div>

                      <div class="mb-3">
                          <label for="time" class="form-label">{{
                              __("Time")
                          }}</label>
                          <select class="form-select" name="time" id="time">
                              <option value="Unspecified">
                                  --Choose Time--
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
                          <label for="medical_issue" class="form-label">{{
                              __("Describe Condition")
                          }}</label>
                          <textarea
                              class="form-control"
                              name="medical_issue"
                              id="medical_issue"
                              style="height: 100px"
                              required
                          ></textarea>
                      </div>

                      <button
                          class="btn btn-primary w-100 py-2 my-3"
                          type="submit"
                      >
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
