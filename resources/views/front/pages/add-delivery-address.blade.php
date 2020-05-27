@extends('layouts.app')

@section('content')
    <div class="add-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
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
                    <h3>Select a delivery address</h3>
                    <p>Enter the name and address you'd like your order to be delivered to. Please indicate also whether your invoice address is the same as the delivery address entered. When finished, click the "Continue" button. Or, if you're sending items to more than one address, click the "Add another address" button to enter additional addresses.</p>
                    <hr>
                </div>
            </div>
            <div class="row">
                <form name="submit-address" id="submit-address" action="{{ route('submit-address-details') }}" method="post">
                    <input type="hidden" name="order_id" id="order_id" value="{{$order_id}}" />
                    @csrf
                    <div class="col-sm-6">
                        <h4>Enter Billing Information</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{$billingDetails['name'] ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="company">Company</label>
                                        <input type="text" class="form-control" name="company" id="company" value="{{$billingDetails['company'] ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input name="address_1" id="address_1" type="text" class="form-control" placeholder="Line 1" value="{{$billingDetails['address_1'] ?? ''}}">
                                    </div>
                                    <div class="form-group">
                                        <input name="address_2" id="address_2" type="text" class="form-control" placeholder="Line 2" value="{{$billingDetails['address_2'] ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select name="country" id="country" class="form-control load-dependent" required="" aria-required="true" dependent="state">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $singCountry)
                                                <option value="{{$singCountry->id}}" @if(isset($billingDetails) && count($billingDetails) > 0 && isset($billingDetails['country_id']) && $billingDetails['country_id'] == $singCountry->id) selected="selected" @endif>{{$singCountry->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                            <span id="country-error" class="help-block error-help-block">{{ $errors->first('country') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select name="state" id="state" class="form-control load-dependent" dependent="city">
                                            @if($statesPopulate != null)
                                                @foreach($statesPopulate as $state_populate)
                                                    <option value="{{$state_populate->id}}" @if(isset($billingDetails) && count($billingDetails) > 0 && isset($billingDetails['state_id']) && $billingDetails['state_id'] == $state_populate->id) selected="selected" @endif>{{$state_populate->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="">Select State</option>
                                            @endif
                                        </select>
                                        <i class='state-dropdown-loader' style="display: none;">loading...</i>
                                        @if ($errors->has('state'))
                                            <span id="state-error" class="help-block error-help-block">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" id="city" class="form-control">
                                            @if($citiesPopulate != null)
                                                @foreach($citiesPopulate as $city_populate)
                                                    <option value="{{$city_populate->id}}" @if(isset($billingDetails) && count($billingDetails) > 0 && isset($billingDetails['city_id']) && $billingDetails['city_id'] == $city_populate->id) selected="selected" @endif>{{$city_populate->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="">Select City</option>
                                            @endif
                                        </select>
                                        <i class='city-dropdown-loader' style="display: none;">loading...</i>
                                        @if ($errors->has('city'))
                                            <span id="city-error" class="help-block error-help-block">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="zip">Postal Code/Zipcode</label>
                                        <input type="text" name="zip" class="form-control" id="zip" placeholder="Zip" value="{{$billingDetails['zip'] ?? ''}}">
                                        <i class='city-dropdown-loader' style="visibility: hidden;">loading...</i>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mobile_number">Mobile Number</label>
                                        <input type="text" name="mobile_number" class="form-control" id="mobile_number" value="{{$billingDetails['mobile_number'] ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{$billingDetails['email'] ?? ''}}" @if(Auth::check()) readonly="readonly" @endif >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h4><a href="#shipping_information" data-toggle="collapse">Enter Shipping Information <i class="pull-right fa fa-minus"></i></a></h4>
                            <div id="shipping_information" class="collapse in" aria-expanded="true">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="Yes" name="copy_bill_ship_address" id="copy_bill_ship_address"> Copy Billing Address to Shipping Address
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="shipping-address-section">
                                    @include('front.pages.includes.shipping-address')
                                </div>
                                <div class="loading-modal" style="display: none;">
                                    <div class="loading-modal-center">
                                        <img alt="" src="{{ asset('img/ajax-loader.png') }}" border="0" />
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-4" id="cart-price-block">
                        @include('front.pages.includes.cart-price-block')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.validator.setDefaults({ ignore: '' });
            var loader = $(".loading-modal");
            $('.state-dropdown-loader, .city-dropdown-loader').hide();

            /* Address save for shipping and billing */
            $(document).on('change', '#copy_bill_ship_address', function() {
                if($(this).is(':checked')) {
                    // copy address
                    var name = $('#name').val();
                    var company = $('#company').val();
                    var address_1 = $('#address_1').val();
                    var address_2 = $('#address_2').val();
                    var country = $('#country').val();
                    var state = $('#state').val();
                    var city = $('#city').val();
                    var zip = $('#zip').val();
                    var mobile_number = $('#mobile_number').val();
                    var email = $('#email').val();
                    $.ajax({
                        type: "post",
                        url: route('copy-billing-to-shipping-address'),
                        data: {
                            'name': name,
                            'company': company,
                            'address_1': address_1,
                            'address_2': address_2,
                            'country': country,
                            'state': state,
                            'city': city,
                            'zip': zip,
                            'mobile_number': mobile_number,
                            'email': email,
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            loader.show();
                        },
                        success: function (response) {
                            $('#shipping-address-section').html(response);
                            changePriceBlock();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('Some error while copying address.')
                        },
                        complete: function () {
                            loader.hide();
                            $("#copy_bill_ship_address").prop('checked', false);
                        }
                    });
                }
                else {
                    // empty shipping address
                }
            });

            /* Add shipping based on ship state */
            $(document).on('change', '#state_shipping', function () {
                changePriceBlock();
            });

            /* Add taxes based on Canada States of billing state */
            $(document).on('change', '#state', function () {
                changePriceBlock();
            });

            $(document).on('click', 'input[name="shipping_options"]', function() {
                changePriceBlock();
            });

        });

    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}
@endsection