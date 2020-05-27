@extends('adminlte::page')
@section('title', 'Models')
@section('content_header')
    <h1>Models</h1>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@endsection

@section('content')
    <div class="main-content">
        <div class="panel mb25">
            <div class="panel-body">
                <form method="get" action="{{ route('admin-models') }}" name="search-action-frm">
                    {!! Form::hidden('status', $status) !!}
                    <div class="row">
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

                        <div class="panel mb-3 col-sm-12">
                            <a id="new" href="{{ route('add-model') }}" class="btn btn-default mb15 ml15 mr-3"><i
                                        class="fa fa-plus fa-fw"></i>&nbsp;&nbsp;Add New&nbsp;</a>
                            <a href="{{ route('admin-models') }}" class="btn btn-primary mb15 ml15 mr-3"><i
                                        class="fa fa-list fa-fw"></i>&nbsp;&nbsp;All ({{$all_records}})&nbsp;</a>
                            <a href="{{ route('admin-models') }}?status=1" class="btn btn-success mb15 ml15 mr-3"><i
                                        class=" fa fa-thumbs-up text-success "></i>&nbsp;&nbsp;Active List ({{$active_records}})&nbsp;</a>
                            <a href="{{ route('admin-models') }}?status=0" class="btn btn-warning mb15 ml15 mr-3"><i
                                        class=" fa fa-thumbs-down text-warning "></i>&nbsp;&nbsp;In Active List ({{$inactive_records}})&nbsp;</a>
                        </div>
                        <div class="panel mb-3 col-sm-12">
                            <a id="action-delete" href="#" class="btn btn-danger mb15 ml15 mr-3"><i
                                        class="fa fa-trash fa-fw"></i>&nbsp;&nbsp;Delete&nbsp;</a>

                            <a id="action-active" href="#" class="btn btn-success mb15 ml15 mr-3"><i
                                        class="fa fa-thumbs-up text-success"></i>&nbsp;&nbsp;Make Active&nbsp;</a>

                            <a id="action-inactive" href="#" class="btn btn-warning mb15 ml15 mr-3"><i
                                        class="fa fa-thumbs-down text-warning"></i>&nbsp;&nbsp;Make In Active&nbsp;</a>
                        </div>
                        <div class="col-sm-6">
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
                        <div class="col-sm-6 input-group mb15">
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
                            {!! Form::open(array('route' => array('handle-manage-bulk-models'), 'method' => 'post', 'role' => 'form',  'class' => 'needs-validation', 'name' => 'bulk-action-frm')) !!}
                            {!! Form::hidden('action', '', array('id' => 'action')) !!}
                            <table class="table table-bordered bordered table-striped table-condensed datatable">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="cb-checkbox mb0" id="all_check"><span class="cb-inner"><i><input class="all_check " type="checkbox" id="all"></i></span>
                                        </label>
                                    </th>
                                    <th>Edit</th>
                                    <th>Status</th>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Thumbnail</th>
                                    <th>Brand</th>
                                    <th>Created On</th>
                                    <th>Modified On</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($records->total() > 0 && !empty($records))
                                    @foreach($records as $record)
                                        <tr>
                                            <td class="checkbox-row"><label class="cb-checkbox"><span class="cb-inner"><i><input type="checkbox" class="ids" name="ids[]" value="{{$record->id}}"></i></span></label>
                                            </td>
                                            <td>
                                                <a href="{{ route('edit-model', [$record->id]) }}"><i class="fas fa-pencil-alt"></i></a>
                                            </td>
                                            <td>
                                                <i style="font-size: 14px;"
                                                   class="fa fa-thumbs-<?php if ($record->status == "1"): echo 'up text-success'; else: echo 'down text-warning'; endif?>"></i>
                                            </td>
                                            <td><strong>{{$record->id}}</strong></td>
                                            <td>{{$record->name}}</td>
                                            <td>@if($record->getImg(false))<a href="{{$record->getImg()}}" target="_blank"><img src="{{$record->getImg()}}" border="0" width="100" /></a>@endif</td>
                                            <td>{{$record->brand->brand}}</td>
                                            <td>{{ date("F d, Y h:i A", strtotime($record->created_at))}}</td>
                                            <td>{{ date("F d, Y h:i A", strtotime($record->updated_at))}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div>
                    <div class="pull-left">
                        <div id="show_record_message">
                            Showing {{$records->total()}} entries
                        </div>
                    </div>
                    <div class="pull-right">
                        {{ $records->appends(['search' => $search, 'per_page' => $per_page, 'status' => $status])->links() }}
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
