{{-- resources/views/admin/orders/edit.blade.php --}}

@extends('adminlte::page')

@section('title')
    Edit Order >> {{$record->order_id}}
@stop

@section('css')
{{--    <link href="{{asset('css/bootstrap-datepicker.css')}}" rel="stylesheet" type="text/css">--}}
    <link rel="stylesheet" href="{{config('app.url')}}/css/admin_custom.css">
    <style type="text/css">
        .table th, .table td {
            border-top: 0px;
            padding-left: 0px;
        }

        h5.brand-name {
            color: white;
            padding: 5px;
            background-color: #17a2b8;
        }

        span.rec {
            display: inline-block;
            width: 200px;
        }

        select.categories-select2 {
            width: 700px;
        }
    </style>
@stop

@section('content_header')
    <h1>Edit Order >> {{$record->order_id}}</h1>
@stop

@section('content')
    @php
        $dimension_1 = 0;
        $dimension_1_limit = 100;
    @endphp
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <a class="btn btn-lg btn-info" href="{{route('make-copy-order', ['id' => $record->order_id])}}" onclick="javascript:return confirm('Want to copy?');"><i class="fa fa-copy"></i> Make A Copy</a>
                        <a class="btn btn-lg btn-danger" href="{{ route('delete-order', ['id' => $record->order_id]) }}" onclick="javascript:return confirm('Are you sure you want to delete?');"><i class="fa fa-times"></i> Delete</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{session('success')}}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {!! Form::open(array('route' => array('handle-edit-order'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'role' => 'form',  'class' => 'needs-validation', 'style' => 'display:inline')) !!}
                            {!! Form::hidden('id', $record->order_id, array('id' => 'record-id')) !!}

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Order ID</label>

                                <div class="col-md-9">
                                    <strong>{{$record->order_id}}</strong>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="user_id" class="col-md-3 control-label"> Customer ID <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select name="user_id" id="user_id" class="form-control">
                                            <option value="">Select Customer</option>
                                            @if($customers != null)
                                                @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}" @if($customer->id == $record->user_id) selected="selected" @endif>{{$customer->name}} ({{$customer->id}})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="order_date" class="col-md-3 control-label"> Order Date <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group date">
                                        {!! Form::text('order_date', $record->order_date, array('id' => 'order_date', 'class' => 'form-control', 'placeholder' => 'Date')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="amount" class="col-md-3 control-label"> Final Amount <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('amount', $record->amount, array('id' => 'amount', 'class' => 'form-control', 'placeholder' => 'Amount')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="tax" class="col-md-3 control-label"> Tax <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('tax', $record->tax, array('id' => 'tax', 'class' => 'form-control', 'placeholder' => 'Tax')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_amount" class="col-md-3 control-label"> Shipping Amount <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('shipping_amount', $record->shipping_amount, array('id' => 'shipping_amount', 'class' => 'form-control', 'placeholder' => 'Shipping Amount')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_email" class="col-md-3 control-label"> Shipping Email <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('shipping_email', $record->shipping_email, array('id' => 'shipping_email', 'class' => 'form-control', 'placeholder' => 'Shipping Email')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_company" class="col-md-3 control-label"> Shipping Company <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('shipping_company', $record->shipping_company, array('id' => 'shipping_company', 'class' => 'form-control', 'placeholder' => 'Shipping Company')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_name" class="col-md-3 control-label"> Shipping Name <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('shipping_name', $record->shipping_name, array('id' => 'shipping_name', 'class' => 'form-control', 'placeholder' => 'Shipping Name')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_address_1" class="col-md-3 control-label"> Shipping Address 1 <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('shipping_address_1', $record->shipping_address_1, array('id' => 'shipping_address_1', 'class' => 'form-control', 'placeholder' => 'Shipping Address 1')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_address_2" class="col-md-3 control-label"> Shipping Address 2</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('shipping_address_2', $record->shipping_address_2, array('id' => 'shipping_address_2', 'class' => 'form-control', 'placeholder' => 'Shipping Address 2')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_mobile_number" class="col-md-3 control-label"> Shipping Mobile Number <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('shipping_mobile_number', $record->shipping_mobile_number, array('id' => 'shipping_mobile_number', 'class' => 'form-control', 'placeholder' => 'Shipping Mobile Number')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="shipping_country_id" class="col-md-3 control-label"> Shipping Country <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control load-dependent" name="shipping_country_id" id="shipping_country_id" dependent="shipping_state_id">
                                            <option value="">Select Country</option>
                                            @if($countries != null)
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}" @if($country->id == $record->shipping_country_id) selected="selected" @endif>{{$country->name}} ({{$country->id}}) ({{$country->code}})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="shipping_state_id" class="col-md-3 control-label"> Shipping State <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control load-dependent" name="shipping_state_id" id="shipping_state_id" dependent="shipping_city_id">
                                            <option value="">Select State</option>
                                            @if($states != null)
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" @if($state->id == $record->shipping_state_id) selected="selected" @endif>{{$state->name}} ({{$state->id}})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <i class='shipping_state_id-dropdown-loader' style="display: none;">loading...</i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="shipping_city_id" class="col-md-3 control-label"> Shipping City <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control" name="shipping_city_id" id="shipping_city_id">
                                            <option value="">Select City</option>
                                            @if($cities != null)
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}" @if($city->id == $record->shipping_city_id) selected="selected" @endif>{{$city->name}} ({{$city->id}})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <i class='shipping_city_id-dropdown-loader' style="display: none;">loading...</i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_zip" class="col-md-3 control-label"> Shipping Zip <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('shipping_zip', $record->shipping_zip, array('id' => 'shipping_zip', 'class' => 'form-control', 'placeholder' => 'Shipping Zip')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_comment" class="col-md-3 control-label"> Shipping Comment</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('shipping_comment', $record->shipping_comment, array('id' => 'shipping_comment', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_id" class="col-md-3 control-label"> Shipping Type <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control" name="shipping_id" id="shipping_id">
                                            <option value="">Select Shipping Type</option>
                                            @if($shipping_records != null)
                                                @foreach($shipping_records as $shipping_type)
                                                    <option value="{{$shipping_type->id}}" @if($shipping_type->id == $record->shipping_id) selected="selected" @endif>{{$shipping_type->shipping_type}} ({{$shipping_type->price}})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="payment_method" class="col-md-3 control-label"> Payment Gateway</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control" name="payment_method" id="payment_method">
                                            <option value="">Select Gateway</option>
                                            @if($gateway_records != null)
                                                @foreach($gateway_records as $gateway)
                                                    <option value="{{$gateway->id}}" @if($gateway->id == $record->payment_method) selected="selected" @endif>{{$gateway->name}} ({{$gateway->id}})</option>
                                                @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="order_method" class="col-md-3 control-label"> Payment Method</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('order_method', $record->order_method, array('id' => 'order_method', 'class' => 'form-control', 'placeholder' => 'Order method')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="promised_ship_date" class="col-md-3 control-label"> Promised Ship Date</label>

                                <div class="col-md-9">
                                    <div class="input-group date">
                                        {!! Form::text('promised_ship_date', $record->promised_ship_date, array('id' => 'promised_ship_date', 'class' => 'form-control', 'placeholder' => 'Date')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="transaction_information" class="col-md-3 control-label"> Transaction Information</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('transaction_information', $record->transaction_information, array('id' => 'transaction_information', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="transaction_error" class="col-md-3 control-label"> Transaction Error</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('transaction_error', $record->transaction_error, array('id' => 'transaction_error', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="canceled" class="col-md-3 control-label"> Canceled</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('canceled', $record->canceled, array('id' => 'canceled', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="ip_address" class="col-md-3 control-label"> IP Address</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('ip_address', $record->ip_address, array('id' => 'ip_address', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="product_total_amount" class="col-md-3 control-label"> Product Total Amount</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('product_total_amount', $record->product_total_amount, array('id' => 'product_total_amount', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                    <small>Excluding tax, shipping etc.</small>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="order_status" class="col-md-3 control-label"> Order Status</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('order_status', $record->order_status, array('id' => 'order_status', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="processed" class="col-md-3 control-label"> Order Processed</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select name="processed" id="processed" class="form-control">
                                            <option value=""></option>
                                            <option value="0" @if($record->processed == "0") selected="selected" @endif>No</option>
                                            <option value="1" @if($record->processed == "1") selected="selected" @endif>Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="canceled_by_user" class="col-md-3 control-label"> Canceled by User</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('canceled_by_user', $record->canceled_by_user, array('id' => 'canceled_by_user', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="currency" class="col-md-3 control-label"> Currency <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('currency', $record->currency, array('id' => 'currency', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="order_pending" class="col-md-3 control-label"> Order Pending</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('order_pending', $record->order_pending, array('id' => 'order_pending', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="shipping_message" class="col-md-3 control-label"> Shipping Message</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('shipping_message', $record->shipping_message, array('id' => 'shipping_message', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="ups_track_no" class="col-md-3 control-label"> UPS Track No.</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('ups_track_no', $record->ups_track_no, array('id' => 'ups_track_no', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="store_name" class="col-md-3 control-label"> Store Name</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('store_name', $record->store_name, array('id' => 'store_name', 'class' => 'form-control', 'placeholder' => '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    {!! Form::button('Save', array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'submit')) !!}
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
{{--    <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>--}}
    <script type="text/javascript">
        // var date = new Date();
        // date.setDate(date.getDate()-1);
        // $('.input-group.date').datepicker({format: "dd/mm/yyyy", startDate: date});
        $('.shipping_state_id-dropdown-loader, .shipping_city_id-dropdown-loader').hide();
        $(document).on('change', '.load-dependent', function(){
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).attr('dependent');
                var _token = $('input[name="_token"]').val();

                var output;
                // show loading text for dropdown
                if (dependent == "shipping_state_id") {
                    $('#shipping_city_id').empty(); //remove all child nodes
                    $('#shipping_state_id').html('<option value="">Select State</option>');
                    $('#shipping_city_id').html('<option value="">Select City</option>');
                } else if (dependent == "shipping_city_id") {
                    $('#shipping_city_id').empty();
                    $('#shipping_city_id').html('<option value="">Select City</option>');
                }

                $.ajax({
                    url: "{{ route('ajax.fetchLocation') }}",
                    method: "POST",
                    data: {
                        select: select,
                        value: value,
                        _token: $('input[name="_token"]').val(),
                        dependent: dependent
                    },
                    beforeSend: function () {
                        // show loading image and disable the submit button
                        if($('.'+dependent+'-dropdown-loader').length > 0) {
                            $('.'+dependent+'-dropdown-loader').show();
                        }
                        $('#'+dependent).attr('disabled', true);
                    },
                    success: function(result) {
                        for (var i = 0; i < result.length; i++) {
                            output += "<option value=" + result[i].id + ">" + result[i].value + "</option>";
                        }
                        $('#' + dependent).append(output);
                    },
                    complete: function () {
                        // show loading image and disable the submit button
                        if($('.'+dependent+'-dropdown-loader').length > 0) {
                            $('.'+dependent+'-dropdown-loader').hide();
                        }
                        $('#'+dependent).removeAttr('disabled');
                    }
                })
            }
        });
    </script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}
@stop
