<div class="table-responsive">
    <table class="table table-bordered table-striped" style="background-color: #f2f2f2;">
        <thead>
            <tr style="background-color: #e6e6e6;">
                <th>Team</th>
                <th>January</th>
                <th>February</th>
                <th>March</th>
                <th>April</th>
                <th>May</th>
                <th>June</th>
                <th>July</th>
                <th>August</th>
                <th>September</th>
                <th>October</th>
                <th>November</th>
                <th>December</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
          <?php
              $mvars = array(
                  'jan' => array('month' => 1, 'tot' => 0), 'feb' => array('month' => 2, 'tot' => 0), 'mar' => array('month' => 3, 'tot' => 0),
                  'apr' => array('month' => 4, 'tot' => 0), 'mei' => array('month' => 5, 'tot' => 0), 'jun' => array('month' => 6, 'tot' => 0),
                  'jul' => array('month' => 7, 'tot' => 0), 'aug' => array('month' => 8, 'tot' => 0), 'sep' => array('month' => 9, 'tot' => 0),
                  'oct' => array('month' => 10, 'tot' => 0), 'nov' => array('month' => 11, 'tot' => 0), 'dec' => array('month' => 12, 'tot' => 0),
              );
              $msstot = 0;
          ?>
          @foreach($subBranches as $subBranch)
           @if($branch->id == $subBranch->branch_id)
            @php($pvars = array(
                'jan' => array('month' => 1, 'tot' => 0), 'feb' => array('month' => 2, 'tot' => 0), 'mar' => array('month' => 3, 'tot' => 0),
                'apr' => array('month' => 4, 'tot' => 0), 'mei' => array('month' => 5, 'tot' => 0), 'jun' => array('month' => 6, 'tot' => 0),
                'jul' => array('month' => 7, 'tot' => 0), 'aug' => array('month' => 8, 'tot' => 0), 'sep' => array('month' => 9, 'tot' => 0),
                'oct' => array('month' => 10, 'tot' => 0), 'nov' => array('month' => 11, 'tot' => 0), 'dec' => array('month' => 12, 'tot' => 0),
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
                            'apr' => array('month' => 4, 'tot' => 0), 'mei' => array('month' => 5, 'tot' => 0), 'jun' => array('month' => 6, 'tot' => 0),
                            'jul' => array('month' => 7, 'tot' => 0), 'aug' => array('month' => 8, 'tot' => 0), 'sep' => array('month' => 9, 'tot' => 0),
                            'oct' => array('month' => 10, 'tot' => 0), 'nov' => array('month' => 11, 'tot' => 0), 'dec' => array('month' => 12, 'tot' => 0),
                        );
                    ?>
                    @php($sstot = 0)
                    @foreach($saleKcs as $saleKc)
                      @if($saleKc->id == $teamKc->id)
                        @if($saleKc->m == 1)
                          @php($vars['jan']['tot'] = $saleKc->tot)
                          @php($mvars['jan']['tot'] += $saleKc->tot)
                          @php($pvars['jan']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 2)
                          @php($vars['feb']['tot'] = $saleKc->tot)
                          @php($mvars['feb']['tot'] += $saleKc->tot)
                          @php($pvars['feb']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 3)
                          @php($vars['mar']['tot'] = $saleKc->tot)
                          @php($mvars['mar']['tot'] += $saleKc->tot)
                          @php($pvars['mar']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 4)
                          @php($vars['apr']['tot'] = $saleKc->tot)
                          @php($mvars['apr']['tot'] += $saleKc->tot)
                          @php($pvars['apr']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 5)
                          @php($vars['mei']['tot'] = $saleKc->tot)
                          @php($mvars['mei']['tot'] += $saleKc->tot)
                          @php($pvars['mei']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 6)
                          @php($vars['jun']['tot'] = $saleKc->tot)
                          @php($mvars['jun']['tot'] += $saleKc->tot)
                          @php($pvars['jun']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 7)
                          @php($vars['jul']['tot'] = $saleKc->tot)
                          @php($mvars['jul']['tot'] += $saleKc->tot)
                          @php($pvars['jul']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 8)
                          @php($vars['aug']['tot'] = $saleKc->tot)
                          @php($mvars['aug']['tot'] += $saleKc->tot)
                          @php($pvars['aug']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 9)
                          @php($vars['sep']['tot'] = $saleKc->tot)
                          @php($mvars['sep']['tot'] += $saleKc->tot)
                          @php($pvars['sep']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 10)
                          @php($vars['oct']['tot'] = $saleKc->tot)
                          @php($mvars['oct']['tot'] += $saleKc->tot)
                          @php($pvars['oct']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 11)
                          @php($vars['nov']['tot'] = $saleKc->tot)
                          @php($mvars['nov']['tot'] += $saleKc->tot)
                          @php($pvars['nov']['tot'] += $saleKc->tot)
                        @elseif($saleKc->m == 11)
                          @php($vars['dec']['tot'] = $saleKc->tot)
                          @php($mvars['dec']['tot'] += $saleKc->tot)
                          @php($pvars['dec']['tot'] += $saleKc->tot)
                        @endif
                        @php($sstot += $saleKc->tot)
                      @endif
                    @endforeach
                    @php($msstot += $sstot)
                    @php($psstot += $sstot)
                    <td>{{ $vars['jan']['tot'] }}</td><td>{{ $vars['feb']['tot'] }}</td><td>{{ $vars['mar']['tot'] }}</td><td>{{ $vars['apr']['tot'] }}</td>
                    <td>{{ $vars['mei']['tot'] }}</td><td>{{ $vars['jun']['tot'] }}</td><td>{{ $vars['jul']['tot'] }}</td><td>{{ $vars['aug']['tot'] }}</td>
                    <td>{{ $vars['sep']['tot'] }}</td><td>{{ $vars['oct']['tot'] }}</td><td>{{ $vars['nov']['tot'] }}</td><td>{{ $vars['dec']['tot'] }}</td>
                    <td style="font-weight: bold;">{{ $sstot }}</td>
                  </tr>
                @endif
              @endforeach

              <tr style="font-weight: bold;">
                <td>TOTAL</td>
                <td>{{ $pvars['jan']['tot'] }}</td><td>{{ $pvars['feb']['tot'] }}</td><td>{{ $pvars['mar']['tot'] }}</td><td>{{ $pvars['apr']['tot'] }}</td>
                <td>{{ $pvars['mei']['tot'] }}</td><td>{{ $pvars['jun']['tot'] }}</td><td>{{ $pvars['jul']['tot'] }}</td><td>{{ $pvars['aug']['tot'] }}</td>
                <td>{{ $pvars['sep']['tot'] }}</td><td>{{ $pvars['oct']['tot'] }}</td><td>{{ $pvars['nov']['tot'] }}</td><td>{{ $mvars['dec']['tot'] }}</td>
                <td>{{ $psstot }}</td>
              </tr>
              <tr>
                <td colspan="14">&nbsp;</td>
              </tr>
              @endif
            @endforeach

            <tr style="font-weight: bold;">
              <td>GRANT TOTAL</td>
              <td>{{ $mvars['jan']['tot'] }}</td><td>{{ $mvars['feb']['tot'] }}</td><td>{{ $mvars['mar']['tot'] }}</td><td>{{ $mvars['apr']['tot'] }}</td>
              <td>{{ $mvars['mei']['tot'] }}</td><td>{{ $mvars['jun']['tot'] }}</td><td>{{ $mvars['jul']['tot'] }}</td><td>{{ $mvars['aug']['tot'] }}</td>
              <td>{{ $mvars['sep']['tot'] }}</td><td>{{ $mvars['oct']['tot'] }}</td><td>{{ $mvars['nov']['tot'] }}</td><td>{{ $mvars['dec']['tot'] }}</td>
              <td>{{ $msstot }}</td>
            </tr>
        </tbody>
    </table>
</div>
