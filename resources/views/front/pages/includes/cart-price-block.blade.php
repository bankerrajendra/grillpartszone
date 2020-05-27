<div class="pay-slip">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            Checkout ({{getTotalCartItems()}} Item(s))
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0);">Stay in Checkout</a></li>
            <li><a @if($order_id != '') href="{{ route('show-cart', ['order_id' => $order_id]) }}" @else href="{{ route('show-cart') }}" @endif>Return to Cart</a></li>
        </ul>
    </div>
    @if($show_radio == true && $shipping != null)
    <hr>
        <h4>Choose Your Shipping Option</h4>
        @foreach($shipping as $shippingSingle)
            <div class="radio">
                <label>
                    <input type="radio" name="shipping_options" id="shipping-btn-{{$shippingSingle->id}}" value="{{$shippingSingle->id}}" @if($shippingSingle->id == $defaultShipping) checked="checked" @endif> <b>{{$shippingSingle->shipping_type}}</b>
                    @if($shippingSingle->shipping_type == 'Free')<p> (5-7 Business Days)</p>@endif</label>
            </div>
        @endforeach
    @else
        <br>
    @endif

    <table class="table">
        <tbody>
        <tr>
            <td>
                <p>
                    <strong>Item : </strong>
                </p>
                <p>
                    <strong>Shipping : </strong>
                </p>
                <p>
                    <strong>Tax : </strong>
                </p>
            </td>
            <td class="text-right">
                <p>
                    <strong>$ {{$total_items_cost['total_cart_price']}}/-</strong>
                </p>
                <p>
                    <strong>$ {{$total_shipping_cost}}/-</strong>
                </p>
                <p>
                    <strong>$ {{$total_tax}}/-</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td><h4><strong>Total: </strong></h4></td>
            <td class="text-right text-danger"><h4><strong>$ {{getFinalTotalPrice($total_items_cost['total_cart_price'], $total_shipping_cost, $total_tax)}}/-</strong></h4></td>
        </tr>
        </tbody>
    </table>
    <div class="form-group">
        <button type="submit" name="submit-address" class="form-control btn-warning btn-block" id="btn-submit-address">Proceed To Buy  <i class="fa fa-spinner fa-pulse " id="loader-submit-address" style="display: none;" aria-hidden="true"></i></button>
    </div>
</div>
