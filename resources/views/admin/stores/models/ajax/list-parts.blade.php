@if($results != null && count($results) > 0)
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Model #</th>
            <th scope="col">Title</th>
            <th scope="col" colspan="3">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($results as $part)
            <tr>
                <td width='60'>{{$part['id']}}</td>
                <td width='150'># {{$part['model_no']}}</td>
                <td width='300'>{{$part['name']}}</td>
                <td width='60'><a href="javascript:void(0);" onclick="javascript: partListActions('{{$part['id']}}', '{{$type}}', 'remove');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                <td width='60'><a href="javascript:void(0);" onclick="javascript: partListActions('{{$part['id']}}', '{{$type}}', 'moveup');"><i class="fa fa-arrow-up" aria-hidden="true"></i></a></td>
                <td width='60'><a href="javascript:void(0);" onclick="javascript: partListActions('{{$part['id']}}', '{{$type}}', 'movedown');"><i class="fa fa-arrow-down" aria-hidden="true"></i></a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <input type="hidden" name="hideparts" id="hideparts" value="{{$parts_ids}}">
@endif