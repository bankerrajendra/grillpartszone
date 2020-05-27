@foreach($assignedModels as $key => $brand_model)
    <div class="card">
        <div class="card-header bg-gray">
            <h5 class="brand-name">{{$brand_model['brand']}}</h5>
        </div>
        <div class="card-body">
            @foreach($brand_model['models'][0] as $model)
            <span class="rec" id="in-id-{{$model['id']}}"> {{$model['model_number']}} <a href="javascript:void(0);" class="pl-1" onclick="javascript:associateModel('{{$model['id']}}', 'remove');"><i class="fas fa-minus text-red"></i> </a></span>
            @endforeach
        </div>
    </div>
@endforeach