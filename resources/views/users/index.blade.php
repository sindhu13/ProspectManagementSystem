{{-- \resources\views\branchs\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Users')

@section('content')

<div class="page-title">
    <div class="title_left">
        <h3>User <small>to get you started</small></h3>
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
                <h2>Sub Branch <small>Name</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('users.create') }}">Add New</a></li>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Roles</th>
                            <th>Last Modified</th>
                            <th>Operations</th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php ($i = 0)
                        @foreach ($users as $user)
                            @php ($i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>
                                <td>{{ date('d m Y', strtotime($user->created_at))}}</td>
                                <td>
                                    <div class="buttons">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'onsubmit' => 'return ConfirmDelete()', 'class' => 'delete' ]) !!}
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-xs" title="Edit"> <i class="fa fa-pencil"></i></a>
                                        {!! Form::button('<i class="fa fa-trash"> </i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) !!}
                                        {!! Form::close() !!}
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
