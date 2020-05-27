@extends('layouts.app')

@section('template_title')
    Payment Cancel
@endsection

@section('content')
    <div class="add-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 pay-action failed text-center panel-body">
                    <img src="{{asset('img/failed.png')}}">
                    <h3>Payment Canceled</h3>
                    @if($order_id != '')<h5>Your Order ID: {{$order_id}}</h5>@endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection