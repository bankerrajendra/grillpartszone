<div class="col-sm-9">
    <h3>Cart Items:</h3>
    <hr>
    @if($total_items > 0)
        @php $total_cost = 0; @endphp
        @foreach($items as $item)
            <div class="media" id="item-row-{{$item['id']}}">
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
                            <p><a class="remove-from-cart" data-part-id="{{$item['id']}}" href="javascript:void(0);">Delete</a>@if(!Auth::check()) | <a href="{{route('login', ['redirect' => route('show-cart')])}}">Save For Later</a>@endif</p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <select class="qty" data-part-id="{{$item['id']}}"
                                data-brand-id="{{$item['brand_id']}}" data-part-price="{{$item['price']}}">
                            @for($i=1;$i<=20;$i++)
                                <option @if($i == $item['quantity']) selected="selected" @endif value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-sm-2 text-right">
                        <span class="p-price" id="p-item-price-{{$item['id']}}">$@php echo getAppropriatePrice($item['price']*$item['quantity']); @endphp</span>
                    </div>
                </div>
            </div>
            @php $total_cost += ($item['price'] * $item['quantity']); @endphp
        @endforeach

        <div class="s-totel">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <span class="t-item">Total (<span class="total-cart-parts">{{$total_items}}</span> item(s)) : </span> <span class="p-price p-total-price">${{getAppropriatePrice($total_cost)}}</span>
                </div>
            </div>
        </div>
    @else
        <div class="media">
            <div class="row">
                <div class="col-sm-8">
                    <div class="text-danger">Your cart is empty.</div>
                </div>
            </div>
        </div>
    @endif
</div>
@if($total_items > 0)
    <div class="col-sm-3" id="total-price-proceed-order">
        <div class="p-pay">
            <p>Part of your order qualifies for FREE Delivery</p>
            <p class="t-price">Total (<span class="total-cart-parts" style="color: #333 !important;">{{$total_items}}</span> item(s)) : <span class="p-total-price">${{$total_cost}}</span></p>
            <form>
                <button type="button" @if($order_id != '') onclick="window.location.href='{{ route('add-delivery-address', ['order_id' => $order_id]) }}'" @else onclick="window.location.href='{{ route('add-delivery-address') }}'"@endif class="btn btn-warning btn-block">Proceed To Buy
                </button>
            </form>
        </div>
    </div>
@endif