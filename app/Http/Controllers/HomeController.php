<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Helpers;
use App\Stock;
use App\Prospect;
use App\MarketingGroup;
use App\SubBranch;
use App\Branch;
use App\MarketingHasEmployee;

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
        if(Helpers::getBranch()->name == 'Supervisor'){
            $n = \Carbon\Carbon::now();

            $sellers = MarketingHasEmployee::selectRaw('marketing_has_employees.id, marketing_has_employees.marketing_group_id, employees.id AS employ_id, employees.name, targets.target, targets.formula')
                ->leftjoin('employees', 'employees.id', 'marketing_has_employees.employee_id')
                ->leftjoin('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->leftjoin('targets', function($q){
                    $n = \Carbon\Carbon::now();
                    $q->on('targets.marketing_has_employee_id', 'marketing_has_employees.id')
                        ->where('month', $n->month)
                        ->where('year', $n->year);
                })
                ->where('marketing_group_id', Helpers::getBranch()->marketingId)
                //->whereRaw('marketing_has_employees.end_work IS NULL')
                ->get();

            $activities = Prospect::selectRaw('marketing_has_employees.employee_id, prospect_activities.status_prospect_id, count(prospects.id) AS tot')
                ->leftjoin('prospect_activities', 'prospect_activities.prospect_id', '=', 'prospects.id')
                ->leftjoin('status_prospects', 'status_prospects.id', '=', 'prospect_activities.status_prospect_id')
                ->leftjoin('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
                ->leftjoin('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
                ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->where('status_prospects.id', '>', 2)
                ->where('marketing_group_id', Helpers::getBranch()->marketingId)
                ->whereMonth('prospect_date', $n->month)
                ->whereYear('prospect_date', $n->year)
                ->groupBy('prospects.id', 'prospect_activities.status_prospect_id', 'marketing_has_employees.employee_id')
                ->get();

            return view('home', compact('sellers', 'activities'));
        }else{
            $n = \Carbon\Carbon::now();

            if(Helpers::getBranch()->name == 'Branch Manager' || Helpers::getBranch()->name == 'Administration'){
                $branches = Branch::select('id', 'name', 'alias')->where('id', '>', 1)->where('id', Helpers::getBranch()->id)->get();
            }else{
                $branches = Branch::select('id', 'name', 'alias')->where('id', '>', 1)->get();
            }

            $stockKc = Stock::selectRaw('branch_id, count(id) AS tot')
                ->where('last_status_id', '=', 1)
                //->where('branch_id', '=', 1)
                ->groupBy('branch_id')
                ->get();

            $salesKc = Prospect::selectRaw('branch_id, count(prospects.id) AS tot')
                ->join('prospect_activities', function($pa){
                    $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                        ->where('prospect_activities.status_prospect_id', 5);
                })
                ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
                //->where('branch_id', '=', 1)
                ->where('last_status_id', '=', 3)
                ->whereMonth('do_date', $n->month)
                ->whereYear('do_date', $n->year)
                ->groupBy('branch_id')
                ->get();

            /*$stockSg = Stock::selectRaw('count(id) AS tot')
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
                ->firstOrFail();*/

            $subBranches = SubBranch::select('id', 'branch_id', 'name')
                //->where('branch_id', '=', 1)
                ->get();

            // $teamKcs = MarketingGroup::select('marketing_groups.id', 'marketing_groups.name', 'sub_branches.id AS sb_id')
            //     ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
            //     ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            //     //->where('branch_id', '=', 1)
            //     ->get();

            $teamKcs = MarketingHasEmployee::selectRaw('marketing_groups.id, marketing_groups.name, sub_branches.id AS sb_id, SUM(targets.target) as target, targets.formula')
                ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->leftjoin('employees', 'employees.id', 'marketing_has_employees.employee_id')
                ->leftjoin('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->leftjoin('targets', function($q){
                    $n = \Carbon\Carbon::now();
                    $q->on('targets.marketing_has_employee_id', 'marketing_has_employees.id')
                        ->where('month', $n->month)
                        ->where('year', $n->year);
                })
                ->groupBy('marketing_groups.id', 'marketing_groups.name', 'sub_branches.id', 'targets.formula')
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
                    $pa->on('prospect_activities.id', '=', DB::raw('(SELECT id FROM prospect_activities WHERE prospect_activities.prospect_id = prospects.id ORDER BY id DESC LIMIT 1 )'));
                })
                ->leftjoin('status_prospects', 'status_prospects.id', '=', 'prospect_activities.status_prospect_id')
                ->leftjoin('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
                ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->where('status_prospects.id', '>', 2)
                ->whereMonth('prospect_date', $n->month)
                ->whereYear('prospect_date', $n->year)
                ->groupBy('prospects.id', 'prospect_activities.status_prospect_id', 'marketing_groups.id')
                ->get();

            $activities = Prospect::selectRaw('marketing_groups.id, prospect_activities.status_prospect_id, count(prospects.id) AS tot')
                ->leftjoin('prospect_activities', 'prospect_activities.prospect_id', '=', 'prospects.id')
                ->leftjoin('status_prospects', 'status_prospects.id', '=', 'prospect_activities.status_prospect_id')
                ->leftjoin('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
                ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->where('status_prospects.id', '>', 2)
                ->whereMonth('prospect_date', $n->month)
                ->whereYear('prospect_date', $n->year)
                ->groupBy('prospects.id', 'prospect_activities.status_prospect_id', 'marketing_groups.id')
                ->get();

            return view('home', compact('branches', 'subBranches', 'stockKc', 'salesKc', 'stockSg', 'salesSg', 'teamKcs', 'saleKcs', 'prospects', 'activities'));
        }
    }

    public function supervisortotal(){
        $n = \Carbon\Carbon::now();
        $activities = Prospect::selectRaw('marketing_groups.id, prospect_activities.status_prospect_id, count(prospects.id) AS tot')
            ->leftjoin('prospect_activities', 'prospect_activities.prospect_id', '=', 'prospects.id')
            ->leftjoin('status_prospects', 'status_prospects.id', '=', 'prospect_activities.status_prospect_id')
            ->leftjoin('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
            ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->where('status_prospects.id', '>', 2)
            ->whereMonth('prospect_date', $n->month)
            ->whereYear('prospect_date', $n->year)
            ->groupBy('prospects.id', 'prospect_activities.status_prospect_id', 'marketing_groups.id')
            ->get();
            return $activities;
    }
}
