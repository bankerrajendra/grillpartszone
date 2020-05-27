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


                    <div class="search-left">
                        <div class="list-group v-list">
                            <li class="list-group-item"><b> Category:</b> {{$category->name}}</li>
                        </div>
                    </div>

                    <div class="search-left">

                        <div class="list-group v-list">

                            @foreach ($topCatIdArr as $key=>$topCatIdRec)
                                @if(count($subCatIdArr[$topCatIdRec['id']])>0)
                                    <a class="list-group-item" href="{{route('brands-category',['brandSlug' => $brandInfo->slug, 'categorySlug' => $topCatIdRec['slug']])}}" style="display: block;">
                                        {{$topCatIdRec['name']}} <span class="panel-h collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$topCatIdRec['id']}}" aria-expanded="false" aria-controls="collapse{{$topCatIdRec['id']}}"></span>
                                    </a>
                                    <div id="collapse{{$topCatIdRec['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$topCatIdRec['id']}}">
                                    <div class="">
                                    <ul class="sub-cat">
                                        @foreach ($subCatIdArr[$topCatIdRec['id']] as $kkey=>$subCatIdRec)
                                            <li><a href="{{route('brands-category',['brandSlug' => $brandInfo->slug, 'categorySlug' => $subCatIdRec['slug']])}}">{{$subCatIdRec['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                    </div>
                                    </div>
                                @else
                                    <a class="list-group-item" href="{{route('brands-category',['brandSlug' => $brandInfo->slug, 'categorySlug' => $topCatIdRec['slug']])}}" style="display: block;">{{$topCatIdRec['name']}}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="search-left all-brand-models-top">
                        <h4 class="box-heading panel-h collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapseOne">{{$brandInfo->brand}} All Models</h4>
                        <div class="list-group all-brand-models panel-collapse collapse" id="collapse1" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 10px;" >
                        </div>
                    </div>

                </div>

                <div class="col-sm-9 product-list">
                    <div class="row hidden-xs">
                        <div class="col-sm-4">
                            <h4 class="pd-title">{{$brandInfo->brand}} - {{$category->name}}</h4>
                        </div>
                        <div class="col-sm-8">
                            <ul class="breadcrumb">
                                <li><a href="{{ config('app.url') }}"><i class="fa fa-home"></i></a></li>
                                <li><a href="{{ route('brands',['category' => $category->slug]) }}">Brands</a></li>
                                <li>
                                    {{$category->name}}
                                </li>
                                <li>

                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row b-banner hidden-xs">
                        <div class="col-sm-3">
                            @php
                                //$img=$category->getCatImg();
                                //if($img==asset('img/no-part-image.png')) {
                                $img=$brandInfo->getImg();
                                //}
                            @endphp

                            <img src="{{$img}}"
                                                          class="img-responsive img-thumbnail"
                                                          alt="{{$category->name}}">
                        </div>
                        <div class="col-sm-9">
                            {{--{!! $modelInfo->short_description !!}--}}
{{--                            {{$brandInfo->model_description}}--}}
                            <?php
                            //$model_description = $brandInfo->model_description;
                           // echo str_replace("%MODELNAME%",$modelInfo->name,str_replace("%BRANDNAME%",$brandInfo->brand,$model_description))
                            ?>
                        </div>
                    </div>

                    <div class="row parts-results-set" id="parts-results"
                         data-next-page="@if($parts->nextPageUrl() != null){{ $parts->nextPageUrl() }}@endif">
                        @include('front.pages.includes.brand-models-parts')
                    </div>
                    <div id='loading-results' style="display: none; text-align: center;"><img
                                src="{{asset('img/loader-2.gif')}}" width="64" style="margin-top: 10px;"></div>
                    <div class="row b-banner hidden-md hidden-lg">
                        <div class="col-sm-12">
                            <hr>
                            <p>If your curved pipe burner isn't working as efficiently as you'd like, or has stopped
                                working altogether, you can easily replace the part with a compatible model available
                                here. Curved pipe burners provide lots of heat without taking up a ton of space. They
                                are employed by a variety of major BBQ grill brands including Weber, Kenmore, Jenn-Air,
                                Nexgrill, and more.</p>
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
                fetchLeftPanel();
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

            function fetchLeftPanel() {
                // Add loading state
                $('.all-brand-models').html('Loading please wait ...');

                // Set request
                var request = $.get('/fetch-brand-allmodels/{{$brandInfo->id}}/{{$category->id}}');

                // When it's done
                request.done(function(response) {
                    //console.log(response);
                    $('.all-brand-models').html(response);
                });

            }
        });
    </script>
@endsection

