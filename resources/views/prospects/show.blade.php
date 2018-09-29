<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <section class="content invoice">
                    <div class="row">
                        <div class="col-xs-12 invoice-header">
                            <h1>
                                <small class="pull-right">Date: {{ date("d/m/Y", strtotime($prospect->prospect_date)) }}</small>
                            </h1>
                        </div>
                    </div>

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td width="20%">Booking Name</td>
                                        <td>{{ $prospect->booking_name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Booking Address</td>
                                        <td>{{ $prospect->booking_address }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Booking Phone</td>
                                        <td>{{ $prospect->booking_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">STNK Name</td>
                                        <td>{{ $prospect->stnk_name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">STNK Address</td>
                                        <td>{{ $prospect->stnk_address }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Unit</td>
                                        <td>{{ $prospect->unit->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Color</td>
                                        <td>{{ $prospect->color->name }}</td>
                                    </tr>
                                    @if(!empty($prospect->prospectActivity[0]->spk_number))
                                        <tr>
                                            <td width="20%">Chassis Code</td>
                                            <td>{{ $prospect->prospectActivity[0]->stock->chassis_code }}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">Engine Code</td>
                                            <td>{{ $prospect->prospectActivity[0]->stock->engine_code }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td width="20%">Supervisor</td>
                                        <td>{{ $prospect->marketingHasEmployee->marketingGroup->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Sales Force</td>
                                        <td>{{ $prospect->marketingHasEmployee->employee->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(!empty($prospect->prospectActivity[0]->spk_number))
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="lead">SPK Number: {{ $prospect->prospectActivity[0]->spk_number }}</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Spk Date</th>
                                                <td>{{ date("d/m/Y", strtotime($prospect->prospectActivity[0]->spk_date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>Rp. {{ number_format($prospect->prospectActivity[0]->spk_discount) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if(!empty($prospect->prospectActivity[0]->do_number))
                            <div class="col-xs-6">
                                <p class="lead">DO Number: {{ $prospect->prospectActivity[0]->do_number }}</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">DO Date</th>
                                                <td>{{ date("d/m/Y", strtotime($prospect->prospectActivity[0]->do_date)) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
