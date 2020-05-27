@extends('adminlte::page')
@section('title', 'Orders')
@section('content_header')
    <h1>Orders</h1>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
    <style type="text/css">
        .table{
            font-size:11.5px;
        }
        .table-bordered > thead > tr > th{
            border-bottom-width: 0px;
        }
        .table tr td .checkbox{
            margin-top: 0px;
            margin-bottom: 0px;
        }
        .table tr td .checkbox input[type="checkbox"]{
            margin-left:0px!important;
        }
        .table tr td a{
            text-align:center;
        }
        .table i{
            color:#28a745;
        }
        .hiddenRow {
            padding: 0 4px !important;
            font-size: 13px;
            margin-top:-1px;
        }
        .btn-color{
            background:#28a745;;
            color:#fff;
            width:100%;
            padding:6px 10px;
            display: block;
        }
        .accordion-toggle{
            cursor:pointer;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="panel mb25">
            <div class="panel-body">
                <form method="get" action="{{ route('admin-orders') }}" name="search-action-frm">
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
                            <a href="{{ route('admin-orders') }}" class="btn btn-primary mb15 ml15 mr-3"><i class="fa fa-list fa-fw"></i>&nbsp;&nbsp;All ({{$all_records}})&nbsp;</a>
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
                        <div class="panel mb-3 col-sm-5">
                            <a id="action-delete" href="javascript:void(0);" class="btn btn-danger mb15 ml15 mr-3"><i class="fa fa-trash fa-fw"></i>&nbsp;&nbsp;Delete&nbsp;</a>
                            <a id="action-processed" href="javascript:void(0);" class="btn btn-success mb15 ml15 mr-3"><i class="fa fa-check" aria-hidden="true"></i>
                                &nbsp;&nbsp;Mark As Processed&nbsp;</a>
                            <a id="action-failed" href="javascript:void(0);" class="btn btn-warning mb15 ml15 mr-3"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;Mark As Failed&nbsp;</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-6 form-inline">
                                        <label>Only show Orders that are:</label>&nbsp;<select name="process_type" class="form-control" style="width: 150px;">
                                            <option value="" @if($process_type == '') selected="selected" @endif>All Orders</option>
                                            <option value="1" @if($process_type == '1') selected="selected" @endif>Processed</option>
                                            <option value="0" @if($process_type == '0') selected="selected" @endif>Unprocessed</option>
                                        </select>&nbsp;
                                        <select name="paid_type" class="form-control ml-2" style="width: 150px;">
                                            <option value="" @if($paid_type == '') selected="selected" @endif>All Orders</option>
                                            <option value="Yes" @if($paid_type == 'Yes') selected="selected" @endif>Payment Yes</option>
                                            <option value="No" @if($paid_type == 'No') selected="selected" @endif>Payment No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-inline">
                                        <label for="filter-catalog-lbl">Filter Orders on CatalogId:</label>&nbsp;<input type="text" value="{{$catalog_id}}" name="catalog_id" id="filter-catalog-lbl" class="form-control" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 input-group ">
                                        <label for="search-with">Field:</label>&nbsp;<select class="form-control col-sm-11" id="search-with" name="search_with">
                                            <option @if($search_with == '') selected="selected" @endif value=""></option>
                                            <option @if($search_with == 'order_id') selected="selected" @endif value="order_id"> Order Id</option>
                                            <option @if($search_with == 'user_id') selected="selected" @endif value="user_id"> Customer Id</option>
                                            <option @if($search_with == 'order_date') selected="selected" @endif value="order_date"> Order Date(d/m/Y)</option>
                                            <option @if($search_with == 'amount') selected="selected" @endif value="amount"> Amount</option>
                                            <option @if($search_with == 'tax') selected="selected" @endif value="tax"> Tax</option>
                                            <option @if($search_with == 'shipping_amount') selected="selected" @endif value="shipping_amount"> Shipping Amount</option>
                                            <option @if($search_with == 'shipping_email') selected="selected" @endif value="shipping_email"> Shipping Email</option>
                                            <option @if($search_with == 'shipping_company') selected="selected" @endif value="shipping_company"> Shipping Company</option>
                                            <option @if($search_with == 'shipping_name') selected="selected" @endif value="shipping_name"> Shipping Name</option>
                                            <option @if($search_with == 'shipping_address_1') selected="selected" @endif value="shipping_address_1"> Shipping Address 1</option>
                                            <option @if($search_with == 'shipping_address_2') selected="selected" @endif value="shipping_address_2"> Shipping Address 2</option>
                                            <option @if($search_with == 'shipping_mobile_number') selected="selected" @endif value="shipping_mobile_number"> Shipping Mobile Number</option>
                                            <option @if($search_with == 'shipping_country_id') selected="selected" @endif value="shipping_country_id"> Shipping Country</option>
                                            <option @if($search_with == 'shipping_state_id') selected="selected" @endif value="shipping_state_id"> Shipping State</option>
                                            <option @if($search_with == 'shipping_city_id') selected="selected" @endif value="shipping_city_id"> Shipping City</option>
                                            <option @if($search_with == 'shipping_zip') selected="selected" @endif value="shipping_zip"> Shipping Zip</option>
                                            <option @if($search_with == 'shipping_comment') selected="selected" @endif value="shipping_comment"> Shipping Comment</option>
                                            <option @if($search_with == 'order_method') selected="selected" @endif value="order_method"> Payment Method</option>
                                            <option @if($search_with == 'transaction_information') selected="selected" @endif value="transaction_information"> Transaction Details</option>
                                            <option @if($search_with == 'ip_address') selected="selected" @endif value="ip_address"> IP Address</option>
                                            <option @if($search_with == 'product_total_amount') selected="selected" @endif value="product_total_amount"> Product's Total Amount</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 input-group">
                                        <input type="search" name="search" id="search_field" class="form-control clearable x mr-2"
                                               value="{{$search}}" placeholder="Search here..">
                                        <span class="input-group-btn pr10">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            {!! Form::open(array('route' => array('handle-manage-bulk-orders'), 'method' => 'post', 'role' => 'form',  'class' => 'needs-validation', 'name' => 'bulk-action-frm')) !!}
                            {!! Form::hidden('action', '', array('id' => 'action')) !!}

                            <table class="table table-condensed table-bordered customer_orders_table"
                                   style="border-collapse:collapse;">
                                <thead>
                                <tr>
                                    <th>Orderid</th>
                                    <th>Customerid</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>Payment Type</th>
                                    <th>Store Name</th>
                                    <th>Proccessed</th>
                                    <th>Failed</th>
                                    <th>Print</th>
                                    <th>Track</th>
                                    <th>View</th>
                                    <th>Note</th>
                                    <th>Edit</th>
{{--                                    <th>Re-Mail</th>--}}
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($records != null)
                                    @foreach($records as $order)
                                        <tr @if($order->order_method == '') class="incomplete_row" @endif>
                                            <td><a href="javascript:void(0);" onclick="javascript:getOrderDetails({{$order->order_id}});">{{$order->order_id}}</a></td>
                                            <td>{{$order->user_id}}</td>
                                            <td>{{date('d/m/Y', strtotime($order->created_at))}}</td>
                                            <td>$ {{getAppropriatePrice($order->amount)}}</td>
                                            <td>{{$order->shipping_name}}</td>
                                            <td>{{$order->country->code}}</td>
                                            <td>{{$order->order_method}}</td>
                                            <td>{{$order->store_name}}</td>
                                            <td>
                                                @if($order->processed == 0) <div class="checkbox"><input name="processed[]" value="{{$order->order_id}}" type="checkbox"></div> @else YES @endif
                                            </td>
                                            <td>
                                                @if($order->order_method == '')<div class="checkbox"><input name="failed[]" value="{{$order->order_id}}" type="checkbox"></div>@else @if($order->order_method == 'Fail') YES @else NO @endif @endif
                                            </td>
                                            <td class="text-center"><a href="javascript:void(0);" onclick="javascript:openWin('{{ route('print-order', ['id' => $order->order_id]) }}','printer_friendly', 'toolbar=0,location=0,status=0,menubar=1,scrollbars=1,resizable=1,width=640,height=500' );"><i class="fa fa-print"
                                                                                  aria-hidden="true"></i></a></td>
                                            <td class="text-center"><a href=""><i class="fa fa-map-marker"
                                                                                  aria-hidden="true"></i></a></td>
                                            <td class="text-center"><a href="{{ route('show-order', ['id' => $order->order_id]) }}"><i class="fa fa-eye"
                                                                                  aria-hidden="true"></i></a></td>
                                            <td></td>
                                            <td class="text-center"><a href="{{ route('edit-order', ['id' => $order->order_id]) }}"><i class="fas fa-pencil-alt"
                                                                                  aria-hidden="true"></i></a></td>
{{--                                            <td class="text-center"><a href=""><i class="far fa-envelope"--}}
{{--                                                                                  aria-hidden="true"></i></a></td>--}}
                                            <td>
                                                <div class="checkbox"><input name="delete[]" value="{{$order->order_id}}" type="checkbox"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="accordian-body collapse" id="order-record-{{$order->order_id}}" aria-expanded="false" colspan="16">
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
                        {{ $records->appends(['search_with' => $search_with, 'search' => $search, 'per_page' => $per_page])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
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
        $('#action-processed').on('click', function () {
            bulkActionSubmit('processed', 'Are you sure you want to make processed selected entries!');
        });
        $('#action-failed').on('click', function () {
            bulkActionSubmit('failed', 'Are you sure you want to make failed selected entries!');
        });
        $('#action-order').on('click', function () {
            bulkActionSubmit('sort', 'Are you sure you want to change order of all entries!');
        });

        function bulkActionSubmit(action_val, message) {
            if (action_val == 'processed' || action_val == 'failed' || action_val == 'delete') {
                if ($('input[name="'+action_val+'[]"]:checked').length > 0) {
                    if (confirm(message)) {
                        $('#action').val(action_val);
                        $("form[name='bulk-action-frm']").submit();
                    }
                } else {
                    alert('Select at-least one entry.');
                }
            }
        }
        // get order details
        function getOrderDetails(order_id) {
            var html_order_detail = $('#order-record-'+order_id);
            if(html_order_detail.is(":visible")) {
                html_order_detail.hide("fast", "swing");
                return false;
            }
            $.ajax({
                type: "post",
                dataType: 'html',
                url: "{{route('admin-get-order-detail')}}",
                data: {
                    'order_id': order_id,
                    '_token': $('input[name="_token"]').val()
                },
                beforeSend: function () {
                    // loading
                },
                success: function (response) {
                    html_order_detail.html(response);
                    html_order_detail.show("fast", "swing");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                complete: function () {
                    // hide loader
                }
            });
        }
    </script>
@endsection
