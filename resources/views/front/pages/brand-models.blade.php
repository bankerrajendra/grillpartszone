@extends('layouts.app')
@section('template_title'){{$metafields['title']}}@endsection
@section('meta_description'){{$metafields['description']}}@endsection
@section('meta_keyword'){{$metafields['keyword']}}@endsection

@section('content')

    @include('partials.model-parts-nav')

    <div class="product-cat">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 product-list">
                    <div class="row hidden-xs">
                        <div class="col-sm-6">
                            <h4 class="pd-title">{{$brandInfo->brand}}</h4>
                        </div>
                        <div class="col-sm-6">
                            <ul class="breadcrumb">
                                <li><a href="{{ config('app.url') }}"><i class="fa fa-home"></i></a></li>
                                <li><a href="{{ route('brands') }}">Brands</a></li>
                                <li>
                                    <a href="{{ route('brand-models-list', ['slug'=> $brandInfo->slug]) }}">{{$brandInfo->brand}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row b-banner hidden-xs">
                        <div class="col-sm-3">
                            @if($brandInfo->getImg())<img src="{{$brandInfo->getImg()}}"
                                                          class="img-responsive img-thumbnail"
                                                          alt="{{$brandInfo->brand}}">@endif
                        </div>
                        <div class="col-sm-9">
                            {!!$brandInfo->description!!}
                        </div>
                    </div>
                    @if($models != null)
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="brand-list">
                                    <div class="row">
                                        @foreach($models as $alpha => $model)
                                            @foreach($model as $singleModel)
                                                <div class="col-sm-4">
                                                    <a href="{{ route('brands-model', ['brandSlug' => $brandInfo->slug, 'slug' => $singleModel['slug']]) }}">{{$singleModel['name']}}</a>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
