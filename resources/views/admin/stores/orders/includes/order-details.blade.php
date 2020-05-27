<br>
<table class="table table-bordered">
    <thead style="background:#28a745; color:#fff;">
    <tr>
        <td width="60%">Products</td>
        <td width="10%">Quantity</td>
        <td width="15%">Unit Price</td>
        <td width="15%">Total</td>
    </tr>
    </thead>
    <tbody>
    @php
        $product_total_costs = 0;
    @endphp
    @if($order_details->products != null)
        @foreach($order_details->products as $part_detail)
            <tr>
                <td width="60%">{{$part_detail->part_id}}<br>{{$part_detail->part->name}}</td>
                <td width="10%">{{$part_detail->quantity}}</td>
                <td width="15%">${{$part_detail->part_price}}</td>
                <td width="15%" class="text-right">
                    $@php echo $part_detail->quantity * $part_detail->part_price; @endphp</td>
            </tr>
            @php
                $product_total_costs += $part_detail->quantity * $part_detail->part_price;
            @endphp
        @endforeach
    @endif
    <tr>
        <td colspan="1"></td>
        <td colspan="2"><span class="btn-color">Product Cost<span></span></span></td>
        <td colspan="1" class="text-right">${{getAppropriatePrice($product_total_costs)}}</td>
    </tr>
    <tr>
        <td colspan="1"></td>
        <td colspan="2"><span class="btn-color">Shipping<span></span></span></td>
        <td colspan="1" class="text-right">${{getAppropriatePrice($order_details->shipping_amount)}}</td>
    </tr>
    <tr>
        <td colspan="1"></td>
        <td colspan="2"><span class="btn-color">Tax<span></span></span></td>
        <td colspan="1" class="text-right">${{getAppropriatePrice($order_details->tax)}}</td>
    </tr>
    <tr>
        <td colspan="1"></td>
        <td colspan="2"><span class="btn-color">Total<span></span></span></td>
        <td colspan="1" class="text-right">${{getAppropriatePrice($order_details->amount)}}</td>
    </tr>
    </tbody>
</table>
<table class="table table-bordered">
    <thead style="background:#28a745; color:#fff;">
    <tr>
        <td colspan="2">Customer Information</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Name</td>
        <td>{{$order_details->customer->name}}</td>
    </tr>
    <tr>
        <td>Address</td>
        <td>{{$order_details->customer->address_1}} {{$order_details->customer->address_2}}</td>
    </tr>
    <tr>
        <td>City</td>
        <td>{{$order_details->customer->city->name}}</td>
    </tr>
    <tr>
        <td>State</td>
        <td>{{$order_details->customer->state->name}}</td>
    </tr>
    <tr>
        <td>Zip Code</td>
        <td>{{$order_details->customer->zip}}</td>
    </tr>
    <tr>
        <td>Country</td>
        <td>{{$order_details->customer->country->code}}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{$order_details->customer->email}}</td>
    </tr>
    <tr>
        <td>Phone</td>
        <td>{{$order_details->customer->mobile_number}}</td>
    </tr>
    </tbody>
</table>
<table class="table table-bordered">
    <thead style="background:#28a745; color:#fff;">
    <tr>
        <td colspan="2">Payment Information</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Payment Type</td>
        <td>{{$order_details->order_method}}</td>
    </tr>
    <tr>
        <td>Authorization</td>
        <td>{!! $order_details->transaction_information !!}</td>
    </tr>
    <tr>
        <td>IP address</td>
        <td>{{$order_details->ip_address}}</td>
    </tr>
    <tr>
        <td>Selected Currency</td>
        <td>{{$order_details->currency}}</td>
    </tr>
    </tbody>
</table>
<table class="table table-bordered">
    <thead style="background:#28a745; color:#fff;">
    <tr>
        <td colspan="2">Shipping Information</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Shipping Method</td>
        <td>@if($order_details->shipping_id != 0){{$order_details->shipping->shipping_type}}@endif</td>
    </tr>
    <tr>
        <td>Ship to Name</td>
        <td>{{$order_details->shipping_name}}</td>
    </tr>
    <tr>
        <td>Ship to Address</td>
        <td>{{$order_details->shipping_address_1}} {{$order_details->shipping_address_2}}</td>
    </tr>
    <tr>
        <td>Ship City</td>
        <td>{{$order_details->city->name}}</td>
    </tr>
    <tr>
        <td>Ship State</td>
        <td>{{$order_details->state->name}}</td>
    </tr>
    <tr>
        <td>Ship Zip</td>
        <td>{{$order_details->shipping_zip}}</td>
    </tr>
    <tr>
        <td>Ship Country</td>
        <td>{{$order_details->country->code}}</td>
    </tr>
    <tr>
        <td>Ship Phone</td>
        <td>{{$order_details->shipping_mobile_number}}</td>
    </tr>
    </tbody>
</table>
<table class="table table-bordered">
    <thead style="background:#28a745; color:#fff;">
    <tr>
        <td>Comments/Special Instructions</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$order_details->shipping_comment}}</td>
    </tr>
    </tbody>
</table>