@extends('layouts.app')

@section('content')

@role('Supervisor')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Prospect Activity  <small>Monthly progress</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @include('supervisortotal')
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row top_tiles">
    @foreach($branches as $branch)
        @foreach($stockKc as $stock)
            @if($branch->id == $stock->branch_id)
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-car"></i></div>
                        <div class="count">{{ $stock->tot }}</div>
                        <h3>Stock</h3>
                        <p>{{ $branch->name }}</p>
                    </div>
                </div>
            @endif
        @endforeach

        @foreach($salesKc as $sales)
            @if($branch->id == $sales->branch_id)
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="glyphicon glyphicon-tags"></i></div>
                        <div class="count">{{ $sales->tot }}</div>
                        <h3>Sales</h3>
                        <p>{{ $branch->name }}</p>
                    </div>
                </div>
            @endif
        @endforeach

    @endforeach
    </div>

    <!-- /top tiles -->
    @foreach($branches as $branch)
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Sales Summary {{ $branch->alias }} <small>Monthly progress</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @include('salespersupervisor')
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($branches as $branch)
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Prospect Summary {{ $branch->alias }} <small>Monthly progress</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @include('prospectstatus')
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($branches as $branch)
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Prospect Activity {{ $branch->alias }} <small>Monthly progress</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @include('prospectactivity')
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endrole

@endsection
