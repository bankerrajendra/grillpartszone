{{-- resources/views/admin/stores/brands/edit.blade.php --}}

@extends('adminlte::page')

@section('title')
    Edit Brand >> {{$record->brand}} ({{$record->id}})
@stop

@section('css')
    <link rel="stylesheet" href="{{config('app.url')}}/css/admin_custom.css">
@stop

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h1>Edit Brand >> {{$record->brand}} ({{$record->id}})</h1>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{session('success')}}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {!! Form::open(array('route' => array('handle-edit-brand'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'role' => 'form',  'class' => 'needs-validation', 'style' => 'display:inline')) !!}
                            {!! Form::hidden('id', $record->id, array('id' => 'record-id')) !!}
                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> ID</label>

                                <div class="col-md-9">
                                    <strong>{{$record->id}}</strong>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="name" class="col-md-3 control-label"> Title <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('brand', $record->brand, array('id' => 'brand', 'class' => 'form-control', 'placeholder' => 'Title')) !!}
                                    </div>
                                </div>
                            </div>






                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="image">Image</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input filesize="10" extension="jpg|png|jpeg|gif|bmp" type="file" name="image"
                                               id="image" class="form-control">
                                    </div>
                                    <p>Allowed File type jpg | png | jpeg | gif | bmp.</p>
                                    @if($record->getImg())
                                        <div class="row">
                                            <div class="col-md-5 mt-1">
                                                <a target="_blank" href="{{$record->getImg()}}"><img
                                                            src="{{$record->getImg()}}" width="200" alt=""
                                                            border="0"/></a>
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <input type="button"
                                                       class="btn btn-danger btn-sm delete-brand-image"
                                                       payload="brand_img-{{@$record->id}}" value="Delete"/>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{--  Meta Information STARTED --}}
                            <div class="form-group row ">

                                <label for="meta_title" class="col-md-3 control-label"> Meta Title</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('meta_title', $record->meta_title, array('id' => 'meta_title', 'class' => 'form-control', 'placeholder' => 'Meta Title')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">

                                <label for="meta_keywords" class="col-md-3 control-label"> Meta Keywords</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="meta_keywords"
                                                  id="meta_keywords"
                                                  placeholder="Meta Keywords">{{$record->meta_keywords}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">

                                <label for="meta_description" class="col-md-3 control-label"> Meta Description <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="meta_description"
                                                  id="meta_description"
                                                  placeholder="Meta Description">{{$record->meta_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            {{--  Meta Information ENDED --}}

                            <div class="form-group row ">

                                <label for="description" class="col-md-3 control-label">Brand Description</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                    <textarea rows="5" cols="10" style="width: 100%;" name="description"
                                              id="description"
                                              placeholder="Long Description">{{$record->description}}</textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row ">

                                <label for="model_description" class="col-md-3 control-label"> Model Description</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                <textarea rows="5" cols="10" style="width: 100%;" name="model_description"
                                          id="model_description" placeholder="Model Description">{{$record->model_description}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    {!! Form::button('Save', array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'submit')) !!}
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            // delete image code
            $(".delete-brand-image").on("click", function (e) {
                e.preventDefault();
                var payload = $(this).attr("payload");
                var token = $('input[name="_token"]').val();
                var elm = $(this);
                if (confirm('Are you sure you want to delete image?')) {
                    $.ajax({
                        url: "{{ route('admin-remove-brand-image') }}",
                        method: "POST",
                        data: "_token=" + token + "&payload=" + payload,
                        success: function (resp) {
                            elm.prop("disabled", true);
                            elm.parent().parent().remove();
                            elm.remove();
                        }
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('description');
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}
@stop
