{{-- \resources\views\prospects\spk.blade.php --}}
@extends('layouts.app')

@section('title', '| Prospects DO')

@section('content')

<div class="page-title">
    <div class="title_left">
        <h3>Prospects DO <small>to get you started</small></h3>
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
                <h2>Prospects <small>Name</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Booking Name</th>
                            <th>Stnk Name</th>
                            <th>Unit</th>
                            <th>Color</th>
                            <th>Sales Force</th>
                            <th>Status</th>
                            <th>Operations</th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php ($i = 0)
                        @foreach ($prospects as $prospect)
                            @php ($i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ date('d m Y', strtotime($prospect->prospect_date))}}</td>
                                <td>{{ $prospect->booking_name }}</td>
                                <td>{{ $prospect->stnk_name }}</td>
                                <td>{{ $prospect->unit->name }}</td>
                                <td>{{ $prospect->color->name }}</td>
                                <td>{{ $prospect->marketingHasEmployee->employee->name }}</td>
                                <td>{{ $prospect->prospectActivity[0]->statusProspect->name }}</td>
                                <td>
                                    <div class="buttons">
                                        <button type="button" class="btn btn-primary btn-xs" id="modaltest" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-eye"></i></button>
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

<!-- Start Large modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Prospect</h4>
            </div>
            <div class="modal-body-prospect">
                test
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<!-- End Large modal -->

<script>
    function ConfirmDelete(){
        return confirm('Are you sure?');
    }
</script>
@endsection
