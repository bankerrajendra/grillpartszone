@extends('adminlte::page')
@section('title', 'Parts')
@section('content_header')
    <h1>Parts</h1>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@endsection

@section('content')
    <div class="main-content">
        <div class="panel mb25">
            <div class="panel-body">
                <form method="get" action="{{ route('admin-parts') }}" name="search-action-frm">
                    {!! Form::hidden('status', $status) !!}
                    <div class="row">
                        @if(session('success'))
                            <div class="col-sm-8 alert alert-success" role="alert">
                                {{session('success')}}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="col-sm-8 alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="panel mb-3 col-sm-12">
                            <a id="new" href="{{ route('add-part') }}" class="btn btn-default mb15 ml15 mr-3"><i
                                        class="fa fa-plus fa-fw"></i>&nbsp;&nbsp;Add New&nbsp;</a>
                            <a href="{{ route('admin-parts') }}" class="btn btn-primary mb15 ml15 mr-3"><i
                                        class="fa fa-list fa-fw"></i>&nbsp;&nbsp;All ({{$all_records}})&nbsp;</a>
                            <a href="{{ route('admin-parts') }}?status=1" class="btn btn-success mb15 ml15 mr-3"><i
                                        class=" fa fa-thumbs-up text-success "></i>&nbsp;&nbsp;Active List
                                ({{$active_records}})&nbsp;</a>
                            <a href="{{ route('admin-parts') }}?status=0" class="btn btn-warning mb15 ml15 mr-3"><i
                                        class=" fa fa-thumbs-down text-warning "></i>&nbsp;&nbsp;In Active List
                                ({{$inactive_records}})&nbsp;</a>
                        </div>
                        <div class="panel mb-3 col-sm-12">
                            <a id="action-delete" href="#" class="btn btn-danger mb15 ml15 mr-3"><i
                                        class="fa fa-trash fa-fw"></i>&nbsp;&nbsp;Delete&nbsp;</a>

                            <a id="action-active" href="#" class="btn btn-success mb15 ml15 mr-3"><i
                                        class="fa fa-thumbs-up text-success"></i>&nbsp;&nbsp;Make Active&nbsp;</a>

                            <a id="action-inactive" href="#" class="btn btn-warning mb15 ml15"><i
                                        class="fa fa-thumbs-down text-warning"></i>&nbsp;&nbsp;Make In Active&nbsp;</a>
                        </div>
                        <div class="col-sm-5">
                            <label>
                                Show
                            </label>
                            <label>
                                <select name="per_page" id="per_page" class="form-control">
                                    <option @if($per_page == "1")selected="selected" @endif value="1">1</option>
                                    <option @if($per_page == "2")selected="selected" @endif value="2">2</option>
                                    <option @if($per_page == "3")selected="selected" @endif value="3">3</option>
                                    <option @if($per_page == "5")selected="selected" @endif value="5">5</option>
                                    <option @if($per_page == "10")selected="selected" @endif value="10">10</option>
                                    <option @if($per_page == "20")selected="selected" @endif value="20">20</option>
                                    <option @if($per_page == "50")selected="selected" @endif value="50">50</option>
                                    <option @if($per_page == "100")selected="selected" @endif value="100">100</option>
                                </select>
                            </label>
                            <label>
                                entries
                            </label>
                        </div>
                        <div class="col-sm-3 input-group mb15 float-right">
                            <label for="search-with">Field:</label>&nbsp;<select class="form-control col-sm-11" id="search-with" name="search_with">
                                <option @if($search_with == '') selected="selected" @endif value=""></option>
                                <option @if($search_with == 'id') selected="selected" @endif value="id"> Catalog ID</option>
                                <option @if($search_with == 'sku') selected="selected" @endif value="sku">SKU</option>
                                <option @if($search_with == 'model_no') selected="selected" @endif value="model_no">Model #</option>
                                <option @if($search_with == 'item_no') selected="selected" @endif value="item_no">Item </option>
                                <option @if($search_with == 'name') selected="selected" @endif value="name">Title </option>
                            </select>
                        </div>
                        <div class="col-sm-4 input-group mb15">
                            <input type="search" name="search" id="search_field" class="form-control clearable x mr-2"
                                   value="{{$search}}" placeholder="Search here..">
                            <span class="input-group-btn pr10">
                        <button type="submit" class="btn btn-primary">Search</button>
                        </span>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            {!! Form::open(array('route' => array('handle-manage-bulk-parts'), 'method' => 'post', 'role' => 'form',  'class' => 'needs-validation', 'name' => 'bulk-action-frm')) !!}
                            {!! Form::hidden('action', '', array('id' => 'action')) !!}
                            <table class="table table-bordered bordered table-striped table-condensed datatable">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="cb-checkbox mb0" id="all_check"><span class="cb-inner"><i><input
                                                            class="all_check " type="checkbox" id="all"></i></span>
                                        </label>
                                    </th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>ID</th>
                                    <th>SKU</th>
                                    <th>Images</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Category (ID)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($records->total() > 0 && !empty($records))
                                    @foreach($records as $record)
                                        <tr>
                                            <td class="checkbox-row"><label class="cb-checkbox"><span
                                                            class="cb-inner"><i><input type="checkbox" class="ids"
                                                                                       name="ids[]"
                                                                                       value="{{$record->id}}"></i></span></label>
                                            </td>
                                            <td>
                                                <a  href="{{ route('edit-part', [$record->id]) }}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                / <a href="{{ route('admin-associate-models', [$record->id]) }}"><i
                                                            class="fas fa-plus"></i></a>
                                            </td>
                                            <td>
                                                <i style="font-size: 14px;"
                                                   class="fa fa-thumbs-<?php if ($record->is_active == 1): echo 'up text-success'; else: echo 'down text-warning'; endif?>"></i>
                                            </td>
                                            <td><strong>{{$record->id}}</strong></td>
                                            <td>{{$record->sku}}</td>
                                            <td>



                                                @if($record->parts_images != null)
                                                    @foreach($record->parts_images as $img)
                                                      <img alt="" src="{{$img->getImageURL()}}" width="100">
                                                    @endforeach
                                                @endif




                                            </td>
                                            <td>{{substr($record->name,0,80)}}</td>
                                            <td>{{$record->price}}</td>
                                            <td>
                                                @if($record->categories->count() > 0)
                                                    @php $i = 1; @endphp
                                                    @foreach($record->categories as $catInfo)
                                                        {{$catInfo->name}} ({{$catInfo->id}})
                                                        @if($i < $record->categories->count()), @endif
                                                        @php $i++; @endphp
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 float-left">
                        <div id="show_record_message">
                            Showing {{$records->total()}} entries
                        </div>
                    </div>
                    <div class="col-sm-8 float-right">
                        {{ $records->appends(['search_with' => $search_with, 'search' => $search, 'per_page' => $per_page, 'status' => $status])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $('#per_page').on('change', function () {
            $("form[name='search-action-frm']").submit();
        });
        $('.all_check').click(function () {
            $('input:checkbox').prop('checked', this.checked);
        });
        $('#action-delete').on('click', function () {
            bulkActionSubmit('delete', 'Are you sure you want to delete selected entries!');
        });
        $('#action-active').on('click', function () {
            bulkActionSubmit('1', 'Are you sure you want to make active selected entries!');
        });
        $('#action-inactive').on('click', function () {
            bulkActionSubmit('0', 'Are you sure you want to make in active selected entries!');
        });
        $('#action-order').on('click', function () {
            bulkActionSubmit('sort', 'Are you sure you want to change order of all entries!');
        });

        function bulkActionSubmit(action_val, message) {
            if (action_val == 'sort') {
                if (confirm(message)) {
                    $('#action').val(action_val);
                    $("form[name='bulk-action-frm']").submit();
                }
            } else {
                if ($('input[name="ids[]"]:checked').length > 0) {
                    if (confirm(message)) {
                        $('#action').val(action_val);
                        $("form[name='bulk-action-frm']").submit();
                    }
                } else {
                    alert('Select at-least one entry.');
                }
            }
        }
    </script>
@endsection
