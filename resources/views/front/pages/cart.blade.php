@extends('layouts.app')

@php
    $total_items = count($items);
@endphp
@section('content')
    <div class="addtocart">
        <div class="container">
            <div class="row" id="cart-items-section">
                @include('front.pages.includes.cart-items')
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-9">
                    <h3>Wish List</h3>
                    <hr>
                    @if(count($wish_list) > 0)
                        @foreach($wish_list as $wish)
                            <div class="media" id="wish-row-{{$wish['id']}}">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="media-left">
                                            <a href="{{$wish['link']}}"><img src="{{$wish['image']}}" class="media-object img-thumbnail" style="width:90px;"></a>
                                        </div>
                                        <div class="media-body">
                                            <a href="{{$wish['link']}}"><h4 class="media-heading">{{$wish['name']}}</h4></a>
                                            @if($wish['stock'] > 0)
                                                <h6>In stock</h6>
                                            @else
                                                <span class="text-danger">Not In Stock</span>
                                            @endif
                                            <p><a class="add-to-cart" data-brand-id="{{$wish['brand_id']}}" data-part-id="{{$wish['id']}}" href="javascript:void(0);">Move To Cart</a> | <a class="remove-from-wish-list" data-part-id="{{$wish['id']}}" href="javascript:void(0);">Delete</a>&nbsp;@if(!Auth::check()) | <a href="{{route('login', ['redirect' => route('show-cart')])}}">Save For Later</a>@endif</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <span class="p-price" id="p-item-price-{{$wish['id']}}">${{$wish['price']}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="media">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="text-danger">Your Wish list is empty.</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="loading-modal" style="display: none;">
                <div class="loading-modal-center">
                    <img alt="" src="{{ asset('img/ajax-loader.png') }}" border="0" />
                </div>
            </div>
        </div>

        <div class="container viewed-pro hidden-xs">
{{--            @include('front.pages.includes.viewed-parts')--}}
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var loader = $(".loading-modal");
            var cartTotal = $('.cart-total-counter').html();
            var total_price_html = $('.p-total-price');
            var total_cart_parts = $('.total-cart-parts');
            // remove cart item
            $('.remove-from-cart').on('click', function () {

                if(confirm("Are you sure you want to delete this part from Cart?")) {
                    var part_id = $(this).data('partId');
                    $.ajax({
                        type: "post",
                        url: route('part-remove-from-cart'),
                        data: {
                            'part_id': part_id,
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            loader.show();
                        },
                        success: function (response) {
                            if (response.message.length > 0) {
                                $("#item-row-" + part_id).fadeOut().remove();
                                total_price_html.html('$' + response.return.total_cart_price.toFixed(2));
                                var cartItmTotal = response.return.total_items;
                                if(response.return.total_cart_price == 0) {
                                    cartItmTotal = 0;
                                    $("#total-price-proceed-order").remove();
                                }
                                $('.cart-total-counter').html(cartItmTotal);
                                total_cart_parts.html(cartItmTotal);
                            } else {
                                console.log(response.error)
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('Some error while deleting.')
                        },
                        complete: function () {
                            loader.hide();
                        }
                    });
                }
            });

            // remove wish list item
            $('.remove-from-wish-list').on('click', function () {

                if(confirm("Are you sure you want to delete this part from Wish List?")) {
                    var part_id = $(this).data('partId');
                    $.ajax({
                        type: "post",
                        url: route('part-remove-from-wish-list'),
                        data: {
                            'part_id': part_id,
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            loader.show();
                        },
                        success: function (response) {
                            if (response.message.length > 0) {
                                $("#wish-row-" + part_id).fadeOut().remove();
                            } else {
                                console.log(response.error)
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('Some error while deleting.')
                        },
                        complete: function () {
                            loader.hide();
                        }
                    });
                }
            });

            $('.add-to-cart').on('click', function () {
                var part_id = $(this).data('partId');
                var brand_id = $(this).data('brandId');
                $.ajax({
                    type: "post",
                    url: route('wish-part-move-to-cart'),
                    data: {
                        'part_id': part_id,
                        'brand_id': brand_id,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        loader.show();
                    },
                    success: function (response) {
                        $("#wish-row-" + part_id).fadeOut().remove();
                        $('#cart-items-section').html(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Some error while deleting.')
                    },
                    complete: function () {
                        loader.hide();
                    }
                });
            });

            $('.qty').on('change', function (e) {
                var quantity = $(this).val();
                var part_id = $(this).data('partId');
                var part_price = $(this).data('partPrice');
                var brand_id = $(this).data('brandId');
                var item_price_html = $("#p-item-price-"+part_id);

                if (quantity > 0) {
                    $.ajax({
                        type: "post",
                        url: route('part-add-to-cart'),
                        data: {
                            'part_id': part_id,
                            'quantity': quantity,
                            'brand_id': brand_id,
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            loader.show();
                        },
                        success: function (response) {
                            if(response.message.length > 0) {
                                var calPrice = part_price * quantity;
                                item_price_html.html('$' + calPrice.toFixed(2));
                                total_price_html.html('$' + response.return.total_cart_price.toFixed(2));
                            } else {
                                console.log(response.error);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(response.errorThrown);
                        },
                        complete: function () {
                            loader.hide();
                        }
                    });
                }
            });
        });
    </script>
@endsection