@php
    $model_id = (isset($record) && $record != null) ? $record->id : '';
@endphp
<script type="text/javascript">
    var model_id =  '{{$model_id}}';
    function addPart(partId, type) {
        var html_replace_id = $("#parts_lists");
        var loader = $('.loader-list-parts');
        $.ajax({
            type: "post",
            dataType: 'html',
            url: "{{route('admin-action-searched-parts')}}",
            data: {
                'pid': partId,
                'type': type,
                'action': 'add',
                'model_id': model_id,
                '_token': $('input[name="_token"]').val()
            },
            beforeSend: function () {
                loader.show();
            },
            success: function (response) {
                html_replace_id.fadeIn();
                html_replace_id.html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                html_replace_id.html("Some error");
            },
            complete: function () {
                loader.hide();
            }
        });
    }
    function partListActions(pid, type, action) {
        var value = pid;
        var html_replace_id = $("#parts_lists");
        var loader = $('.loader-list-parts');

        $.ajax({
            type: "post",
            dataType: 'html',
            url: "{{route('admin-action-searched-parts')}}",
            data: {
                'pid': value,
                'type': type,
                'action': action,
                'model_id': model_id,
                '_token': $('input[name="_token"]').val()
            },
            beforeSend: function () {
                loader.show();
            },
            success: function (response) {
                html_replace_id.fadeIn();
                html_replace_id.html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                html_replace_id.html("Some error");
            },
            complete: function () {
                loader.hide();
            }
        });
    }
</script>