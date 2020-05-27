{{-- resources/views/admin/categories/add.blade.php --}}

@extends('adminlte::page')

@section('title', 'Add Category')

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
                        <h1>Add Category</h1>
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
                            {!! Form::open(array('route' => array('handle-add-category'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'role' => 'form',  'class' => 'needs-validation', 'style' => 'display:inline')) !!}

                            <div class="form-group row ">

                                <label for="name" class="col-md-3 control-label"> Title <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('name', '', array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Title')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="description" class="col-md-3 control-label"> Description</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="10" cols="10" style="width: 100%;" name="description"
                                                  id="description" placeholder="Long Description"></textarea>
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
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="highercategoryid" class="col-md-3 control-label">Parent Category</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select name="highercategoryid" class="form-control">
                                            <option value="">Select</option>
                                            @if($categories != null)
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{getCategoryName($category->id)}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="ordernum" class="col-md-3 control-label"> Order Number </label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('ordernum', '', array('id' => 'ordernum', 'class' => 'form-control', 'placeholder' => 'Order Number')) !!}
                                    </div>
                                </div>
                            </div>

                            {{--  Meta Information STARTED --}}
                            <div class="form-group row ">

                                <label for="meta_title" class="col-md-3 control-label"> Meta Title</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('meta_title', '', array('id' => 'meta_title', 'class' => 'form-control', 'placeholder' => 'Meta Title')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">

                                <label for="meta_keywords" class="col-md-3 control-label"> Meta Keywords</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="10" cols="10" style="width: 100%;" name="meta_keywords"
                                                  id="meta_keywords"
                                                  placeholder="Meta Keywords"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">

                                <label for="meta_description" class="col-md-3 control-label"> Meta Description <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="10" cols="10" style="width: 100%;" name="meta_description"
                                                  id="meta_description"
                                                  placeholder="Meta Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            {{--  Meta Information ENDED --}}

                            <div class="form-group row ">
                                <label for="" class="col-md-3 control-label"> Hide</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <label>
                                            <input type="radio" name="hide" value="1">
                                            Yes
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="hide" value="0" checked="checked">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <label for="" class="col-md-3 control-label"> Hide Left Column</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <label>
                                            <input type="radio" name="hide_left_column" value="1">
                                            Yes
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="hide_left_column" value="0" checked="checked">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <label for="" class="col-md-3 control-label"> Status</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <label>
                                            <input type="radio" name="status" value="1" checked="checked">
                                            Active
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="status" value="0">
                                            Inactive
                                        </label>
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
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('description');
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}
@stop
