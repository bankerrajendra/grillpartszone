@extends('adminlte::page')
@section('title', 'Edit CMS Record')
@section('content_header')
    <h1>Edit Records</h1>
@stop

@section('css')
    <link rel="stylesheet" href="{{config('app.url')}}/css/admin_custom.css">
@stop
{{--@section('template_title')--}}
{{--@lang('usersmanagement.editing-user', ['name' => $user->name])--}}
{{--@endsection--}}

@section('template_linked_css')
    <style type="text/css">
        .btn-save,
        .pw-change-container {
            display: none;
        }
    </style>
@endsection

@section('content')
    {{--<div class="container">--}}
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="box">
                <div class="box-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                    </div>
                </div>



                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(array('route' => array('update-cms-page', $id), 'method' => 'post', 'role' => 'form', 'class' => 'needs-validation')) !!}


                            {!! csrf_field() !!}

                            <div class="form-group has-feedback row {{ $errors->has('page_title') ? ' has-error ' : '' }}">

                                <label for="page_title" class="col-md-3 control-label"> Page Title</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('page_title', $cmspageinfo->page_title, array('id' => 'page_title', 'class' => 'form-control', 'placeholder' => 'Page Title', 'readonly'=>'readonly')) !!}
                                    </div>
                                    @if($errors->has('page_title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('page_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>




                            <div class="form-group has-feedback row {{ $errors->has('page_description') ? ' has-error ' : '' }}">

                                <label for="page_description" class="col-md-3 control-label">Page Description </label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('page_description', $cmspageinfo->page_description, array('id' => 'page_description', 'class' => 'form-control', 'placeholder' => 'Page Description')) !!}


                                    </div>
                                    @if($errors->has('page_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('page_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('slug') ? ' has-error ' : '' }}">

                                <label for="slug" class="col-md-3 control-label"> Slug </label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('slug', $cmspageinfo->slug, array('id' => 'slug', 'class' => 'form-control', 'placeholder' => 'Slug', 'readonly'=>'readonly')) !!}
                                    </div>
                                    @if($errors->has('slug'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('meta_keyword') ? ' has-error ' : '' }}">

                                <label for="meta_keyword" class="col-md-3 control-label"> Meta Keywords</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('meta_keyword', $cmspageinfo->meta_keyword, array('id' => 'meta_keyword', 'class' => 'form-control', 'placeholder' => 'Meta Description')) !!}
                                    </div>
                                    @if($errors->has('meta_keyword'))
                                        <span class="help-block">
                            <strong>{{ $errors->first('meta_keyword') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('meta_title') ? ' has-error ' : '' }}">

                                <label for="meta_title" class="col-md-3 control-label">Meta Title</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('meta_title', $cmspageinfo->meta_title, array('id' => 'meta_title', 'class' => 'form-control', 'placeholder' => 'Meta Title')) !!}
                                    </div>
                                    @if($errors->has('meta_title'))
                                        <span class="help-block">
                            <strong>{{ $errors->first('meta_title') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('meta_description') ? ' has-error ' : '' }}">

                                <label for="meta_description" class="col-md-3 control-label">Meta Description</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('meta_description', $cmspageinfo->meta_description, array('id' => 'meta_description', 'class' => 'form-control', 'placeholder' => 'Meta Description')) !!}
                                    </div>
                                    @if($errors->has('meta_description'))
                                        <span class="help-block">
                            <strong>{{ $errors->first('meta_description') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group has-feedback row {{ $errors->has('status') ? ' has-error ' : '' }}">

                                <label for="status" class="col-md-3 control-label"> Status</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="custom-select form-control" name="status" id="status" disabled="disabled">
                                            <option value="1" {{ $cmspageinfo->status == '1' ? 'selected="selected"' : '' }}>Active</option>
                                            <option value="0" {{ $cmspageinfo->status == '0' ? 'selected="selected"' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    {!! Form::button('Submit', array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'submit', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--</div>--}}



@endsection

@section('js')
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('page_description');
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

@endsection
