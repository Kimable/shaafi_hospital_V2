<style>
    #inquiry_popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: var(--tertiary);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        border-radius: 10px;
        height: 400px;
        color: white;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .popup h2 {
        color: white;
    }

    .popup-content {
        text-align: center;
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
        .popup {
            width: 95%;
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
    <div class="popup-content">
        <h2>{{ __("Quick Inquiry") }}</h2>
        <p>
            {{
                __(
                    "Book an appointment through our website and enjoy serious discounts on your next hospital visit."
                )
            }}
        </p>
        <a href="/appointment" class="btn btn-primary">{{
            __("Book Appointment")
        }}</a>
    </div>
</div>

<script>
    const quickIquiryPopUp = document.getElementById("inquiry_popup");
    const quickIquiryBtn = document.getElementById("quickIquiry");
    const closePopupIcon = document.querySelector(".close-inquiry-icon");

    console.log("About to working");
    quickIquiryBtn.addEventListener("click", () => {
        console.log("working");
        quickIquiryPopUp.style.display = "flex";
    });

    // Close pop up
    closePopupIcon.addEventListener("click", () => {
        closePopup();
    });

    document.addEventListener("click", (event) => {
        if (
            !quickIquiryPopUp.contains(event.target) &&
            event.target !== closeIcon
        ) {
            closePopup();
        }
    });

    function closePopup() {
        quickIquiryPopUp.style.display = "none";
    }
</script>
