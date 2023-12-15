<x-layout>
    <x-slot:title> Payment Success </x-slot>

    <div
        class="container text-center p-5 d-flex flex-column justify-content-center align-items-center"
    >
        <div class="icon">
            <i
                style="font-size: 40px"
                class="bi bi-check-circle-fill success"
            ></i>
        </div>
        <h1 class="fw-bolder text-primary my-3">
            <span class="success">Payment Successful</span>
        </h1>
        <p>Your Payment was successfull. Thank you</p>
        <a href="/" class="btn btn-primary">Homepage</a>
    </div>
    <!-- Contact Footer -->
    <x-contact-footer />
</x-layout>
