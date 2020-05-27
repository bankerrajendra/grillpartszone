@extends('layouts.app')
@section('template_title'){{$metafields['title']}}@endsection
@section('meta_description'){{$metafields['description']}}@endsection
@section('meta_keyword'){{$metafields['keyword']}}@endsection


@section('content')
    <!--Start Banner-->
    @include('partials.parts-nav')
    <div class="product-cat product-parts">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-justify">
                    <h3 class="text-center">{!! $pageinfo->page_title !!}</h3>
                    {!! $pageinfo->page_description !!}
                </div>
            </div>
        </div>
    </div>

@endsection
