{{-- resources/views/admin/orders/show.blade.php --}}

@extends('adminlte::page')

@section('title')
    Show >> {{$order_details->order_id}}
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@endsection

@section('content_header')
    <h1>Show >> {{$order_details->order_id}}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <a class="btn btn-lg btn-info" href="{{ route('admin-orders') }}"><i class="fa fa-list"></i> List</a>
                        <a class="btn btn-lg btn-default" href="javascript:void(0);" onclick="javascript:openWin('{{ route('print-order', ['id' => $order_details->order_id]) }}','printer_friendly', 'toolbar=0,location=0,status=0,menubar=1,scrollbars=1,resizable=1,width=640,height=500' );"><i class="fas fa-print"></i> Print</a>
                        <a class="btn btn-lg btn-info" href="{{ route('edit-order', ['id' => $order_details->order_id]) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a class="btn btn-lg btn-danger" href="{{ route('delete-order', ['id' => $order_details->order_id]) }}" onclick="javascript:return confirm('Are you sure you want to delete?');"><i class="fa fa-times"></i> Delete</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-bold">
                            # {{$order_details->order_id}} - {{date('F j Y h:i:s A', strtotime($order_details->order_date))}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.stores.orders.includes.order-details')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
@stop
