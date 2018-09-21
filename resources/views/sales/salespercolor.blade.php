{{-- \resources\views\branchs\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Units')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <div class="alert alert-{{ $msg }} alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>{{ Session::get('alert-' . $msg) }}</strong>.
                </div>
            @endif
        @endforeach
        <div class="x_panel">
            <div class="x_title">
                <h2>Sales PerColor <small>.</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            {!! Form::open(['method' => 'get', 'url' => '/sales/salespercolor', 'class' => 'navbar-form navbar-right', 'role' => 'search']) !!}
            @php($now = Carbon\Carbon::now())
            {{ Form::select('branch_id', $branches, 1, ['class' => 'form-control', 'id' => 'salesPerColorSearchId']) }}
            {{ Form::selectYear('yearsearch', $now->year, 2015, $now->year, ['class' => 'form-control', 'id' => 'salesPerColorSearchYear']) }}
            {!! Form:: close() !!}

            <div class="x_content">
                @include('sales.salespercolorajax')
            </div>
        </div>
    </div>
</div>
@endsection
