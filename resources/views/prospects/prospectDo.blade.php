@extends('layouts.app')

@section('title', '| Update SPK to DO')

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
                <h2>SPK <small>Form Update to DO</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::model($prospect, array('route' => array('prospects.updateDo', $prospect->id), 'method' => 'PUT', 'class' => 'form-horizontal form-label-left')) !!}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Prospect Date <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::date('prospect_date', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $prospect->prospect_date)->format('Y-m-d'), ['readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Booking Name <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('booking_name', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter name', 'readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Booking Address <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('booking_address', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Address', 'readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Booking Phone <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('booking_phone', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Phone', 'readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Stnk Name <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('stnk_name', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Name', 'readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Stnk Address <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('stnk_address', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Address', 'readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Unit <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::select('unit_id_', $units, null, array('class' => 'form-control', 'id' => 'spk_unit', 'disabled' => 'true')) }}
                        {{Form::hidden('unit_id', null, ['class' => 'form-control col-md-7 col-xs-12'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Color <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::select('color_id_', $colors, null, array('class' => 'form-control', 'id' => 'spk_color', 'disabled' => 'true')) }}
                        {{Form::hidden('color_id', null, ['class' => 'form-control col-md-7 col-xs-12'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Marketing Team <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::select('marketing_has_employee_id_', $optional, null, array('class' => 'form-control', 'disabled' => 'true')) }}
                        {{Form::hidden('marketing_has_employee_id', null, ['class' => 'form-control col-md-7 col-xs-12'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Status <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::select('status_prospect_id', $statusProspects, $prospect->prospectActivity[0]->status_prospect_id, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">SPK Date <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::date('spk_date', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $prospect->prospectActivity[0]->spk_date)->format('Y-m-d'), ['readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">SPK Number <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('spk_number', $prospect->prospectActivity[0]->spk_number, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Spk Number', 'readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">SPK Discount <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('spk_discount', $prospect->prospectActivity[0]->spk_discount, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Spk Discount', 'readonly' => 'true'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Chassis And Engine Code <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::select('stock_id_', $stocks, 1, array('class' => 'form-control', 'id' => 'spk_stock', 'disabled' => 'true')) }}
                        {{Form::hidden('stock_id', $prospect->prospectActivity[0]->stock_id, ['class' => 'form-control col-md-7 col-xs-12'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">DO Number <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::text('do_number', '', ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter DO Number'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Description <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::textarea('prospect_desc', $prospect->prospectActivity[0]->prospect_desc, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Enter Description'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">DO Date <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::date('do_date', \Carbon\Carbon::now(), ['class' => ''])}}
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        {{Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'send'])}}
                        <a class="btn btn-primary" href="{{ route('prospects.index') }}">Cancel</a>
                    </div>
                </div>
                {!! Form:: close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
