@extends('layouts.app')
@section('template_title'){{$metafields['title']}}@endsection
@section('meta_description'){{$metafields['description']}}@endsection
@section('meta_keyword'){{$metafields['keyword']}}@endsection
@section('content')

    @include('partials.model-parts-nav')


    <div class="product-cat">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 hidden-xs">

                    @if($category->slug=='bbq-covers')
                        <div class="search-left">
                            <h4 class="box-heading"><a href="#demo" data-toggle="collapse"> Enter Item Dimensions <i class="pull-right fa fa-plus"></i></a></h4>
                            <div id="demo" class="collapse">
                                <div class="list-group">
                                    <div class="form-group">
                                        <label>Width</label>
                                        <input type="text" class="form-control" placeholder="Width">
                                    </div>
                                    <div class="form-group">
                                        <label>Depth</label>
                                        <input type="text" class="form-control" placeholder="Depth">
                                    </div>
                                    <div class="form-group">
                                        <label>Height</label>
                                        <input type="text" class="form-control" placeholder="Height">
                                    </div>
                                    <input type="button" class="btn btn-warning btn-block" value="Search Cover">
                                </div>
                            </div>
                        </div>
                        <div class="search-left">
                            <h4 class="box-heading">Search By Size</h4>
                            <div class="list-group">
                                @foreach($dimensions as $dimensionRec)
                                <li class="list-group-item">
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="">{{$dimensionRec->width_1}}W x {{$dimensionRec->diameter_1}}D x {{$dimensionRec->height_1}}H ({{$dimensionRec->total}})</label>
                                    </div>
                                </li>
                                @endforeach
                            </div>
                        </div>

                    @else
                        <div class="search-left">
                            <div class="list-group v-list">
                                <li class="list-group-item"><b> Category:</b> {{$category->name}}</li>
                            </div>
                        </div>
                        <div class="search-left">

                        <div class="list-group v-list">

                            @foreach ($topCatIdArr as $key=>$topCatIdRec)
                                <a class="list-group-item" href="{{route($routeVar,['slug' => $topCatIdRec['slug']])}}" style="display: block;">
                                <?php if ($topCatIdRec['id']==$category->id) { ?>
                                    <strong>{{$topCatIdRec['name']}} ({{$topCatIdRec['total']}})</strong>
                                <?php } else { ?>
                                    {{$topCatIdRec['name']}} ({{$topCatIdRec['total']}})
                                <?php } ?>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-sm-9 product-list">
                    <div class="row hidden-xs">
                        <div class="col-sm-4">
                            <h4 class="pd-title">{{$topCat->name}}</h4>
                        </div>
                        <div class="col-sm-8">
                            <ul class="breadcrumb">
                                <li><a href="{{ config('app.url') }}"><i class="fa fa-home"></i></a></li>
                                <li><a href="">{{$topCat->name}}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row b-banner hidden-xs">
                        <div class="col-sm-12">

                            <p>{{$category->description}}</p>
                        </div>
                    </div>


                    <div class="row r-search">
                        <div class="col-sm-12">
                            <h4>{{$resultCount}} results</h4>
                        </div>
                        <div class="col-sm-12 cat_list">
                            <ul>
                                <li><a href="">{{$category->name}}</a></li>
                            </ul>
                        </div>
                        {{--<div class="col-sm-4 text-right hidden-xs">--}}
                            {{--<form class="form-inline">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="focusedInput">Sort By : &nbsp;</label>--}}
                                    {{--<select class="form-control" id="sel1">--}}
                                        {{--<option>Default</option>--}}
                                        {{--<option>Name (A - Z) </option>--}}
                                        {{--<option>Name (Z - A) </option>--}}
                                        {{--<option>Price (Low &gt; High) </option>--}}
                                        {{--<option>Price (High &gt; Low) </option>--}}
                                        {{--<option>Rating (Highest) </option>--}}
                                        {{--<option>Rating (Lowest) </option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    </div>

                    <div class="row parts-results-set" id="parts-results"
                         data-next-page="@if($parts->nextPageUrl() != null){{ $parts->nextPageUrl() }}@endif">
                        @include('front.pages.includes.accessories-parts')
                    </div>
                    <div id='loading-results' style="display: none; text-align: center;"><img
                                src="{{asset('img/loader-2.gif')}}" width="64" style="margin-top: 10px;"></div>
                    <div class="row b-banner hidden-md hidden-lg">
                        <div class="col-sm-12">
                            <hr>
                            <p>{{$category->description}}</p>
                        </div>
                    </div>
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

