{{-- \resources\views\marketingGroups\show.blade.php --}}
@extends('layouts.app')

@section('title', '| Marketing Groups {{ $marketingGroup->name }}')

@section('content')

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
                <h2>{{ $marketingGroup->name }} <small>Marketing Group, Supervisor {{ $marketingGroup->employee->name }}</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('marketingHasEmployees/create/'.$marketingGroup->id) }}">Add New</a></li>
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
                            <th>Sales Forces</th>
                            <th>Begin Work</th>
                            <th>End Work</th>
                            <th>Last Modified</th>
                            <th>Operations</th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php ($i = 0)
                        @foreach ($marketingHasEmployees as $marketingHasEmployee)
                            @php ($i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $marketingHasEmployee->employee->name }}</td>
                                <td>{{ $marketingHasEmployee->employee->begin_work }}</td>
                                <td>{{ $marketingHasEmployee->employee->end_work }}</td>
                                <td>{{ date('d m Y', strtotime($marketingHasEmployee->created_at))}}</td>
                                <td>
                                    <div class="buttons">
                                        <a href="{{ route('marketingHasEmployees.edit', $marketingHasEmployee->id) }}" class="btn btn-info btn-xs" title="Edit"> <i class="fa fa-pencil"></i></a>
                                    </div>
                                </td>
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
