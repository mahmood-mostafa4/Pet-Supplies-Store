@extends('layouts.main')
@section('content')


<section class="container mt-2 my-3 py-5">
    <div class="container mt-2 text-center">
        <h4>Payment</h4>
        @if (Session::has('total_price') && Session::get('total_price') != null)
        @if (Session::has('order_id') && Session::get('order_id') != null)
        <h4 style="color: blue" class="my-5">Total : ${{ session::get('total_price') }}</h4>
        <div id="paypal-button-container" style="padding-left: 170px"></div>
        @endif
        @endif
    </div>
</section>


<script src="https://www.paypal.com/sdk/js?client-id=ATSluBK7hDigZZsPRgbVQP_hKvSAKJZbCd4E9YlbBkP75JGfydm3lP_Ena_qfJfdJU6EM23lRpKjE2w3&currency=USD"></script>
<!-- Set up a container element for the button -->

<script>
    paypal.Buttons({
        // Sets transaction when a payment button is clicked
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: "{{ Session::get('total_price') }}"
                    }
                }]
            });
        },

        // Finalizes the transaction after payer approval
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                // Successful capture ! for dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('transaction' + transaction.status + ':' + transaction.id + '\n\nSee console for all available details.');

                window.location.href = "/verify_payment/" + transaction.id;

            });
        }
    }).render('#paypal-button-container');
</script>



@endsection
