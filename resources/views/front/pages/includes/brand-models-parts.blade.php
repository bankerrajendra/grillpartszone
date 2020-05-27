<?php
//    $t=1;
//    if(isset($brandInfo)) $t=0;
?>
@if($parts != null)
    @foreach($parts as $part)
        <?php
//            if($t==1) {
//                $brandInfo=getBrandInfo($part->id);
//                var_dump($brandInfo);
//
//                die;
//            }
        ?>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <div class="product-grid">
                <div class="product-image">
                    <a href="{{ route('part', ['brandSlug' => $brandInfo->slug, 'slug' => $part->slug]) }}"> <!-- 'modelSlug' => $ modelInfo- >slug,  -->
                        @if($part->getSingleImg())
                            <img class="pic-1" src="{{$part->getSingleImg()}}" alt="{{$part->name}}">
                        @endif
                    </a>
                    <ul class="social">
                        <li>@include('front.pages.includes.buttons.add-wish-list', ['part_id' => $part->id, 'brand_id' => $brandInfo->id, 'in_wish_list' => $part->inWishList()])
                        </li>
                        <li>@include('front.pages.includes.buttons.add-cart', ['part_id' => $part->id, 'brand_id' => $brandInfo->id])</li>
                    </ul>
                </div>

                <div class="product-content">
                    <h3 class="title"><a href="{{ route('part', ['brandSlug' => $brandInfo->slug, 'slug' => $part->slug]) }}">{{$part->name}}</a></h3> <!-- , 'modelSlug' => $ m odelInfo- >slug -->
                    <div class="p-desc">
                        {{showReadMore($part->short_description, 60)}}
                    </div>
                    <p class="price">
                        ${{$part->price}} @if($part->retail_price != 0)
                            <span>${{$part->retail_price}}</span>@endif
                    </p>
                </div>
            </div>
        </div>
    @endforeach
@endif
