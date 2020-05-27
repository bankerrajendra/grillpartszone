{{-- resources/views/admin/orders/print.blade.php --}}
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{config('app.url')}}</title>
    <link rel="stylesheet" href="{{config('app.url')}}/vendor/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
</head>
<body bgcolor="#FFFFFF" text="#000000">
<table align=center width="98%" bgcolor="#FFFFFF">
    <tr>
        <td align=center><a href="javascript:onclick=window.print();">Print Page</a> | <a href="javascript:onclick=window.close();">Close Window</a></td>
    </tr>
    <tr>
        <td align="center" class="text-bold"><br>
            # {{$order_details->order_id}} - {{date('F j Y h:i:s A', strtotime($order_details->order_date))}}
        </td>
    </tr>
    <tr>
        <td>
        @include('admin.stores.orders.includes.order-details')
        </td>
    </tr>
    <tr>
        <td align=center><a href="javascript:onclick=window.print()">Print Page</a> | <a href="JavaScript:onclick=window.close()">Close Window</a></td>
    </tr>
</table>
</body>
</html>

