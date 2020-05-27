@if($results != null)
    @foreach ($results as $part)
        <a href="javascript:;" onclick="javascript:addPart('{{$part->id}}', '{{$type}}');" >Add # {{$part->model_no}}</a> {{$part->name}}<br>
    @endforeach
@endif