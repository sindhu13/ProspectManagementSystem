@extends('layouts.app')

@section('title', '| Set Formula')

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
                <h2>Formula <small>Set fot target</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::model($marketingHasEmployee, array('route' => array('marketingHasEmployees.setformula'), 'method' => 'PUT', 'class' => 'form-horizontal form-label-left')) !!}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Set <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('formula', $marketingHasEmployee[0]->target[0]->formula, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Target'])}}
                        {{Form::hidden('month', date('m'))}}
                        {{Form::hidden('year', date('Y'))}}
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        {{Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'send'])}}
                        <a class="btn btn-primary" href="{{ route('marketingHasEmployees.index') }}">Cancel</a>
                    </div>
                </div>
                {!! Form:: close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
