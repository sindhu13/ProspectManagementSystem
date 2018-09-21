<div class="table-responsive">
    <table class="table table-bordered table-striped" style="background-color: #f2f2f2;">
        <thead>
            <tr style="background-color: #e6e6e6;">
                <th>Team</th>
                <th>Low</th>
                <th>Medium</th>
                <th>Hot</th>
                <th>SPK</th>
                <th>DO</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
          <?php
              $mvars = array(
                  'jan' => array('month' => 1, 'tot' => 0), 'feb' => array('month' => 2, 'tot' => 0), 'mar' => array('month' => 3, 'tot' => 0),
                  'apr' => array('month' => 4, 'tot' => 0), 'mei' => array('month' => 5, 'tot' => 0),
              );
              $msstot = 0;
          ?>
          @foreach($subBranches as $subBranch)
           @if($branch->id == $subBranch->branch_id)
            @php($pvars = array(
                'jan' => array('month' => 1, 'tot' => 0), 'feb' => array('month' => 2, 'tot' => 0), 'mar' => array('month' => 3, 'tot' => 0),
                'apr' => array('month' => 4, 'tot' => 0), 'mei' => array('month' => 5, 'tot' => 0),
            ))
            @php($psstot = 0)
              <tr style="font-weight: bold; background-color: #e6e6e6;">
                <td colspan = "14" align="center">{{ $subBranch->name }}</td>
              </tr>

              @foreach($teamKcs as $teamKc)
                @if($subBranch->id == $teamKc->sb_id)
                  <tr>

                    <td style="font-weight: bold;">{{ $teamKc->name }}</td>
                    <?php
                        $vars = array(
                            'jan' => array('month' => 1, 'tot' => 0), 'feb' => array('month' => 2, 'tot' => 0), 'mar' => array('month' => 3, 'tot' => 0),
                            'apr' => array('month' => 4, 'tot' => 0), 'mei' => array('month' => 5, 'tot' => 0),
                        );
                    ?>
                    @php($sstot = 0)
                    @foreach($prospects as $prospect)
                      @if($prospect->id == $teamKc->id)
                        @if($prospect->s == 1)
                          @php($vars['jan']['tot'] = $prospect->tot)
                          @php($mvars['jan']['tot'] += $prospect->tot)
                          @php($pvars['jan']['tot'] += $prospect->tot)
                        @elseif($prospect->s == 2)
                          @php($vars['feb']['tot'] = $prospect->tot)
                          @php($mvars['feb']['tot'] += $prospect->tot)
                          @php($pvars['feb']['tot'] += $prospect->tot)
                        @elseif($prospect->s == 3)
                          @php($vars['mar']['tot'] = $prospect->tot)
                          @php($mvars['mar']['tot'] += $prospect->tot)
                          @php($pvars['mar']['tot'] += $prospect->tot)
                        @elseif($prospect->s == 4)
                          @php($vars['apr']['tot'] = $prospect->tot)
                          @php($mvars['apr']['tot'] += $prospect->tot)
                          @php($pvars['apr']['tot'] += $prospect->tot)
                        @else
                          @php($vars['mei']['tot'] = $prospect->tot)
                          @php($mvars['mei']['tot'] += $prospect->tot)
                          @php($pvars['mei']['tot'] += $prospect->tot)
                        @endif
                        @php($sstot += $prospect->tot)
                      @endif
                    @endforeach
                    @php($msstot += $sstot)
                    @php($psstot += $sstot)
                    <td>{{ $vars['jan']['tot'] }}</td><td>{{ $vars['feb']['tot'] }}</td><td>{{ $vars['mar']['tot'] }}</td>
                    <td>{{ $vars['apr']['tot'] }}</td><td>{{ $vars['mei']['tot'] }}</td>
                    <td style="font-weight: bold;">{{ $sstot }}</td>
                  </tr>
                @endif
              @endforeach

              <tr style="font-weight: bold;">
                <td>TOTAL</td>
                <td>{{ $pvars['jan']['tot'] }}</td><td>{{ $pvars['feb']['tot'] }}</td><td>{{ $pvars['mar']['tot'] }}</td>
                <td>{{ $pvars['apr']['tot'] }}</td><td>{{ $pvars['mei']['tot'] }}</td>
                <td>{{ $psstot }}</td>
              </tr>
              <tr>
                <td colspan="14">&nbsp;</td>
              </tr>
              @endif
            @endforeach

            <tr style="font-weight: bold;">
              <td>GRANT TOTAL</td>
              <td>{{ $mvars['jan']['tot'] }}</td><td>{{ $mvars['feb']['tot'] }}</td><td>{{ $mvars['mar']['tot'] }}</td>
              <td>{{ $mvars['apr']['tot'] }}</td><td>{{ $mvars['mei']['tot'] }}</td>
              <td>{{ $msstot }}</td>
            </tr>
        </tbody>
    </table>
</div>
