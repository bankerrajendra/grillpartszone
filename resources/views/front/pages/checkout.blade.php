@extends('layouts.app')

@section('content')
    @php
        $total_items = count($items);
    @endphp
    <div class="addtocart" style="min-height:0px; padding-bottom:0px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
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
                    <h4>Shopping Cart <a href="{{ route('show-cart', ['order_id' => $order->order_id]) }}" class="pull-right"><small>Edit</small></a></h4>
                    <hr>

                    @if($total_items > 0)
                        @php $total_cost = 0; @endphp
                        @foreach($items as $item)
                            <div class="media">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="media-left">
                                            <a href="{{$item['link']}}"><img src="{{$item['image']}}" class="media-object img-thumbnail" style="width:90px;"></a>
                                        </div>
                                        <div class="media-body">
                                            <a href="{{$item['link']}}"><h4 class="media-heading">{{$item['name']}}</h4></a>
                                            @if($item['stock'] > 0)
                                                <h6>In stock</h6>
                                            @else
                                                <span class="text-danger">Not In Stock</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        {{$item['quantity']}}
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <span class="p-price">$@php echo getAppropriatePrice($item['price']*$item['quantity']); @endphp</span>
                                    </div>
                                </div>
                            </div>
                            @php $total_cost += ($item['price'] * $item['quantity']); @endphp
                        @endforeach
                    @endif
                    <div class="s-totel">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <div>
                                    <span class="t-item">Item : </span> <span class="p-price">$ {{getAppropriatePrice($total_cost)}}/-</span>
                                </div>
                                <div>
                                    <span class="t-item">Shipping : </span> <span class="p-price">$ {{getAppropriatePrice($order->shipping_amount)}}/-</span>
                                </div>
                                <div>
                                    <span class="t-item">Tax : </span> <span class="p-price">$ {{getAppropriatePrice($order->tax)}}/-</span>
                                </div>
                                <hr>
                                <div>
                                    <span class="t-item">Total ({{$total_items}} item(s)) : </span> <span class="p-price">$ {{getAppropriatePrice($order->amount)}}/-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="add-form payment">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <h4>Payment Information</h4>
                    <hr>
                    <a href="javascript:void(0);" id="submit-moneris-btn"><img src="{{ asset('img/credit-card.png') }}"></a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" id="submit-paypal-btn"><img src="{{ asset('img/paypal.png') }}"></a>

                    {{--Moneris Form--}}
                    <form method="post" name="submit-moneris-payment" @if($moneris_settings['live_mode'] == 0) action="{{$moneris_settings['gateway_location_test']}}" @else action="{{$moneris_settings['gateway_location_live']}}" @endif style="display: none;">
                        @csrf
                        <input type="hidden" name="email" value="{{$user->email}}">
                        <input type="hidden" name="charge_total" value="{{getAppropriatePrice($order->amount)}}">
                        <input type="hidden" name="bill_first_name" value="{{$user->name}}">
                        <input type="hidden" name="bill_last_name" value="">
                        <input type="hidden" name="bill_address_one" value="{{$user->address_1}}">
                        <input type="hidden" name="bill_city" value="{{$user->city->name}}">
                        <input type="hidden" name="bill_state_or_province" value="{{$user->state->name}}">
                        <input type="hidden" name="bill_postal_code" value="{{$user->zip}}">
                        <input type="hidden" name="bill_country" value="{{$user->country->code}}">
                        <input type="hidden" name="bill_phone" value="{{$user->mobile_number}}">
                        <input type="hidden" name="ship_first_name" value="{{$order->shipping_name}}">
                        <input type="hidden" name="ship_address_one" value="{{$order->shipping_address_1}}">
                        <input type="hidden" name="ship_city" value="{{$order->city->name}}">
                        <input type="hidden" name="ship_state_or_province" value="{{$order->state->name}}">
                        <input type="hidden" name="ship_postal_code" value="{{$order->shipping_zip}}">
                        <input type="hidden" name="ship_country" value="{{$order->country->code}}">
                        <input type="hidden" name="transaction_type_id" value="{{$moneris_settings['transaction_type_id']}}">
                        <input type="hidden" name="post_receipt" value="{{$moneris_settings['post_receipt']}}">
                        <input type="hidden" name="inc_address" value="{{$moneris_settings['inc_address']}}">
                        <input type="hidden" name="mail_client" value="{{$moneris_settings['mail_client']}}">
                        <input type="hidden" name="mail_merchant" value="{{$moneris_settings['mail_merchant']}}">
                        @if($user->country_id == '32')
                            <input type="hidden" name="ps_store_id" value="{{$moneris_settings['merchants']['CAD']['ps_store_id']}}">
                            <input type="hidden" name="hpp_key" value="{{$moneris_settings['merchants']['CAD']['hppkey']}}">
                        @else
                            <input type="hidden" name="ps_store_id" value="{{$moneris_settings['merchants']['USD']['ps_store_id']}}">
                            <input type="hidden" name="hpp_key" value="{{$moneris_settings['merchants']['USD']['hppkey']}}">
                        @endif

                        <input type="hidden" name="receipt_URL" value="{{ route('moneris-approved') }}">
                        <input type="hidden" name="return_URL" value="{{ route('moneris-approved') }}">
                        <input type="hidden" name="rvarorder_id" value="{{$order->order_id}}" />
                        <p><input type="submit" class="form-control btn btn-block btn-info" name="pay_moneris" value="Pay with Credit Cart" /></p>
                    </form>

                    {{--Paypal Form--}}
                    <form method="post" name="submit-paypal-payment" action="{{ route('handle-paypal-payment-submission') }}" style="display: none;">
                        @csrf
                        <input type="hidden" name="order_id" value="{{$order->order_id}}">

                        <p><input type="submit" class="form-control btn btn-block btn-success" name="pay_paypal" value="Pay with Pay Pal" /></p>
                    </form>

                    <hr>
                    <p>We take card fraud seriously.</p>
                    <p>Your IP Address has been logged and will be used to trace you in the event of a fraudulent transaction.</p>
                    <p>{{Request::ip()}}</p>
                    <p>We do not retain credit card details in our system. All credit card details are processed by our financial institution in a secure environment.</p>
                    <hr>
                    <h4>Customer Information <a href="{{ route('add-delivery-address', ['order_id' => $order->order_id]) }}" class="pull-right"><small>Edit</small></a></h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <td>Company</td>
                                    <td>{{$user->company}}</td>
                                </tr>
                                <tr>
                                    <td>Address 1</td>
                                    <td>{{$user->address_1}}</td>
                                </tr>
                                @if($user->address_2 != null)
                                <tr>
                                    <td>Address 2</td>
                                    <td>{{$user->address_2}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>City</td>
                                    <td>{{$user->city->name}}</td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>{{$user->state->name}}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{$user->country->name}}</td>
                                </tr>
                                <tr>
                                    <td>Zip Code</td>
                                    <td>{{$user->zip}}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{$user->mobile_number}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h4>Shipping Information <a href="{{ route('add-delivery-address', ['order_id' => $order->order_id]) }}#shipping_information" class="pull-right"><small>Edit</small></a></h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{$order->shipping_name}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{$order->shipping_email}}</td>
                                </tr>
                                <tr>
                                    <td>Company</td>
                                    <td>{{$order->shipping_company}}</td>
                                </tr>
                                <tr>
                                    <td>Address 1</td>
                                    <td>{{$order->shipping_address_1}}</td>
                                </tr>
                                @if($order->shipping_address_2 != null)
                                <tr>
                                    <td>Address 2</td>
                                    <td>{{$order->shipping_address_2}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>City</td>
                                    <td>{{$order->city->name}}</td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>{{$order->state->name}}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{$order->country->name}}</td>
                                </tr>
                                <tr>
                                    <td>Zip Code</td>
                                    <td>{{$order->shipping_zip}}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{$order->shipping_mobile_number}}</td>
                                </tr>
                                @if($order->shipping_comment != null)
                                    <tr>
                                        <td>Comments/Special Instructions</td>
                                        <td>{{$order->shipping_comment}}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#submit-moneris-btn').on('click', function (e) {
                $('form[name="submit-moneris-payment"]').submit();
            });
            $('#submit-paypal-btn').on('click', function () {
                $('form[name="submit-paypal-payment"]').submit();
            });
        });
    </script>
@endsection