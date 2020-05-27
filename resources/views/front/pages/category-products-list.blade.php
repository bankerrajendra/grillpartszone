@extends('layouts.app')
@section('template_title'){{$metafields['title']}}@endsection
@section('meta_description'){{$metafields['description']}}@endsection
@section('meta_keyword'){{$metafields['keyword']}}@endsection
@section('content')




    {{--@include('partials.model-parts-nav')--}}


    <div class="product-cat">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 hidden-xs">

                    <div class="search-left">
                        <h4 class="box-heading">{{$category->name}} ({{$parts->total()}})</h4>
                        <div class="list-group">
                            @if(!empty($subCatList) && count($subCatList) > 0)
                                @foreach($subCatList as $categorySingle)
                                    <a class="list-group-item" href="category={{$categorySingle['id']}}">{{$categorySingle['name']}} ({{$categorySingle['total']}})</a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-sm-9 product-list">

                    @include('front.pages.includes.brand-models-parts')
                    {{--<div class="row hidden-xs">--}}
                        {{--<div class="col-sm-4">--}}
                            {{--<h4 class="pd-title">{{$brandInfo->brand}}</h4>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-8">--}}
                            {{--<ul class="breadcrumb">--}}
                                {{--<li><a href="{{ config('app.url') }}"><i class="fa fa-home"></i></a></li>--}}
                                {{--<li><a href="{{ route('brands') }}">Brands</a></li>--}}
                                {{--<li>--}}
                                    {{--<a href="{{ route('brand-models-list', ['slug'=> $brandInfo->slug]) }}">{{$brandInfo->brand}}</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="{{ route('brands-model', ['brandSlug' => $brandInfo->slug, 'slug' => $modelInfo->slug]) }}">{{$modelInfo->name}}</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row b-banner hidden-xs">--}}
                        {{--<div class="col-sm-3">--}}
                            {{--@if($modelInfo->getImg())<img src="{{$modelInfo->getImg()}}"--}}
                                                          {{--class="img-responsive img-thumbnail"--}}
                                                          {{--alt="{{$modelInfo->name}}">@endif--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-9">--}}
                            {{--{!! $modelInfo->short_description !!}--}}
{{--                            {{$brandInfo->model_description}}--}}
                            {{--<?php--}}
                            {{--$model_description = $brandInfo->model_description;--}}
                            {{--echo str_replace("%MODELNAME%",$modelInfo->name,str_replace("%BRANDNAME%",$brandInfo->brand,$model_description))--}}
                            {{--?>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="row parts-results-set" id="parts-results"--}}
                         {{--data-next-page="@if($parts->nextPageUrl() != null){{ $parts->nextPageUrl() }}@endif">--}}
                        {{--@include('front.pages.includes.brand-models-parts')--}}
                    {{--</div>--}}
                    {{--<div id='loading-results' style="display: none; text-align: center;"><img--}}
                                {{--src="{{asset('img/loader-2.gif')}}" width="64" style="margin-top: 10px;"></div>--}}
                    {{--<div class="row b-banner hidden-md hidden-lg">--}}
                        {{--<div class="col-sm-12">--}}
                            {{--<hr>--}}
                            {{--<p>If your curved pipe burner isn't working as efficiently as you'd like, or has stopped--}}
                                {{--working altogether, you can easily replace the part with a compatible model available--}}
                                {{--here. Curved pipe burners provide lots of heat without taking up a ton of space. They--}}
                                {{--are employed by a variety of major BBQ grill brands including Weber, Kenmore, Jenn-Air,--}}
                                {{--Nexgrill, and more.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var processing = false;
            if (processing == false) {
                $(window).scroll(fetchResultSet);
            }

            function fetchResultSet() {
                var page = $('#parts-results').data('next-page');
                if (page != '') {
                    clearTimeout($.data(this, "scrollCheck"));
                    $.data(this, "scrollCheck", setTimeout(function () {
                        var scroll_position_for_posts_load = $(window).height() + $(window).scrollTop() + 50;
                        if (scroll_position_for_posts_load >= $(document).height()) {
                            if (processing == false) {
                                processing = true;
                                if (processing == true) {
                                    $("#loading-results").show();
                                }
                                $.get(page, function (data) {
                                    $('.parts-results-set').append(data.parts);
                                    $('#parts-results').data('next-page', data.next_page);
                                    processing = false;
                                    $("#loading-results").hide();
                                });
                            }
                        }
                    }, 200))
                }
            }
        });
    </script>
@endsection

