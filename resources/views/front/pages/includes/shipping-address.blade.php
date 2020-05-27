<div class="col-sm-6">
    <div class="form-group">
        <label for="name_shipping">Name</label>
        <input type="text" class="form-control" id="name_shipping" name="name_shipping" value="{{$shippingDetails['name'] ?? ''}}">
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="company_shipping">Company</label>
        <input type="text" class="form-control" id="company_shipping" name="company_shipping" value="{{$shippingDetails['company'] ?? ''}}">
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group">
        <label>Address</label>
        <input id="address_shipping-1" name="address_shipping_1" type="text" class="form-control" placeholder="Line 1" value="{{$shippingDetails['address_1'] ?? ''}}">
    </div>
    <div class="form-group">
        <input id="address_shipping-2" name="address_shipping_2" type="text" class="form-control" placeholder="Line 2" value="{{$shippingDetails['address_2'] ?? ''}}">
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="country_shipping">Country</label>
        <select name="country_shipping" id="country_shipping" class="form-control load-dependent" required="" aria-required="true" dependent="state_shipping">
            <option value="">Select Country</option>
            @foreach($countries as $sinCountry)
                <option value="{{$sinCountry->id}}" @if(isset($shippingDetails) && count($shippingDetails) > 0 && isset($shippingDetails['country_id']) && $shippingDetails['country_id'] == $sinCountry->id) selected="selected" @endif>{{$sinCountry->name}}</option>
            @endforeach
        </select>
        @if ($errors->has('country_shipping'))
            <span id="country_shipping-error" class="help-block error-help-block">{{ $errors->first('country_shipping') }}</span>
        @endif
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="state_shipping">State</label>
        <select name="state_shipping" id="state_shipping" class="form-control load-dependent" dependent="city_shipping">
            @if($statesShippingPopulate != null)
                @foreach($statesShippingPopulate as $state_ship_populate)
                    <option value="{{$state_ship_populate->id}}" @if(isset($shippingDetails) && count($shippingDetails) > 0 && isset($shippingDetails['state_id']) && $shippingDetails['state_id'] == $state_ship_populate->id) selected="selected" @endif>{{$state_ship_populate->name}}</option>
                @endforeach
            @else
                <option value="">Select State</option>
            @endif
        </select>
        <i class='state_shipping-dropdown-loader' style="display: none;">loading...</i>
        @if ($errors->has('state_shipping'))
            <span id="state_shipping-error" class="help-block error-help-block">{{ $errors->first('state_shipping') }}</span>
        @endif
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="city_shipping">City</label>
        <select name="city_shipping" id="city_shipping" class="form-control">
            @if($citiesShippingPopulate != null)
                @foreach($citiesShippingPopulate as $city_ship_populate)
                    <option value="{{$city_ship_populate->id}}" @if(isset($shippingDetails) && count($shippingDetails) > 0 && isset($shippingDetails['city_id']) && $shippingDetails['city_id'] == $city_ship_populate->id) selected="selected" @endif>{{$city_ship_populate->name}}</option>
                @endforeach
            @else
                <option value="">Select City</option>
            @endif
        </select>
        <i class='city_shipping-dropdown-loader' style="display: none;">loading...</i>
        @if ($errors->has('city_shipping'))
            <span id="city_shipping-error" class="help-block error-help-block">{{ $errors->first('city_shipping') }}</span>
        @endif
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="zip-shipping">Postal Code/Zipcode</label>
        <input type="text" name="zip_shipping" class="form-control" id="zip-shipping" placeholder="Zip" value="{{$shippingDetails['zip'] ?? ''}}">
        <i class='city_shipping-dropdown-loader' style="visibility: hidden;">loading...</i>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="mobile-number-shipping">Mobile Number</label>
        <input name="mobile_number_shipping" type="text" class="form-control" id="mobile-number-shipping" value="{{$shippingDetails['mobile_number'] ?? ''}}">
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="email-shipping">Email</label>
        <input type="email" name="email_shipping" class="form-control" id="email-shipping" value="{{$shippingDetails['email'] ?? ''}}">
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group">
        <label for="comments-shipping">Comments/Special Instructions</label>
        <textarea id="comments-shipping" name="comments_shipping" class="form-control" style="height:70px;">{{$shippingDetails['comment'] ?? ''}}</textarea>
    </div>
</div>