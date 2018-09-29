<div class="table-responsive">
    <table class="table table-bordered table-striped" style="background-color: #f2f2f2;">
        <thead>
            <tr style="background-color: #e6e6e6;">
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Seller</th>
                <th colspan="2" style="text-align: center; vertical-align: middle;">Hot</th>
                <th colspan="2" style="text-align: center; vertical-align: middle;">SPK</th>
                <th colspan="2" style="text-align: center; vertical-align: middle;">DO</th>
            </tr>
            <tr style="background-color: #e6e6e6;">
                <th>Actual</th><th>Target</th>
                <th>Actual</th><th>Target</th>
                <th>Actual</th><th>Target</th>
            </tr>
        </thead>
        @foreach($subBranches as $subBranch)
            @role('Supervisor')
                <!-- Supervisor -->
            @else
                <tr style="font-weight: bold; background-color: #e6e6e6;">
                  <td colspan = "14" align="center">{{ $subBranch->name }}</td>
                </tr>
            @endif
            @foreach($teams as $team)
                 @if($subBranch->id == $team->sb_id)
                     @role('Supervisor')
                         <!-- Supervisor -->
                     @else
                         <tr>
                           <td colspan = "14" style="font-weight: bold;">{{ $team->name }}</td>
                         </tr>
                     @endif
                     @foreach($sellers as $seller) <!-- ================ Start Sellers ================== -->
                        @if($seller->marketing_group_id == $team->id)
                            <tr>
                                <td style="font-weight: bold;">&nbsp;&nbsp;&nbsp;{{ $seller->name }}</td>
                                @php($hot = $spk = $do = 0)
                                @foreach($activities as $prospect) <!-- ================ Start Prospect ================== -->
                                    @if($prospect->employee_id == $seller->employ_id) <!-- ================ Start IF Prospect ================== -->
                                        @if($prospect->status_prospect_id == 3)
                                            @php($hot += $prospect->tot)
                                        @elseif($prospect->status_prospect_id == 4)
                                            @php($spk += $prospect->tot)
                                        @elseif($prospect->status_prospect_id == 5)
                                            @php($do += $prospect->tot)
                                        @endif
                                    @endif <!-- ================ End IF Prospect ================== -->
                                @endforeach <!-- ================ End Prospect ================== -->
                                <td>{{ $hot }}</td>
                                <td style="color: red;">{{ (($seller->target * $seller->formula) * $seller->formula) }}</td>
                                <td>{{ $spk }}</td>
                                <td style="color: red;">{{ ($seller->target * $seller->formula) }}</td>
                                <td>{{ $do }}</td>
                                <td style="color: red;">{{ $seller->target }}</td>
                            </tr>
                        @endif
                     @endforeach <!-- ================ End Sub Branch ================== -->
                 @endif
            @endforeach
        @endforeach
        <tbody>

        </tbody>
    </table>
</div>
