{{-- resources/views/admin/parts/add.blade.php --}}

@extends('adminlte::page')

@section('title', 'Add Part')

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
                        <h1>Add Part</h1>
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
                            {!! Form::open(array('route' => array('handle-add-part'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'role' => 'form',  'class' => 'needs-validation', 'style' => 'display:inline')) !!}

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

                                <label for="model_no" class="col-md-3 control-label"> Model # <span
                                            class="text-danger">*</span></label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('model_no', '', array('id' => 'model_no', 'class' => 'form-control', 'placeholder' => 'Model #')) !!}
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

                            <div class="form-group row ">

                                <label for="long_description" class="col-md-3 control-label"> Long Description</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="long_description"
                                                  id="long_description" placeholder="Long Description"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="features" class="col-md-3 control-label"> Features</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea rows="5" cols="10" style="width: 100%;" name="features" id="features"
                                                  placeholder="Features"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="price" class="col-md-3 control-label"> Price</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('price', '', array('id' => 'price', 'class' => 'form-control', 'placeholder' => '0.00')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="retail_price" class="col-md-3 control-label"> Retail Price</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('retail_price', '', array('id' => 'retail_price', 'class' => 'form-control', 'placeholder' => '0.00')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="cost" class="col-md-3 control-label"> Cost</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('cost', '', array('id' => 'cost', 'class' => 'form-control', 'placeholder' => '0.00')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="stock" class="col-md-3 control-label"> Stock</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('stock', '', array('id' => 'stock', 'class' => 'form-control', 'placeholder' => '0')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="weight" class="col-md-3 control-label"> Weight</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('weight', '', array('id' => 'weight', 'class' => 'form-control', 'placeholder' => '0')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Length (Front to Back)</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select name="length_1" id="length_1" class="form-control">

                                            @for($i = 0; $i <= $dimension_1_limit; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        &nbsp;&nbsp;
                                        <select name="length_2" id="length_2" class="form-control">
                                            @foreach(config('constants.parts_dimensions') as $dimension_key => $dimension_value)
                                                <option value="{{$dimension_value}}">{{$dimension_key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Height</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select name="height_1" id="height_1" class="form-control">

                                            @for($i = 0; $i <= $dimension_1_limit; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        &nbsp;&nbsp;
                                        <select name="height_2" id="height_2" class="form-control">
                                            @foreach(config('constants.parts_dimensions') as $dimension_key => $dimension_value)
                                                <option value="{{$dimension_value}}">{{$dimension_key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Width</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select name="width_1" id="width_1" class="form-control">

                                            @for($i = 0; $i <= $dimension_1_limit; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        &nbsp;&nbsp;
                                        <select name="width_2" id="width_2" class="form-control">
                                            @foreach(config('constants.parts_dimensions') as $dimension_key => $dimension_value)
                                                <option value="{{$dimension_value}}">{{$dimension_key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row ">

                                <label for="" class="col-md-3 control-label"> Diameter/Depth</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select name="diameter_1" id="diameter_1" class="form-control">

                                            @for($i = 0; $i <= $dimension_1_limit; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        &nbsp;&nbsp;
                                        <select name="diameter_2" id="diameter_2" class="form-control">
                                            @foreach(config('constants.parts_dimensions') as $dimension_key => $dimension_value)
                                                <option value="{{$dimension_value}}">{{$dimension_key}}</option>
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
                                            <input type="radio" name="show_on_grillpartsgallery_com" value="1"
                                                   checked="checked">
                                            Yes
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="show_on_grillpartsgallery_com" value="0">
                                            No
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
                                            <input type="radio" name="show_on_bbqpartsfactory_com" value="1"
                                                   checked="checked">
                                            Yes
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="show_on_bbqpartsfactory_com" value="0">
                                            No
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
                                                   checked="checked">
                                            Yes
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="show_on_bbqpartszone_com" value="0">
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
                                                <select class="categories-select2 dynamics" id="categories_top" name="categories_top[]" dependent="categories_sub" multiple="multiple">
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
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
                                                <select class="categories-select2 dynamics" id="categories_sub" dependent="categories_sub_sub" name="categories_sub[]" multiple="multiple">
                                                    <option value="">Select second category</option>
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
                                                <select class="categories-select2" id="categories_sub_sub" name="categories_sub_sub[]" multiple="multiple">
                                                    <option value="">Select third category</option>
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
    <script type="text/javascript">
        $(document).ready(function () {

            /* category selection started */
            $('body').delegate(".dynamics", "change", function() {
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
                        success: function(result) {
                            for (var i = 0; i < result.length; i++) {
                                output += "<option value=" + result[i].id + ">" + result[i].name + "</option>";
                            }
                            $('#' + dependent).append(output);
                        }
                    });
                }
            });
            /* category selection ended */

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
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}
@stop
