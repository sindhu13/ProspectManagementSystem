@extends('layouts.app')

@section('title', '| Add Role')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include ('errors.list') {{-- Including error file --}}
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>Role <small>Form Add New</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::open(array('url' => 'roles', 'class' => 'form-horizontal form-label-left')) !!}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Role <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('name', '', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Role'])}}
                    </div>
                </div>
                <h5><b>Assign Permissions</b></h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Assign Permissions</label>
                <div class="form-group">
                    @foreach ($permissions as $permission)
                        {{ Form::checkbox('permissions[]',  $permission->id ) }}
                        {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>
                    @endforeach
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        {{Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'send'])}}
                        <a class="btn btn-primary" href="{{ route('roles.index') }}">Cancel</a>
                    </div>
                </div>
                {!! Form:: close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
