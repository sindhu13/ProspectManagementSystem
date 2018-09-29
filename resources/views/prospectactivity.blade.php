<div class="table-responsive">
    <table class="table table-bordered table-striped" style="background-color: #f2f2f2;">
        <thead>
            <tr style="background-color: #e6e6e6;">
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Team</th>
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
             @foreach($subBranches as $subBranch) <!-- ================ Start Sub Branch ================== -->
                @if($branch->id == $subBranch->branch_id) <!-- ================ Start IF Sub Branch ================== -->
                    <tr style="font-weight: bold; background-color: #e6e6e6;">
                        <td colspan = "14" align="center">{{ $subBranch->name }}</td>
                    </tr>
                    @foreach($teamKcs as $teamKc) <!-- ================ Start Marketing Group ================== -->
                        @if($subBranch->id == $teamKc->sb_id) <!-- ================ Start IF Marketing Group ================== -->
                            <tr>
                                <td style="font-weight: bold;">{{ $teamKc->name }}</td>

                                @php($hot = $spk = $do = 0)
                                @foreach($activities as $prospect) <!-- ================ Start Prospect ================== -->
                                    @if($prospect->id == $teamKc->id) <!-- ================ Start IF Prospect ================== -->
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
                                <td style="color: red;">{{ (($teamKc->target * $teamKc->formula) * $teamKc->formula) }}</td>
                                <td>{{ $spk }}</td>
                                <td style="color: red;">{{ ($teamKc->target * $teamKc->formula) }}</td>
                                <td>{{ $do }}</td>
                                <td style="color: red;">{{ $teamKc->target }}</td>
                            </tr>
                        @endif <!-- ================ End IF Marketing Group ================== -->
                    @endforeach <!-- ================ End Marketing Group ================== -->
                @endif <!-- ================ End IF Sub Branch ================== -->
            @endforeach <!-- ================ End Sub Branch ================== -->
        <tbody>

        </tbody>
    </table>
</div>
