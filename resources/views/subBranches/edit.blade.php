@extends('layouts.app')

@section('title', '| Update New Sub Branch')

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
                <h2>Sub Branch <small>Form Add New</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::model($subBranch, array('route' => array('subBranches.update', $subBranch->id), 'method' => 'PUT', 'class' => 'form-horizontal form-label-left')) !!}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Branch <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::select('branch_id', $branches, null, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sub Branch <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('name', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Sub Branch'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('address', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Address'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Phone <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('phone', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Phone'])}}
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        {{Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'send'])}}
                        <a class="btn btn-primary" href="{{ route('subBranches.index') }}">Cancel</a>
                    </div>
                </div>
                {!! Form:: close() !!}

            </div>
        </div>
    </div>
</div>

@endsection
