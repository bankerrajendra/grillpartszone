@extends('layouts.app')

@section('template_title')
    Payment Success
@endsection
@section('navclasses')

@endsection
@section('template_fastload_css')
@endsection
@section('content')
    <div class="add-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 pay-action text-center panel-body">
                    @if($amount != "")
                        <img src="{{asset('img/success.png')}}">
                        <h3>Payment Success</h3>
                        <h4>Your Payment of {{$currency}} {{$amount}}<br> was successfully completed</h4>
                        @if($order_id != '')<h5>Your Order ID: {{$order_id}}</h5>@endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection