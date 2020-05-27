{{-- resources/views/admin/parts/associate-models.blade.php --}}

@extends('adminlte::page')

@section('title')
    Associate Models for Part >> {{$record->name}} ({{$record->id}})
@stop

@section('css')
    <link rel="stylesheet" href="{{config('app.url')}}/css/admin_custom.css">
    <style type="text/css">
        span.rec {
            display: inline-block;
            width: 200px;
            font-weight: bold;
        }
    </style>
@stop

@section('content_header')
    <h1>Associate Models for Part >> {{$record->name}} ({{$record->id}})</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="mb-0">
                Part Information
            </h3>
        </div>
        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#myAccordion">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="form-group row ">

                            <label for="" class="col-md-3 control-label"> Part ID</label>

                            <div class="col-md-9">
                                <strong>{{$record->id}}</strong>
                            </div>
                        </div>
                        <div class="form-group row ">

                            <label for="" class="col-md-3 control-label"> Name</label>

                            <div class="col-md-9">
                                <strong>{{$record->name}}</strong>
                            </div>
                        </div>
                        <div class="form-group row ">

                            <label for="" class="col-md-3 control-label"> Model #</label>

                            <div class="col-md-9">
                                <strong>{{$record->model_no}}</strong>
                            </div>
                        </div>
                        <div class="form-group row ">

                            <label for="" class="col-md-3 control-label"> Item</label>

                            <div class="col-md-9">
                                <strong>{{$record->item_no}}</strong>
                            </div>
                        </div>
                        <div class="form-group row ">

                            <label for="" class="col-md-3 control-label"> SKU</label>

                            <div class="col-md-9">
                                <strong>{{$record->sku}}</strong>
                            </div>
                        </div>
                        <div class="form-group row ">

                            <label for="" class="col-md-3 control-label"> Year</label>

                            <div class="col-md-9">
                                <strong>{{$record->year}}</strong>
                            </div>
                        </div>
                        <div class="form-group row ">

                            <label for="" class="col-md-3 control-label"> Price</label>

                            <div class="col-md-9">
                                <strong>{{$record->price}}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        @if($record->parts_images != null)
                            <div class="row">
                                @foreach($record->parts_images as $img)
                                    <div class="col-sm-6 card-body">
                                        <div class="crop-avatar text-center">
                                            <div class="photo-panel">
                                                <div class="avatar-view" data-toggle="modal"
                                                     data-target="#model-img-{{$img->id}}"
                                                     style="cursor: pointer;">
                                                    <img alt="" src="{{$img->getImageURL()}}"
                                                         class="img-fluid img-border">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="model-img-{{$img->id}}" tabindex="-1"
                                         role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body" style="padding: 0px;">
                                                    <img alt="" src="{{$img->getImageURL()}}" class="img-border" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="mb-0">
                IN
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw mt-2 loader-in-model-section" aria-hidden="true"
                       style="display: none;"></i>
                    <div id="in-model-section">@include('admin.stores.parts.includes.in-models')</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="mb-0">
                OUT
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw mt-2 loader-out-model-section" aria-hidden="true"
                       style="display: none;"></i>
                    <div id="out-model-section">@include('admin.stores.parts.includes.out-models')</div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        function associateModel(model_id, action) {
            var html_replace_in_section = $("#in-model-section");
            var html_replace_out_section = $("#out-model-section");
            var loader_in = $('.loader-in-model-section');
            var loader_out = $('.loader-out-model-section');
            $.ajax({
                type: "post",
                dataType: 'html',
                url: "{{route('admin-associate-models-with-part')}}",
                data: {
                    'part_id': '{{$record_id}}',
                    'model_id': model_id,
                    'action': action,
                    '_token': $('input[name="_token"]').val()
                },
                beforeSend: function () {
                    if (action == 'add') {
                        loader_in.show();
                        html_replace_in_section.hide();
                        $("#out-id-" + model_id).remove();
                    } else {
                        loader_out.show();
                        html_replace_out_section.hide();
                        $("#in-id-" + model_id).remove();
                    }
                },
                success: function (response) {
                    if (action == 'add') {
                        html_replace_in_section.fadeIn();
                        html_replace_in_section.html(response);
                    } else {
                        html_replace_out_section.fadeIn();
                        html_replace_out_section.html(response);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    //html_replace_id.html("Some error");
                },
                complete: function () {
                    loader_in.hide();
                    loader_out.hide();
                }
            });
        }
    </script>
@stop
