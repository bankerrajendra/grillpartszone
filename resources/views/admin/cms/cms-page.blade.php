{{--@extends('layouts.admin')--}}
@extends('adminlte::page')
@section('title', 'CMS Pages')
@section('content_header')
    <h1>CMS Pages Records</h1>
@stop


@section('css')
    @if(config('laravelusers.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('laravelusers.datatablesCssCDN') }}">

    @endif
    <link rel="stylesheet" type="text/css" href="/vendor/adminlte/css/auth.css">
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="box">
                    <div class="box-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Showing All <strong>Static Pages</strong> Records
                            </span>


                        </div>
                    </div>


                    <div class="box-body">

                        {{--@if(config('usersmanagement.enableSearchUsers'))--}}
                        {{--@include('partials.search-users-form')--}}
                        {{--@endif--}}

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{$pageslist->count()}} records total
                                </caption>
                                <thead class="thead">
                                <tr>
                                    <th>Id</th>
                                    <th>Page Title</th>
                                    <th class="hidden-xs">Slug</th>
                                    <th>Status</th>
                                    <th class="hidden-sm hidden-xs hidden-md">created On</th>
                                    <th class="hidden-sm hidden-xs hidden-md">Updated On</th>
                                    <th>Action</th>
                                    {{--<th class="no-search no-sort"></th>--}}
                                    {{--<th class="no-search no-sort"></th>--}}
                                </tr>
                                </thead>
                                <tbody id="cmscitystate_table">
                                @foreach($pageslist as $cms)
                                    <tr>
                                        <td>{{$cms->id}}</td>
                                        <td>{{$cms->page_title}}</td>
                                        <td class="hidden-xs">{{$cms->slug}}</td>
                                        <td>	@if($cms->status=="1")
                                                Active
                                            @else
                                                Inactive
                                            @endif</td>
                                        <td class="hidden-sm hidden-xs hidden-md">{{$cms->created_at}}</td>
                                        <td class="hidden-sm hidden-xs hidden-md">{{$cms->updated_at}}</td>
                                        <td>
                                            <a class="btn btn-sm btn-info btn-block" href="{{route('set-cms-page',['id'=>$cms->id])}}" data-toggle="tooltip" title="Edit">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>


                            </table>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--@include('modals.modal-delete')--}}

@endsection

@section('js')
    @if ((count($pageslist) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    {{--@if(config('usersmanagement.enableSearchUsers'))--}}
    {{--@include('scripts.search-users')--}}
    {{--@endif--}}
@endsection
