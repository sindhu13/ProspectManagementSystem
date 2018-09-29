{{-- \resources\views\branchs\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Stocks')

@section('content')

<div class="page-title">
    <div class="title_left">
        <h3>Stocks <small>to get you started</small></h3>
    </div>
</div>

<div class="clearfix"></div>

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
                <h2>Stock <small>Name</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('stocks.create') }}">Add New</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Unit</th>
                            <th>Color</th>
                            <th>Chassis Code</th>
                            <th>Engine Code</th>
                            <th>Position</th>
                            <th>Branch</th>
                            <th>Status</th>
                            @role('Super User|Admin')
                            <th>Operations</th></th>
                            @endrole
                        </tr>
                    </thead>

                    <tbody>
                        @php ($i = 0)
                        @foreach ($stocks as $stock)
                            @php ($i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $stock->unit->name }}</td>
                                <td>{{ $stock->color->name }}</td>
                                <td>{{ $stock->chassis_code }}</td>
                                <td>{{ $stock->engine_code }}</td>
                                <td>{{ $stock->position->name }}</td>
                                <td>{{ $stock->branch->alias }}</td>
                                @if($stock->last_status_id == 1)
                                    <td>In Stock</td>
                                @elseif($stock->last_status_id == 2)
                                    <td>SPK</td>
                                @else
                                    <td>DO</td>
                                @endif
                                @role('Super User|Admin')
                                <td>
                                    <div class="buttons">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['stocks.destroy', $stock->id], 'onsubmit' => 'return ConfirmDelete()', 'class' => 'delete' ]) !!}
                                        <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-info btn-xs" title="Edit"> <i class="fa fa-pencil"></i></a>
                                        {!! Form::button('<i class="fa fa-trash"> </i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    function ConfirmDelete(){
        return confirm('Are you sure?');
    }
</script>
@endsection
