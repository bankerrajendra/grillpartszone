@extends('layouts.app')
@section('template_title'){{$metafields['title']}}@endsection
@section('meta_description'){{$metafields['description']}}@endsection
@section('meta_keyword'){{$metafields['keyword']}}@endsection
@section('template_linked_css')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/jquerysctipttop.css') }}"/>
    <style type="text/css">
        .small-container .show-small-img {
            width: 70px;
            height: 70px;
            margin-right: 6px;
            cursor: pointer;
            float: left;
            display: block;
            transform: rotate(270deg);
            border: 1px solid rgba(204, 204, 204, 0.82);
        }
    </style>
@endsection
@section('content')
    <div class="product-cat" style="background:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    {{--<h4 class="pd-title">{{$part->name}}</h4>--}}
                    <br>

                    <div class="row">
                        @if(count($part->parts_images) > 0)
                            <div class="col-sm-3 hidden-xs">
                                <div class="small-img">
                                    <img src="{{ asset('img/online_icon_right@2x.png') }}" class="icon-left" alt=""
                                         id="prev-img">
                                    <div class="small-container">

                                        <div id="small-img-roll">
                                            @foreach($part->parts_images as $image)
                                                <img src="{{ config('constants.IMAGES_S3_URL') }}{{ config('constants.PART_IMAGES_S3_FOLDER') }}/{{$image->image}}"
                                                     class="show-small-img" alt="">
                                            @endforeach
                                        </div>

                                    </div>
                                    <img src="{{ asset('img/online_icon_right@2x.png') }}" class="icon-right" alt=""
                                         id="next-img">
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-9 hidden-xs">
                            <div class="show" href="{{$part->getSingleImg()}}">
                                <img src="{{$part->getSingleImg()}}" id="show-img" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 product-list">
                    <ul class="breadcrumb text-right">
                        <li><a href=""><i class="fa fa-home"></i></a></li>

                        <?php if($brand=='accessories') { ?>
                            <li>Accessories</li>
                            <li>Bear Can Chicken</li>
                        <?php } else { ?>
                            <li><a href="{{ route('brands') }}">Brands</a></li>
                            <li>
                                <a href="{{ route('brand-models-list', ['slug'=> $brand->slug]) }}">{{$brand->brand}}</a>
                            </li>
                        <?php } ?>


                    </ul>

                    <h3 class="product-name">{!! $part->short_description !!}</h3>
                    @if(count($part->parts_images) > 0)
                        <div id="c-owl-demo" class="owl-carousel owl-theme hidden-lg hidden-md">
                            @foreach($part->parts_images as $image)
                                <div class="item">
                                    <img src="{{ config('constants.IMAGES_S3_URL') }}{{ config('constants.PART_IMAGES_S3_FOLDER') }}/{{$image->image}}"
                                         style="width:100%;">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <span class="product-rating">
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
				</span>
                    <span class="product-reviews">
					<div class="dropdown">
						<span><a href="#reviews" class="dropdown-toggle" data-toggle="dropdown">(34 Reviews)</a></span>
						<div class="dropdown-menu text-center" style="width: 330px; display: none;">
							<div class="col-sm-12 col-xs-12">
								<div class="side">
									<div><a href="">5 star</a></div>
								</div>
								<div class="middle">
									<div class="bar-container">
									  <div class="bar-5"></div>
									</div>
								</div>
								<div class="side right">
									<div><a href="">150</a></div>
								</div>
								<div class="side">
									<div><a href="">4 star</a></div>
								</div>
								<div class="middle">
									<div class="bar-container">
									  <div class="bar-4"></div>
									</div>
								</div>
								<div class="side right">
									<div><a href="">63</a></div>
								</div>
								<div class="side">
									<div><a href="">3 star</a></div>
								</div>
								<div class="middle">
									<div class="bar-container">
									  <div class="bar-3"></div>
									</div>
								</div>
								<div class="side right">
									<div><a href="">15</a></div>
								</div>
								<div class="side">
									<div><a href="">2 star</a></div>
								</div>
								<div class="middle">
									<div class="bar-container">
									  <div class="bar-2"></div>
									</div>
								</div>
								<div class="side right">
									<div><a href="">6</a></div>
								</div>
								<div class="side">
									<div><a href="">1 star</a></div>
								</div>
								<div class="middle">
									<div class="bar-container">
									  <div class="bar-1"></div>
									</div>
								</div>
								<div class="side right">
									<div><a href="">20</a></div>
								</div>
							</div>
							<div class="col-sm-12 col-xs-12 text-center">
								<a href="#" class="btn btn-default btn-rev">Read More</a>
							</div>
						</div>
					</div>
				</span>
                    <p class="write-reviews"><a href="">WRITE A REVIEW</a></p>
                    <div class="p-list">
                        <table>
                            <tbody>
                            <tr>
                                <td><span>Brands :</span></td>
                                <td class="description-right">{{$brand->brand}}</td>
                            </tr>
                            <tr>
                                <td><span>Product SKU :</span></td>
                                <td class="description-right">{{$part->sku}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <h3 class="p-aval"><small>Availability :</small> In Stock</h3>
                    <div class="p-price">
                        <h3><span id="spn-price">${{$part->price}}</span> @if($part->retail_price != 0)
                                <small id="spn-retail-price"><strike>${{$part->retail_price}}</strike></small>@endif</h3>
                        <div class="quantity">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" id="minus-cart">
                                        <span class="fa fa-minus"></span>
                                    </button>
                                </span>
                                <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="20">
                                <span class="input-group-btn">
								    <button type="button" class="btn btn-default btn-number" id="plus-cart">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default add-cart" id="add-to-cart">ADD TO CART <img src="{{ asset('img/ajax-loader.png') }}" width="35" id="loader-add-cart" style="display: none;"></button>
                        <div class="text-success" id="success-add-cart"></div>
                        <div class="text-danger" id="failed-add-cart"></div>
                    </div>
                    <a target="_blank" href="http://christianmarriage.sikhwedding.com/"><img src="{{ asset('img/sale-banner.jpg') }}" class="img-responsive img-thumbnail" title="Christian Wedding"></a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="margin-top:-10px;margin-bottom:15px;">Frequently bought together</h3>
                    <ul class="p_add">
                        <li><a href=""><img src="http://punjabibhangra.com/grillpartzone/img/burner04.jpg"></a></li>
                        <li>+</li>
                        <li><a href=""><img src="http://punjabibhangra.com/grillpartzone/img/burner3.jpg"></a></li>
                        <li>+</li>
                        <li><a href=""><img src="http://punjabibhangra.com/grillpartzone/img/burner2.jpg"></a></li>
                        <li>
                            <button class="btn btn-default btn-sm" type="button">Add All Three to Cart</button>
                        </li>
                    </ul>
                    <form class="p_add_checkbox">
                        <div class="checkbox">
                            <label><input type="checkbox" value="">This item:Broil King Barbecue Part: 3-Pack Broil King
                                Stainless Steel Flav-R-Wave for Select Broil King and… <span>CDN$ 69.99</span></label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" value="">20 1/2" x 1 1/2" Stainless Steel Top & Bottom
                                Carryover Assembly for Select 3-Burner Broil King Gas… <span>CDN$ 39.99</span></label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" value="">Broil King 18629 Tube-in-Tube Burner
                                <span>CDN$ 16.99</span></label>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row">
                <div id="tabs_info" class="product-tab col-sm-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-description" data-toggle="tab" aria-expanded="true"> Compatible Models</a></li>
                    </ul>
                    <div class="tab-content product-tab-content">
                        <div class="tab-pane active" id="tab-description">
                            {!! $part->long_description !!}
                            @if(strip_tags($part->features))
                                <p><strong>Features</strong></p>
                                {!! $part->features !!}
                            @endif
                            @if(count($associatedModels) > 0)
                                <br><br><p><strong>Fits Compatible Models</strong></p>
                                @foreach($associatedModels as $branModels)
                                    <p><a href="{{$branModels['link']}}">{{$branModels['brand']}}</a>:
                                    @if(count($branModels['models']) > 0)
                                        @foreach($branModels['models'][0] as $keyModel => $modelSingle)
                                            <a href="{{$modelSingle['link']}}" onmouseover="style='text-decoration:underline!important'" onmouseout="style='text-decoration:none!important'">{{$modelSingle['model_number']}}</a>@if($keyModel != count($branModels['models'][0])-1), &nbsp; @endif
                                        @endforeach
                                    @endif
                                    </p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row cos_review">
                <div class="col-sm-12">
                    <h3>9 customer reviews</h3>
                </div>
                <div class="col-sm-12">
                    <div class="media">
                        <div class="media-left">
                            <img src="http://punjabibhangra.com/grillpartzone/img/user.png"
                                 class="media-object img-circle" style="width:80px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Fit my cheap walmart brinkman grill.</h4>
                            <ul class="list-inline list-unstyled">
                                <li>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-o"></span>
                                </li>
                                <li>|</li>
                                <li><span>2 days, 8 hours </span></li>
                            </ul>
                            <p>Redefine your workday with the Palm Treo Pro smartphone. Perfectly balanced, you can
                                respond to business and personal email, stay on top of appointments and contacts, and
                                use Wi-Fi or GPS when you’re out and about. Then watch a video on YouTube, catch up with
                                news and sports on the web.</p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <img src="http://punjabibhangra.com/grillpartzone/img/user.png"
                                 class="media-object img-circle" style="width:80px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Fit my cheap walmart brinkman grill.</h4>
                            <ul class="list-inline list-unstyled">
                                <li>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-o"></span>
                                </li>
                                <li>|</li>
                                <li><span>2 days, 8 hours </span></li>
                            </ul>
                            <p>Redefine your workday with the Palm Treo Pro smartphone. Perfectly balanced, you can
                                respond to business and personal email, stay on top of appointments and contacts, and
                                use Wi-Fi or GPS when you’re out and about. Then watch a video on YouTube, catch up with
                                news and sports on the web.</p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <img src="http://punjabibhangra.com/grillpartzone/img/user.png"
                                 class="media-object img-circle" style="width:80px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Fit my cheap walmart brinkman grill.</h4>
                            <ul class="list-inline list-unstyled">
                                <li>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-o"></span>
                                </li>
                                <li>|</li>
                                <li><span>2 days, 8 hours </span></li>
                            </ul>
                            <p>Redefine your workday with the Palm Treo Pro smartphone. Perfectly balanced, you can
                                respond to business and personal email, stay on top of appointments and contacts, and
                                use Wi-Fi or GPS when you’re out and about. Then watch a video on YouTube, catch up with
                                news and sports on the web.</p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <img src="http://punjabibhangra.com/grillpartzone/img/user.png"
                                 class="media-object img-circle" style="width:80px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Fit my cheap walmart brinkman grill.</h4>
                            <ul class="list-inline list-unstyled">
                                <li>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-o"></span>
                                </li>
                                <li>|</li>
                                <li><span>2 days, 8 hours </span></li>
                            </ul>
                            <p>Redefine your workday with the Palm Treo Pro smartphone. Perfectly balanced, you can
                                respond to business and personal email, stay on top of appointments and contacts, and
                                use Wi-Fi or GPS when you’re out and about. Then watch a video on YouTube, catch up with
                                news and sports on the web.</p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <img src="http://punjabibhangra.com/grillpartzone/img/user.png"
                                 class="media-object img-circle" style="width:80px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Fit my cheap walmart brinkman grill.</h4>
                            <ul class="list-inline list-unstyled">
                                <li>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-o"></span>
                                </li>
                                <li>|</li>
                                <li><span>2 days, 8 hours </span></li>
                            </ul>
                            <p>Redefine your workday with the Palm Treo Pro smartphone. Perfectly balanced, you can
                                respond to business and personal email, stay on top of appointments and contacts, and
                                use Wi-Fi or GPS when you’re out and about. Then watch a video on YouTube, catch up with
                                news and sports on the web.</p>
                        </div>
                    </div>
                    <a href="" class="btn btn-default btn-sm">Write A Customer Review</a>
                </div>
            </div>

{{--            @include('front.pages.includes.viewed-parts')--}}

        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{ asset('js/part-scripts/zoom-image.js') }}"></script>
    <script src="{{ asset('js/part-scripts/main.js') }}"></script>
    <script type="text/javascript">
        function calculatePrice() {
            var qty = parseInt($('#quantity').val());
            if(qty > 0) {
                if(qty > 20) {
                    alert('Quantity must be less than or equal to 20');
                    return false;
                }
                var price_html = $("#spn-price");
                var price = parseFloat('{{$part->price}}');
                var retail_price_html = $("#spn-retail-price");
                var retail_price = parseFloat('{{$part->retail_price}}');
                if (qty > 0) {
                    var calPrice = price * qty;
                    price_html.html('$' + calPrice.toFixed(2));
                    if (retail_price_html.length > 0) {
                        var retPrice = retail_price * qty;
                        retail_price_html.html('<strike>$' + retPrice.toFixed(2) + '</strike>');
                    }
                }
            } else {
                alert('Quantity must be greater than 0');
            }
        }
        $(document).ready(function () {

            $('#add-to-cart').on('click', function () {
                var quantity = $('#quantity').val();
                var part_id = '{{$part->id}}';
                var brand_id = '{{$brand->id}}';
                var loader = $('#loader-add-cart');
                var cartTotal = $('.cart-total-counter').html();
                var successSect = $('#success-add-cart');
                var failSect = $('#failed-add-cart');

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
                        $('#add-to-cart').attr('disabled', true);
                    },
                    success: function (response) {
                        if(response.message.length > 0) {
                            successSect.slideDown(function() {
                                successSect.html(response.message);
                                setTimeout(function() {
                                    successSect.slideUp();
                                    successSect.html('');
                                }, 5000);
                            });
                            var cartItmTotal = parseInt(cartTotal) + 1;
                            $('.cart-total-counter').html(cartItmTotal);
                        } else {
                            failSect.slideDown(function() {
                                failSect.html(response.error);
                                setTimeout(function() {
                                    failSect.slideUp();
                                    failSect.html('');
                                }, 5000);
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        failSect.slideDown(function() {
                            failSect.html(response.errorThrown);
                            setTimeout(function() {
                                failSect.slideUp();
                                failSect.html('');
                            }, 5000);
                        });
                    },
                    complete: function () {
                        loader.hide();
                        $('#add-to-cart').removeAttr('disabled');
                    }
                });

            });

            $('#quantity').on('keyup', function (e) {
                calculatePrice();
            });
            var owl = $("#c-owl-demo");
            owl.owlCarousel({
                items: 4, //10 items above 1000px browser width
                itemsDesktop: [1000, 5], //5 items between 1000px and 901px
                itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
                itemsTablet: [600, 1], //2 items between 600 and 0;
                itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
                navigation: true
            });
        });
        $(function () {

            var valueElement = $('#quantity');

            function incrementValue(e) {
                var valueCart = parseInt(valueElement.val());
                if(valueCart >= 1) {
                    if(Math.max(valueCart + e.data.increment, 0) > 1) {
                        $('#minus-cart').removeAttr('disabled');
                        valueElement.val(Math.max(valueCart + e.data.increment, 0));
                        calculatePrice();
                    } else {
                        if(Math.max(valueCart + e.data.increment, 0) == 1) {
                            $('#minus-cart').attr('disabled', true);
                            valueElement.val(Math.max(valueCart + e.data.increment, 0));
                            calculatePrice();
                        }
                    }
                }
                return false;
            }
            $('#plus-cart').bind('click', {increment: 1}, incrementValue);
            $('#minus-cart').bind('click', {increment: -1}, incrementValue);
        });

    </script>
@endsection
