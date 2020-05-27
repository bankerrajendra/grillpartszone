@foreach($brandsModels as $brandName => $associatedModels)
    <div class="card">
        <div class="card-header bg-gray">
            <h5 class="brand-name">{{$brandName}}</h5>
        </div>
        @if(isset($associatedModels) && count($associatedModels) > 0)
            <div class="card-body">
                @foreach($associatedModels as $model)
                    @if(!in_array($model->id, $alreadyAssignedModels)) <span class="rec" id="out-id-{{$model->id}}"> {{$model->model_number}} <a href="javascript:void(0);" class="pl-1" onclick="javascript:associateModel('{{$model->id}}', 'add');"><i class="fas fa-plus text-red"></i> </a></span>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endforeach