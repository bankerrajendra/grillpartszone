{{-- resources/views/admin/parts/edit.blade.php --}}

@extends('adminlte::page')

@section('title')
    Edit Part >> {{$record->name}} ({{$record->id}})
@stop

@section('css')
    <link rel="stylesheet" href="{{config('app.url')}}/css/admin_custom.css">
    <style type="text/css">
        .table th, .table td {
            border-top: 0px;
            padding-left: 0px;
        }

        h5.brand-name {
            color: white;
            padding: 5px;
            background-color: #17a2b8;
        }

        span.rec {
            display: inline-block;
            width: 200px;
        }

        select.categories-select2 {
            width: 700px;
        }
    </style>
@stop

@section('content_header')
    <h1>Edit Part</h1>
@stop

@section('content')
    @php
        $dimension_1 = 0;
        $dimension_1_limit = 100;
    @endphp
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <a class="btn btn-lg btn-info" href="{{route('make-copy-part', ['id' => $record->id])}}">Make A
                            Copy</a>
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
                            {!! Form::open(array('route' => array('handle-edit-part'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'role' => 'form',  'class' => 'needs-validation', 'style' => 'display:inline')) !!}
                            {!! Form::hidden('id', $record->id, array('id' => 'record-id')) !!}

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Part ID</label>

                                <div class="col-md-9">
                                    <strong>{{$record->id}}</strong>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="name" class="col-md-3 control-label"> Title <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('name', $record->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Title')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="slug" class="col-md-3 control-label"> Slug <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('slug', $record->slug, array('id' => 'slug', 'class' => 'form-control', 'placeholder' => 'Slug')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="model_no" class="col-md-3 control-label"> Model # <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('model_no', $record->model_no, array('id' => 'model_no', 'class' => 'form-control', 'placeholder' => 'Model #')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="item_number" class="col-md-3 control-label"> Item</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('item_number', $record->item_no, array('id' => 'item_number', 'class' => 'form-control', 'placeholder' => 'Item')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="sku" class="col-md-3 control-label"> SKU <span class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('sku', $record->sku, array('id' => 'sku', 'class' => 'form-control', 'placeholder' => 'SKU')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="year" class="col-md-3 control-label"> Year</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('year', $record->year, array('id' => 'year', 'class' => 'form-control', 'placeholder' => 'Year')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="note" class="col-md-3 control-label"> Note</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="note" id="note"
                                                  placeholder="Note">{{$record->note}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="short_description" class="col-md-3 control-label"> Short Description</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="short_description"
                                                  id="short_description"
                                                  placeholder="Short Description">{{$record->short_description}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="long_description" class="col-md-3 control-label"> Long Description</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="long_description"
                                                  id="long_description"
                                                  placeholder="Long Description">{{$record->long_description}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="features" class="col-md-3 control-label"> Features</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="features" id="features"
                                                  placeholder="Features">{{$record->features}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="price" class="col-md-3 control-label"> Price</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('price', $record->price, array('id' => 'price', 'class' => 'form-control', 'placeholder' => '0.00')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="retail_price" class="col-md-3 control-label"> Retail Price</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('retail_price', $record->retail_price, array('id' => 'retail_price', 'class' => 'form-control', 'placeholder' => '0.00')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="cost" class="col-md-3 control-label"> Cost</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('cost', $record->cost, array('id' => 'cost', 'class' => 'form-control', 'placeholder' => '0.00')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="stock" class="col-md-3 control-label"> Stock</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('stock', $record->stock, array('id' => 'stock', 'class' => 'form-control', 'placeholder' => '0')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="weight" class="col-md-3 control-label"> Weight</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('weight', $record->weight, array('id' => 'weight', 'class' => 'form-control', 'placeholder' => '0')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Length (Front to Back)</label>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <select name="length_1" id="length_1" class="form-control">

                                            @for($i = 0; $i <= $dimension_1_limit; $i++)
                                                <option value="{{$i}}"
                                                        @if($record->length_1 ==  $i) selected="selected" @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                        &nbsp;&nbsp;
                                        <select name="length_2" id="length_2" class="form-control">
                                            @foreach(config('constants.parts_dimensions') as $dimension_key => $dimension_value)
                                                <option value="{{$dimension_value}}"
                                                        @if($record->length_2 == $dimension_value) selected="selected" @endif>{{$dimension_key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Height</label>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <select name="height_1" id="height_1" class="form-control">

                                            @for($i = 0; $i <= $dimension_1_limit; $i++)
                                                <option value="{{$i}}"
                                                        @if($record->height_1 == $i) selected="selected" @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                        &nbsp;&nbsp;
                                        <select name="height_2" id="height_2" class="form-control">
                                            @foreach(config('constants.parts_dimensions') as $dimension_key => $dimension_value)
                                                <option value="{{$dimension_value}}"
                                                        @if($record->height_2 == $dimension_value) selected="selected" @endif>{{$dimension_key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Width</label>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <select name="width_1" id="width_1" class="form-control">

                                            @for($i = 0; $i <= $dimension_1_limit; $i++)
                                                <option value="{{$i}}"
                                                        @if($record->width_1 == $i) selected="selected" @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                        &nbsp;&nbsp;
                                        <select name="width_2" id="width_2" class="form-control">
                                            @foreach(config('constants.parts_dimensions') as $dimension_key => $dimension_value)
                                                <option value="{{$dimension_value}}"
                                                        @if($record->width_2 == $dimension_value) selected="selected" @endif>{{$dimension_key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Diameter/Depth</label>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <select name="diameter_1" id="diameter_1" class="form-control">

                                            @for($i = 0; $i <= $dimension_1_limit; $i++)
                                                <option value="{{$i}}"
                                                        @if($record->diameter_1 == $i) selected="selected" @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                        &nbsp;&nbsp;
                                        <select name="diameter_2" id="diameter_2" class="form-control">
                                            @foreach(config('constants.parts_dimensions') as $dimension_key => $dimension_value)
                                                <option value="{{$dimension_value}}"
                                                        @if($record->diameter_2 == $dimension_value) selected="selected" @endif>{{$dimension_key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="show_on_grillpartsgallery_com" class="col-md-3 control-label"> Show on
                                    Grillpartsgallery.com</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <label>
                                            <input type="radio" name="show_on_grillpartsgallery_com"
                                                   @if($record->show_on_grillpartsgallery_com == 1) checked="checked"
                                                   @endif value="1"> Yes
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="show_on_grillpartsgallery_com"
                                                   @if($record->show_on_grillpartsgallery_com == 0) checked="checked"
                                                   @endif value="0"> No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="show_on_bbqpartsfactory_com" class="col-md-3 control-label"> Show on
                                    Bbqpartsfactory.com</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <label>
                                            <input type="radio" name="show_on_bbqpartsfactory_com"
                                                   @if($record->show_on_bbqpartsfactory_com == 1) checked="checked"
                                                   @endif value="1"> Yes
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="show_on_bbqpartsfactory_com"
                                                   @if($record->show_on_bbqpartsfactory_com == 0) checked="checked"
                                                   @endif value="0"> No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="show_on_bbqpartszone_com" class="col-md-3 control-label"> Show on
                                    Bbqpartszone.com</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <label>
                                            <input type="radio" name="show_on_bbqpartszone_com" value="1"
                                                   @if($record->show_on_bbqpartszone_com == 1) checked="checked" @endif>
                                            Yes
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="show_on_bbqpartszone_com" value="0"
                                                   @if($record->show_on_bbqpartszone_com == 0) checked="checked" @endif>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <label for="categories" class="col-md-3 control-label"> Categories</label>
                                <div class="col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="categories_top" class="control-label">First:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <select class="categories-select2 dynamics" id="categories_top"
                                                        name="categories_top[]" dependent="categories_sub"
                                                        multiple="multiple">
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}"
                                                                @if(count($first_cats) > 0 && in_array($category->id, $first_cats)) selected="selected" @endif>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="categories_sub" class="control-label">Second:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <select class="categories-select2 dynamics" id="categories_sub"
                                                        dependent="categories_sub_sub" name="categories_sub[]"
                                                        multiple="multiple">
                                                    @foreach($sub_categories as $sub_category)
                                                        <option value="{{$sub_category->id}}"
                                                                @if(count($second_cats) > 0 && in_array($sub_category->id, $second_cats)) selected="selected" @endif>{{$sub_category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="categories_sub_sub" class="control-label">Third:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <select class="categories-select2" id="categories_sub_sub"
                                                        name="categories_sub_sub[]" multiple="multiple">
                                                    @foreach($sub_sub_categories as $sub_sub_category)
                                                        <option value="{{$sub_sub_category->id}}"
                                                                @if(count($third_cats) > 0 && in_array($sub_sub_category->id, $third_cats)) selected="selected" @endif>{{$sub_sub_category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="image">Image</label>
                                <div class="col-md-9">

                                    <table id="myTable" class=" table order-list">
                                        <thead>
                                        <tr>
                                            <td colspan="2"><p>Allowed File type jpg | png | jpeg | gif | bmp.</p></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="input-group">
                                                    <input filesize="10" extension="jpg|png|jpeg|gif|bmp" type="file"
                                                           name="images[]"
                                                           id="images" class="form-control">
                                                </div>
                                            </td>
                                            <td><a class="deleteRow"></a>

                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5" style="text-align: left;">
                                                <input type="button" class="btn btn-dark btn-md "
                                                       id="addrow"
                                                       value="Add New +"/>
                                            </td>
                                        </tr>
                                        <tr>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    @if($record->parts_images != null)
                                        <div class="row">
                                            @foreach($record->parts_images as $img)
                                                <div class="col-sm-4 card-body">
                                                    <div class="crop-avatar text-center">
                                                        <a href="javascript:void(0);"
                                                           class="btn btn-rem delete-part-image"
                                                           payload="part_image-{{@$img->id}}"><i class="fas fa-trash"
                                                                                                 aria-hidden="true"></i></a>
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

                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="image">Manual</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input filesize="10" extension="pdf|doc" type="file"
                                               name="manual"
                                               id="manual" class="form-control">
                                    </div>
                                    @if($record->parts_manuals != null)
                                        @foreach($record->parts_manuals as $manual)
                                            <div class="row">
                                                <div class="col-md-5 mt-1">
                                                    <a target="_blank"
                                                       href="{{$manual->getDocURL()}}">{{$manual->document}}</a>
                                                </div>
                                                <div class="col-md-4 mt-1">
                                                    <input type="button"
                                                           class="btn btn-danger btn-sm delete-part-manual" payload="part_manual-{{@$manual->id}}" value="Delete"/>
                                                </div>
                                            </div>
                                        @endforeach
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
                                <label for="" class="col-md-3 control-label"> Status</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <label>
                                            <input type="radio" @if($record->is_active == 1) checked="checked"
                                                   @endif name="status" value="1">
                                            Active
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" @if($record->is_active == 0) checked="checked"
                                                   @endif name="status" value="0">
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
    <script type="text/javascript">
        $(document).ready(function () {
            var counter = 0;

            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><div class="form-group"><input filesize="10" extension="jpg|png|jpeg|gif|bmp" type="file" name="images[]" id="images" class="form-control"></div></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                counter++;
            });


            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counter -= 1
            });


        });


        function calculateRow(row) {
            var price = +row.find('input[name^="image"]').val();

        }

        function calculateGrandTotal() {
            var grandTotal = 0;
            $("table.order-list").find('input[name^="image"]').each(function () {
                grandTotal += +$(this).val();
            });
            $("#grandtotal").text(grandTotal.toFixed(2));
        }
    </script>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('short_description');
        CKEDITOR.replace('long_description');
        CKEDITOR.replace('features');
        $(document).ready(function () {
            $('.categories-select2').select2({
                placeholder: "Select Category",
                allowClear: true
            });
        });
        $(document).ready(function () {
            /* category selection started */
            $('body').delegate(".dynamics", "change", function () {
                if ($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).attr('dependent');
                    var _token = $('input[name="_token"]').val();

                    var output;
                    if (dependent == "categories_sub") {
                        $('#categories_sub').html('<option value="">Select Second Category</option>');
                        $('#categories_sub_sub').html('<option value="">Select Third Category</option>');
                    }
                    if (dependent == "categories_sub_sub") {
                        $('#categories_sub_sub').html('<option value="">Select Third Category</option>');
                    }
                    $.ajax({
                        url: "{{route('admin-fetch-child-category')}}",
                        method: "POST",
                        data: {
                            select: select,
                            value: value,
                            _token: _token
                        },
                        success: function (result) {
                            for (var i = 0; i < result.length; i++) {
                                output += "<option value=" + result[i].id + ">" + result[i].name + "</option>";
                            }
                            $('#' + dependent).append(output);
                        }
                    });
                }
            });
            /* category selection ended */
            $(".delete-part-image").on("click", function (e) {
                e.preventDefault();
                var payload = $(this).attr("payload");
                var token = $('input[name="_token"]').val();
                var elm = $(this);
                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        url: "{{ route('admin-remove-part-image') }}",
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
            $(".delete-part-manual").on("click", function (e) {
                e.preventDefault();
                var payload = $(this).attr("payload");
                var token = $('input[name="_token"]').val();
                var elm = $(this);
                if (confirm('Are you sure you want to delete this manual?')) {
                    $.ajax({
                        url: "{{ route('admin-remove-part-document') }}",
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}
@stop
