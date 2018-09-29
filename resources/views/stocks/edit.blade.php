@extends('layouts.app')

@section('title', '| Update New Stock')

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
                <h2>Stock <small>Form Add New</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::model($stock, array('route' => array('stocks.update', $stock->id), 'method' => 'PUT', 'class' => 'form-horizontal form-label-left')) !!}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Branch <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::select('branch_id_', $branchs, $brn, ['class' => 'form-control col-md-7 col-xs-12', 'disabled' => 'true'])}}
                        {{Form::hidden('branch_id', $brn, ['class' => 'form-control col-md-7 col-xs-12'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Unit <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::select('unit_id', $units, null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Unit'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Color <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::select('color_id', $colors, null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Color'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Chassis Code <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('chassis_code', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Chassis Code'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Engine Code <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('engine_code', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Engine Code'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Year <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::selectyear('year', date("Y", strtotime(\Carbon\Carbon::now())) + 1, 2013, null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Year'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Position <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::select('position_id', $positions, null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Position'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Status <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::select('last_status_id', $statusStocks, null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Status'])}}
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        {{Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'send'])}}
                        <a class="btn btn-primary" href="{{ route('stocks.index') }}">Cancel</a>
                    </div>
                </div>
                {!! Form:: close() !!}

            </div>
        </div>
    </div>
</div>

@endsection
