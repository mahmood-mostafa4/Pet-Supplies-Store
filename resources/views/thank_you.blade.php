@extends('layouts.main')

@section('content')


<section class="container mt-2 my-3 py-5">
    <div class="container mt-2 text-center">
        <h4>Thank You</h4>
        @if (Session::has('order_id') && Session::get('order_id') != null)
        <h4 style="color: blue" class="my-5">Order Id : {{ session::get('order_id') }}</h4>
        <p>Please Keep Your Order Id In Safe Place For Future Refrrence</p>
        <p>We Will delivere Your Order Within 3 Business Days</p>
        @endif
    </div>
</section>

@endsection
