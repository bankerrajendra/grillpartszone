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

    @include('partials.parts-nav')

    <div class="product-cat product-parts">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 hidden-xs">
                    <h3>GRILL PARTS</h3>
                    <p>{{$description}}</p>
                </div>
                <div class="col-sm-12">
                    <div class="row">

                        @foreach($records as $record)
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <div class="product-grid product-part">
                                    <div class="product-image">
                                        <a href="{{route('brands', ['category' => $record->slug])}}">
                                            <img class="pic-1" src="{{$record->getCatImg()}}">
                                        </a>
                                    </div>
                                    <div class="partname">
                                        <h3 class="title"><a href="{{route('brands', ['category' => $record->slug])}}">{{$record->name}}</a></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="row b-banner hidden-md hidden-lg">
                        <div class="col-sm-12">
                            <hr>
                            <p>{{$description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer_scripts')
@endsection
