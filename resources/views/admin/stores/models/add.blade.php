{{-- resources/views/admin/stores/models/add.blade.php --}}

@extends('adminlte::page')

@section('title', 'Add Model')

@section('css')
    <link rel="stylesheet" href="{{config('app.url')}}/css/admin_custom.css">
    <style type="text/css">
        .bs-example {
            font-family: sans-serif;
            position: relative;
            margin: 100px;
        }

        .typeahead, .tt-query, .tt-hint {
            border: 2px solid #CCCCCC;
            border-radius: 8px;
            font-size: 22px; /* Set input font size */
            height: 30px;
            line-height: 30px;
            outline: medium none;
            padding: 8px 12px;
            width: 396px;
        }

        .typeahead {
            background-color: #FFFFFF;
        }

        .typeahead:focus {
            border: 2px solid #0097CF;
        }

        .tt-query {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        }

        .tt-hint {
            color: #999999;
        }

        .tt-menu {
            background-color: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            margin-top: 12px;
            padding: 8px 0;
            width: 422px;
        }

        .tt-suggestion {
            font-size: 22px; /* Set suggestion dropdown font size */
            padding: 3px 20px;
        }

        .tt-suggestion:hover {
            cursor: pointer;
            background-color: #0097CF;
            color: #FFFFFF;
        }

        .tt-suggestion p {
            margin: 0;
        }
    </style>
@stop

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h1>Add Model</h1>
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
                            {!! Form::open(array('route' => array('handle-add-model'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'role' => 'form',  'class' => 'needs-validation', 'style' => 'display:inline')) !!}

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

                                <label for="model_number" class="col-md-3 control-label"> Model # <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('model_number', '', array('id' => 'model_number', 'class' => 'form-control', 'placeholder' => 'Model #')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="item_number" class="col-md-3 control-label"> Item</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('item_number', '', array('id' => 'item_number', 'class' => 'form-control', 'placeholder' => 'Item')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="sku" class="col-md-3 control-label"> SKU <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('sku', '', array('id' => 'sku', 'class' => 'form-control', 'placeholder' => 'SKU')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="brand" class="col-md-3 control-label"> Brand <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('brand', '', array('id' => 'brand', 'class' => 'form-control typeahead tt-query', 'placeholder' => 'Brand', 'autocomplete' => 'off', 'spellcheck' => 'false')) !!}

                                        @if($brands != null)
                                            <datalist id="brand-select">
                                                <select>
                                                    @foreach($brands as $brand)
                                                        <option value="{{$brand->brand}}">{{$brand->brand}}</option>
                                                    @endforeach
                                                </select>
                                            </datalist>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="year" class="col-md-3 control-label"> Year</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('year', '', array('id' => 'year', 'class' => 'form-control', 'placeholder' => 'Year')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="note" class="col-md-3 control-label"> Note</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="note" id="note"
                                                  placeholder="Note"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="short_description" class="col-md-3 control-label"> Short Description</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="short_description"
                                                  id="short_description" placeholder="Short Description"></textarea>
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

                            <div class="form-group row ">

                                <label for="assign_accessories" class="col-md-3 control-label"> Assign Accessories</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('assign_accessories', '', array('id' => 'assign_accessories', 'class' => 'form-control', 'placeholder' => 'Search Accessories')) !!}
                                    </div>
                                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw mt-2 loader-search-accessories" aria-hidden="true" style="display: none;"></i>
                                    <div name="search_accessories_result" id="search_accessories_result" class="mt-2"></div>
{{--                                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw mt-2 loader-list-accessories" aria-hidden="true" style="display: none;"></i>--}}
{{--                                    <div class="mt-2" name="accessories_lists" id="accessories_lists"></div>--}}
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="assign_parts" class="col-md-3 control-label"> Assign Parts</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('assign_parts', '', array('id' => 'assign_parts', 'class' => 'form-control', 'placeholder' => 'Search Parts')) !!}
                                    </div>
                                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw mt-2 loader-search-parts" aria-hidden="true" style="display: none;"></i>
                                    <div class="mt-2" name="search_parts_result" id="search_parts_result"></div>
                                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw mt-2 loader-list-parts" aria-hidden="true" style="display: none;"></i>
                                    <div class="mt-2" name="parts_lists" id="parts_lists"></div>
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
                                        <textarea rows="5" cols="10" style="width: 100%;" name="meta_keywords"
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
                                        <textarea rows="5" cols="10" style="width: 100%;" name="meta_description"
                                                  id="meta_description"
                                                  placeholder="Meta Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            {{--  Meta Information ENDED --}}

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
    @include('admin.stores.models.includes.search-part-js')
    @include('admin.stores.models.includes.assign-part-js')
    <script type="text/javascript" src="{{ asset('js/typeahead.bundle.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Defining the local dataset
            var brandsArr = [];

            @if($brands != null)
            @foreach($brands as $brand)
            brandsArr.push(['{{$brand->brand}}']);
            @endforeach
            @endif

            // Constructing the suggestion engine
            var brandsArr = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: brandsArr
            });

            // Initializing the typeahead
            $('.typeahead').typeahead({
                    hint: true,
                    highlight: true, /* Enable substring highlighting */
                    minLength: 1 /* Specify minimum characters required for showing result */
                },
                {
                    name: 'brandsArr',
                    source: brandsArr
                });
        });
    </script>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('short_description');
        CKEDITOR.replace('long_description');
        CKEDITOR.replace('features');
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}
@stop
