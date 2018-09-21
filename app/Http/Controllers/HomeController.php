<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Stock;
use App\Prospect;
use App\MarketingGroup;
use App\SubBranch;
use App\Branch;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $n = \Carbon\Carbon::now();

        $stockKc = Stock::selectRaw('count(id) AS tot')
            ->where('last_status_id', '=', 1)
            ->where('branch_id', '=', 1)
            ->firstOrFail();

        $salesKc = Prospect::selectRaw('count(prospects.id) AS tot')
            ->join('prospect_activities', function($pa){
                $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                    ->where('prospect_activities.status_prospect_id', 5);
            })
            ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
            ->where('branch_id', '=', 1)
            ->where('last_status_id', '=', 3)
            ->whereMonth('do_date', $n->month)
            ->whereYear('do_date', $n->year)
            ->firstOrFail();

        $stockSg = Stock::selectRaw('count(id) AS tot')
            ->where('last_status_id', '=', 1)
            ->where('branch_id', '=', 2)
            ->firstOrFail();

        $salesSg = Prospect::selectRaw('count(prospects.id) AS tot')
            ->join('prospect_activities', function($pa){
                $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                    ->where('prospect_activities.status_prospect_id', 5);
            })
            ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
            ->where('branch_id', '=', 2)
            ->where('last_status_id', '=', 3)
            ->whereYear('do_date', $n->year)
            ->firstOrFail();

        $branches = Branch::select('id', 'name', 'alias')->get();

        $subBranches = SubBranch::select('id', 'branch_id', 'name')
            //->where('branch_id', '=', 1)
            ->get();

        $teamKcs = MarketingGroup::select('marketing_groups.id', 'marketing_groups.name', 'sub_branches.id AS sb_id')
            ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            //->where('branch_id', '=', 1)
            ->get();

        $saleKcs = Prospect::selectRaw('marketing_groups.id, marketing_groups.name, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
            ->join('prospect_activities', function($pa){
                $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                    ->where('prospect_activities.status_prospect_id', 5);
            })
            ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
            ->join('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            //->where('branch_id', '=', 1)
            ->where('last_status_id', '=', 3)
            ->whereYear('do_date', $n->year)
            ->groupBy('marketing_groups.name', DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'marketing_groups.id')
            ->get();

        // $prospects = Prospect::with('prospectActivity.statusProspect')
        //     ->selectRaw('marketing_groups.id, prospect_activities.status_prospect_id, count(prospects.id) AS tot')
        //     ->whereMonth('prospect_date', $n->month)
        //     ->whereYear('prospect_date', $n->year)
        //     ->groupBy('prospects.id', 'prospect_activities.status_prospect_id', 'marketing_groups.id')
        //     ->get();

        $prospects = Prospect::selectRaw('marketing_groups.id, prospect_activities.status_prospect_id, count(prospects.id) AS tot')
            ->leftjoin('prospect_activities', function($pa){
                $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')->orderBy('prospect_activities.id', 'DESC')->limit(1);
            })
            ->leftjoin('status_prospects', 'status_prospects.id', '=', 'prospect_activities.status_prospect_id')
            ->leftjoin('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
            ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->whereMonth('prospect_date', $n->month)
            ->whereYear('prospect_date', $n->year)
            ->groupBy('prospects.id', 'prospect_activities.status_prospect_id', 'marketing_groups.id')
            ->get();

        return view('home', compact('branches', 'subBranches', 'stockKc', 'salesKc', 'stockSg', 'salesSg', 'teamKcs', 'saleKcs', 'prospects'));
    }
}
