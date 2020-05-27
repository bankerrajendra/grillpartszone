@if(count($viewedParts) > 1)

    <div class="row">
        <div class="col-sm-12">
            <div class="h-title"><h3>Customers who viewed this item also viewed</h3></div>
            <br>
        </div>
    </div>
    <div class="row">
        @foreach($viewedParts as $partSingle)
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="product-grid">
                    <div class="product-image">
                        <a href="{{$partSingle['part_link']}}">
                            <img class="pic-1" src="{{$partSingle['part_image']}}">
                        </a>
                        <ul class="social">
                            <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                            <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>

                    <div class="product-content">
                        <h3 class="title"><a href="{{$partSingle['part_link']}}">{{$partSingle['part_name']}}</a></h3>
                        <div class="p-desc">{{$partSingle['short_description']}}</div>
                        <p class="price">
                            ${{$partSingle['price']}} @if($partSingle['retail_price'] != null)<span>${{$partSingle['retail_price']}}</span>@endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endif