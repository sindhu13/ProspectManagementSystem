<div class="table-responsive">
    <table class="table table-bordered table-striped" style="background-color: #f2f2f2;">
        <thead>
            <tr style="background-color: #e6e6e6;">
                <th>Team</th>
                <th>Hot</th>
                <th>SPK</th>
                <th>DO</th>
            </tr>
        </thead>
             @foreach($subBranches as $subBranch) <!-- ================ Start Sub Branch ================== -->
                @if($branch->id == $subBranch->branch_id) <!-- ================ Start IF Sub Branch ================== -->
                    <tr style="font-weight: bold; background-color: #e6e6e6;">
                        <td colspan = "14" align="center">{{ $subBranch->name }}</td>
                    </tr>
                    @foreach($teamKcs as $teamKc) <!-- ================ Start Marketing Group ================== -->
                        @if($subBranch->id == $teamKc->sb_id) <!-- ================ Start IF Marketing Group ================== -->
                            <tr style="background-color: #e6e6e6;">
                                <th>Target</th>
                                <th style="color: #af0303;">360</th>
                                <th style="color: #af0303;">180</th>
                                <th style="color: #af0303;">90</th>
                            </tr>
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
                                <td>{{ $spk }}</td>
                                <td>{{ $do }}</td>
                            </tr>
                        @endif <!-- ================ End IF Marketing Group ================== -->
                    @endforeach <!-- ================ End Marketing Group ================== -->
                @endif <!-- ================ End IF Sub Branch ================== -->
            @endforeach <!-- ================ End Sub Branch ================== -->
        <tbody>

        </tbody>
    </table>
</div>
