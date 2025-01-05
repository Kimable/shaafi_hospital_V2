<style>
    #inquiry_popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: var(--secondary);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        border-radius: 10px;
        height: 400px;
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

    .close-inquiry-icon {
        position: absolute;
        left: 85%;
        top: 5%;
        font-size: 22px;
        font-weight: bold;
        cursor: pointer;
    }

    @media (max-width: 600px) {
        #inquiry_popup {
            width: 90%;
            height: 65%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    }
</style>

<div class="popup" id="inquiry_popup">
    <div class="row">
        <div class="col-10"></div>
        <div class="col-2 close-inquiry-icon">
            <i class="bi bi-x-lg"></i>
        </div>
    </div>
    <div>
        <h2>{{ __("Quick Inquiry") }}</h2>
        <p>
            {{
                __(
                    "Send us your phone numebr or email and we will contact you within an hour"
                )
            }}
        </p>
        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label" for="name">{{ __("Name") }}</label>
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="name"
                    placeholder="Your name"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label" for="name">{{
                    __("Phone or Email")
                }}</label>
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="name"
                    required
                    placeholder="Your Phone no. or email"
                />
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const quickIquiryPopUp = document.getElementById("inquiry_popup");
    const quickIquiryBtn = document.getElementById("quickIquiry");
    const closePopupIcon = document.querySelector(".close-inquiry-icon");

    console.log("About to working");
    quickIquiryBtn.addEventListener("click", () => {
        quickIquiryPopUp.style.display = "flex";
    });

    // Close pop up
    closePopupIcon.addEventListener("click", () => {
        quickIquiryPopUp.style.display = "none";
    });
</script>
