@extends('layouts.app')

@section('title', '| Create New User')

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
                <h2>User <small>Form Add New</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::open(array('url' => 'users', 'class' => 'form-horizontal form-label-left')) !!}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('name', '', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter User'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('email', '', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Email'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Employee <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::select('employee_id', $employees, '', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Employees'])}}
                    </div>
                </div>
                <div class='form-group'>
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Role <span class="required">*</span></label>
                    @foreach ($roles as $role)
                        {{ Form::checkbox('roles[]',  $role->id ) }}
                        {{ Form::label($role->name, ucfirst($role->name)) }}<br>

                    @endforeach
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::password('password', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Password'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Confirm Password<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::password('password_confirmation', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Password'])}}
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        {{Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'send'])}}
                        <a class="btn btn-primary" href="{{ route('users.index') }}">Cancel</a>
                    </div>
                </div>
                {!! Form:: close() !!}

            </div>
        </div>
    </div>
</div>

@endsection
