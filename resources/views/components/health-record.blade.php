<style>
  #health_record_popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: var(--tertiary);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 10000;
    border-radius: 10px;
    color: white;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 400px;
  }

  .popup h2 {
    color: white;
  }

  #closeBtn {
    display: inline-block;
    margin-left: 2px;
  }

  .close_health_rcord_icon {
    position: absolute;
    left: 85%;
    top: 5%;
    font-size: 22px;
    margin-bottom: 1rem;
    font-weight: bold;
    cursor: pointer;
  }

  @media (max-width: 600px) {
    #health_record_popup {
      width: 90%;
      top: 40%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  }
</style>

<div class="popup" id="health_record_popup">
  <div class="row">
    <div class="col-10"></div>
    <div class="col-2 close_health_rcord_icon">
      <i class="bi bi-x-lg"></i>
    </div>
  </div>
  <div>
    <h4 style="margin: 2rem 0; font-weight:800">{{ __("Patient's Health Record") }}</h4>
    <form action="" method="post">
      <div class="mb-3">
        <label class="form-label" for="type">{{ __("Record Type") }}</label>

        <select class="form-select" name="type" id="type">
          <option value="Unspecified">
            --Choose Record Type--
          </option>
          <option value="lab_result">Lab Result</option>
          <option value="presciption">Prescription</option>
          <option value="vaccination">Vaccination</option>
          <option value="medical_report">Medical report</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label" for="title">{{
          __("Title")
          }}</label>
        <input type="text" class="form-control" name="title" id="title" required placeholder="Medical Title" />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">{{
          __("Description")
          }}</label>
        <textarea class="form-control" name="description" id="description" style="height: 100px" required></textarea>
      </div>

      <div class="mt-3">
        <button class="btn btn-primary" type="submit">
          Submit Record
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  const healthRecordPopUp = document.getElementById("health_record_popup");
  const healthRecordBtn = document.getElementById("healthRecord");
  const closeHealthRecordIcon = document.querySelector(".close_health_rcord_icon");

  console.log("About to working");
  healthRecordBtn.addEventListener("click", () => {
      healthRecordPopUp.style.display = "flex";
  });

  // Close pop up
  closeHealthRecordIcon.addEventListener("click", () => {
      healthRecordPopUp.style.display = "none";
  });
</script>