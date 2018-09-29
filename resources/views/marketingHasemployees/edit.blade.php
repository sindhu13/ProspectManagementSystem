@extends('layouts.app')

@section('title', '| Update Sales Force')

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
                <h2>Sales Force <small>Form Update</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::model($marketingHasEmployee, array('route' => array('marketingHasEmployees.update', $marketingHasEmployee->id), 'method' => 'PUT', 'class' => 'form-horizontal form-label-left')) !!}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sales Force <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::hidden('marketing_group_id', $mgid)}}
                        {{Form::select('employee_id_', $employees, $marketingHasEmployee->employee_id, ['class' => 'form-control col-md-7 col-xs-12', 'disabled' => true])}}
                        {{Form::hidden('employee_id', null)}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Begin Work <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::date('begin_work', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $marketingHasEmployee->begin_work)->format('Y-m-d'), ['readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">End Work <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::date('end_work', '', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter End Work'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Target <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('target', $marketingHasEmployee->target[0]->target, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Target'])}}
                        {{Form::hidden('target_id', $marketingHasEmployee->target[0]->id)}}
                        {{Form::hidden('month', date('m'))}}
                        {{Form::hidden('year', date('Y'))}}
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        {{Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'send'])}}
                        <a class="btn btn-primary" href="{{ route('leasings.index') }}">Cancel</a>
                    </div>
                </div>
                {!! Form:: close() !!}

            </div>
        </div>
    </div>
</div>

@endsection
