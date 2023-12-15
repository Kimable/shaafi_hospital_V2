<x-layout>
    <x-slot:title> Make Payment </x-slot>

    <style>
        .payment-form{
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: rgb(46, 49, 145);
           margin-top: 2rem;
           border-radius: 15px;
           color: white;

        }
        .payment-form h2{
            color: white;
        }
    </style>

    <div class="container payment-form">
        <div class="mt-5 mb-3">

            <h2>Make A Payment</h2>
            <form id="payment-form" action="{{ route('payment.post') }}" method="post">
                @csrf
                
                <div class="mb-3">
                  <label for="amount" class="form-label">Enter Amount</label>
                  <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter Amount">
                </div>
                
                <button type="submit" class="btn btn-primary">Pay Now</button>
            </form>
        </div>
    </div>
   
    <x-contact-footer />
</x-layout>
