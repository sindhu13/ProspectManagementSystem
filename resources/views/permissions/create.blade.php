
{{-- \resources\views\permissions\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Create Permission')

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
                <h2>Permission <small>Form Add New</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::open(array('url' => 'permissions', 'class' => 'form-horizontal form-label-left')) !!}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Permission <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('name', '', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Permission'])}}
                    </div>
                </div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Assign Roles</label>
                <div class="form-group">
                    @if(!$roles->isEmpty()) //If no roles exist yet
                        <h4>Assign Permission to Roles</h4>

                        @foreach ($roles as $role)
                            {{ Form::checkbox('roles[]',  $role->id ) }}
                            {{ Form::label($role->name, ucfirst($role->name)) }}<br>

                        @endforeach
                    @endif
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        {{Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'send'])}}
                        <a class="btn btn-primary" href="{{ route('permissions.index') }}">Cancel</a>
                    </div>
                </div>
                {!! Form:: close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
