<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Helpers;
use App\Prospect;
use App\Color;
use App\Unit;
use App\StatusProspect;
use App\MarketingGroup;
use App\MarketingHasEmployee;
use App\ProspectActivity;
use App\Stock;
use App\Leasing;
use App\Branch;
use App\UnitModel;
use App\SubBranch;

class ProspectController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Super User|Admin')->only('create', 'edit', 'updateDo', 'updateSpk', 'destroy');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $prospect = "";
        $brch = Helpers::getBranch();
        if(Helpers::getBranch()->alias == 'HO'){
            $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.statusProspect')->get();
        }else{
            if(Helpers::getBranch()->name == 'Supervisor'){
                $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.statusProspect')
                    ->wherehas('marketingHasEmployee.employee.subBranch', function($q){
                        $q->where('branch_id', Helpers::getBranch()->id);
                    })
                    ->wherehas('marketingHasEmployee', function($q){
                        $q->where('marketing_group_id', Helpers::getBranch()->marketingId);
                    })
                    ->get();
            }else{
                $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.statusProspect')
                    ->wherehas('marketingHasEmployee.employee.subBranch', function($q){
                        $q->where('branch_id', Helpers::getBranch()->id);
                    })
                    ->get();
            }
        }

        return view('prospects.index',compact('prospects', 'brch'));
    }

    public function spk()
    {
        $prospect = "";
        $brch = Helpers::getBranch();
        if(Helpers::getBranch()->alias == 'HO'){
            $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.stock', 'prospectActivity.statusProspect')
                ->whereRaw('(select status_prospect_id from prospect_activities where prospects.id = prospect_activities.prospect_id order by prospect_activities.id desc limit 1) = 4')
                ->get();
        }else{
            if(Helpers::getBranch()->name == 'Supervisor'){
                $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.stock', 'prospectActivity.statusProspect')
                    ->whereRaw('(select status_prospect_id from prospect_activities where prospects.id = prospect_activities.prospect_id order by prospect_activities.id desc limit 1) = 4')
                    ->wherehas('marketingHasEmployee.employee.subBranch', function($q){
                        $q->where('branch_id', Helpers::getBranch()->id);
                    })
                    ->wherehas('marketingHasEmployee', function($q){
                        $q->where('marketing_group_id', Helpers::getBranch()->marketingId);
                    })
                    ->get();
            }else{
                $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.stock', 'prospectActivity.statusProspect')
                    ->whereRaw('(select status_prospect_id from prospect_activities where prospects.id = prospect_activities.prospect_id order by prospect_activities.id desc limit 1) = 4')
                    ->wherehas('marketingHasEmployee.employee.subBranch', function($q){
                        $q->where('branch_id', Helpers::getBranch()->id);
                    })
                    ->get();
            }
        }
        return view('prospects.spk', ['prospects' => $prospects]);
    }

    public function doo()
    {
        $prospect = "";
        $brch = Helpers::getBranch();
        if(Helpers::getBranch()->alias == 'HO'){
            $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.stock', 'prospectActivity.statusProspect')
                ->whereRaw('(select status_prospect_id from prospect_activities where prospects.id = prospect_activities.prospect_id order by prospect_activities.id desc limit 1) = 5')
                ->get();
        }else{
            if(Helpers::getBranch()->name == 'Supervisor'){
                $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.stock', 'prospectActivity.statusProspect')
                    ->whereRaw('(select status_prospect_id from prospect_activities where prospects.id = prospect_activities.prospect_id order by prospect_activities.id desc limit 1) = 5')
                    ->wherehas('marketingHasEmployee.employee.subBranch', function($q){
                        $q->where('branch_id', Helpers::getBranch()->id);
                    })
                    ->wherehas('marketingHasEmployee', function($q){
                        $q->where('marketing_group_id', Helpers::getBranch()->marketingId);
                    })
                    ->get();
            }else{
                $prospects = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.stock', 'prospectActivity.statusProspect')
                    ->whereRaw('(select status_prospect_id from prospect_activities where prospects.id = prospect_activities.prospect_id order by prospect_activities.id desc limit 1) = 5')
                    ->wherehas('marketingHasEmployee.employee.subBranch', function($q){
                        $q->where('branch_id', Helpers::getBranch()->id);
                    })
                    ->get();
            }
        }
        return view('prospects.doo', ['prospects' => $prospects]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'prospect_date' => 'required',
            'booking_name' => 'required',
            'booking_address' => 'required',
            'booking_phone' => 'required',
            'stnk_name' => 'required',
            'stnk_address' => 'required',
            'unit_id' => 'required',
            'color_id' => 'required',
            'status_prospect_id' => 'required',
            'marketing_has_employee_id' => 'required',
        ]);

        $message = new Prospect;
        $message->prospect_date = $request->input('prospect_date');
        $message->booking_name = $request->input('booking_name');
        $message->booking_address = $request->input('booking_address');
        $message->booking_phone = $request->input('booking_phone');
        $message->stnk_name = $request->input('stnk_name');
        $message->stnk_address = $request->input('stnk_address');
        $message->unit_id = $request->input('unit_id');
        $message->color_id = $request->input('color_id');
        $message->marketing_has_employee_id = $request->input('marketing_has_employee_id');

        $acty = new ProspectActivity;
        $acty->status_prospect_id = $request->input('status_prospect_id');
        $acty->status_date = \Carbon\Carbon::now();
        $acty->prospect_desc = $request->input('prospect_desc');

        $message->save();
        $message->prospectActivity()->save($acty);

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Prospect was successful added!');
        return redirect()->route('prospects.index');
    }

    public function create(){
        $units = Unit::selectRaw('CONCAT (name, " - ", katashiki, " - ", suffix) as colums, id')->orderBy('colums')->pluck('colums', 'id');
        $colors = Color::selectRaw('CONCAT (name, " - ", code) as colums, id')->pluck('colums', 'id');
        $statusProspects = StatusProspect::limit(3)->orderBy('status_order')->pluck('name', 'id');
        $options = DB::table('marketing_has_employees')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.name AS svp', 'employees.id', 'employees.name')
            ->get();
        $mg = DB::table('marketing_groups')
            ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.id', 'marketing_groups.name')
            ->get();
        if(Helpers::getBranch()->alias == 'HO'){
            $sal = DB::table('marketing_has_employees')
                ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
                ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->select('marketing_groups.id AS svp', 'marketing_has_employees.id', 'employees.name')
                ->get();
        }else{
            $sal = DB::table('marketing_has_employees')
                ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
                ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->select('marketing_groups.id AS svp', 'marketing_has_employees.id', 'employees.name')
                ->where('branch_id', '=', Helpers::getBranch()->id)
                ->get();
        }
        foreach ($mg as $value) {
            foreach ($sal as $val) {
                if($val->svp == $value->id){
                    $optional[''. $value->name .''] = [$val->id => $val->name];
                }
            }
        }
        return view('prospects.create', compact('units', 'colors', 'statusProspects', 'optional'));
    }

    public function show(Request $request) {
        //$prospect = Prospect::findOrFail($id); //Find post of id = $id
        //return view ('prospects.show', compact('prospect'));

        // $prospect = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.stock','prospectActivity.statusProspect')
        //     ->whereHas('prospectActivity', function ($st){
        //         $st->where('status_prospect_id', 4);
        //     })->findOrFail($id);
        // return view('prospects.show', ['prospect' => $prospect]);

        if($request->ajax()){
            $prospect = Prospect::with('marketingHasEmployee.employee', 'prospectActivity.stock','prospectActivity.statusProspect', 'marketingHasEmployee.marketingGroup')
                ->findOrFail($request->id);

            $data = view('prospects.show',compact('prospect'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

    public function edit($id) {
        $prospect = Prospect::with('prospectActivity')->findOrFail($id);
        $units = Unit::selectRaw('CONCAT (name, " - ", katashiki, " - ", suffix) as colums, id')->pluck('colums', 'id');
        $colors = Color::selectRaw('CONCAT (name, " - ", code) as colums, id')->pluck('colums', 'id');
        $statusProspects = StatusProspect::limit(3)->orderBy('status_order')->pluck('name', 'id');
        $options = DB::table('marketing_has_employees')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.name AS svp', 'employees.id', 'employees.name')
            ->get();
        $mg = DB::table('marketing_groups')
            ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.id', 'marketing_groups.name')
            ->get();
        if(Helpers::getBranch()->alias == 'HO'){
            $sal = DB::table('marketing_has_employees')
                ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
                ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->select('marketing_groups.id AS svp', 'marketing_has_employees.id', 'employees.name')
                ->get();
        }else{
            $sal = DB::table('marketing_has_employees')
                ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
                ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->select('marketing_groups.id AS svp', 'marketing_has_employees.id', 'employees.name')
                ->where('branch_id', '=', Helpers::getBranch()->id)
                ->get();
        }
        foreach ($mg as $value) {
            foreach ($sal as $val) {
                if($val->svp == $value->id){
                    $optional[''. $value->name .''] = [$val->id => $val->name];
                }
            }
        }
        return view('prospects.edit', compact('prospect', 'units', 'colors', 'statusProspects', 'optional'));
    }

    public function update(Request $request, $id) {
        $spk = [
            'prospect_date' => 'required',
            'booking_name' => 'required',
            'booking_address' => 'required',
            'booking_phone' => 'required',
            'stnk_name' => 'required',
            'stnk_address' => 'required',
            'unit_id' => 'required',
            'color_id' => 'required',
            'status_prospect_id' => 'required',
            'marketing_has_employee_id' => 'required',
        ];

        if($request->input('spk_number') !== null){
            $spk += [
                'spk_number' => 'required|unique:prospect_activities,spk_number',
                'spk_date' => 'required',
                'spk_discount' => 'required',
            ];
        }
        $this->validate($request, $spk);

        $message = Prospect::findOrFail($id);
        $message->prospect_date = $request->input('prospect_date');
        $message->booking_name = $request->input('booking_name');
        $message->booking_address = $request->input('booking_address');
        $message->booking_phone = $request->input('booking_phone');
        $message->stnk_name = $request->input('stnk_name');
        $message->stnk_address = $request->input('stnk_address');
        $message->unit_id = $request->input('unit_id');
        $message->color_id = $request->input('color_id');
        $message->marketing_has_employee_id = $request->input('marketing_has_employee_id');

        $acty = new ProspectActivity;
        $acty->status_prospect_id = $request->input('status_prospect_id');
        $acty->status_date = \Carbon\Carbon::now();
        $acty->prospect_desc = $request->input('prospect_desc');
        if($request->input('spk_number') !== null){
            $acty->spk_number = $request->input('spk_number');
            $acty->spk_date = $request->input('spk_date');
            $acty->spk_discount = $request->input('spk_discount');
            $acty->stock_id = $request->input('stock_id');

            $stId = (int) $request->input('stock_id');
            $sto = Stock::findOrFail($stId);
            $sto->last_status_id = 2;
            $sto->save();
        }

        $message->save();
        $message->prospectActivity()->save($acty);

        $request->session()->flash('alert-success', 'Prospect was successful updated!');
        return redirect()->route('prospects.index');
    }

    public function updateDo(Request $request, $id) {
        $spk = [
            'prospect_date' => 'required',
            'booking_name' => 'required',
            'booking_address' => 'required',
            'booking_phone' => 'required',
            'stnk_name' => 'required',
            'stnk_address' => 'required',
            'unit_id' => 'required',
            'color_id' => 'required',
            'status_prospect_id' => 'required',
            'marketing_has_employee_id' => 'required',
            'do_number' => 'required|unique:prospect_activities,do_number',
            'do_date' => 'required',
        ];
        $this->validate($request, $spk);

        $message = Prospect::findOrFail($id);
        $message->prospect_date = $request->input('prospect_date');
        $message->booking_name = $request->input('booking_name');
        $message->booking_address = $request->input('booking_address');
        $message->booking_phone = $request->input('booking_phone');
        $message->stnk_name = $request->input('stnk_name');
        $message->stnk_address = $request->input('stnk_address');
        $message->unit_id = $request->input('unit_id');
        $message->color_id = $request->input('color_id');
        $message->marketing_has_employee_id = $request->input('marketing_has_employee_id');

        $acty = new ProspectActivity;
        $acty->status_prospect_id = $request->input('status_prospect_id');
        $acty->status_date = \Carbon\Carbon::now();
        $acty->prospect_desc = $request->input('prospect_desc');
        $acty->spk_number = $request->input('spk_number');
        $acty->spk_date = $request->input('spk_date');
        $acty->spk_discount = $request->input('spk_discount');
        $acty->stock_id = $request->input('stock_id');
        $acty->do_number = $request->input('do_number');
        $acty->do_date = $request->input('do_date');

        $stId = (int) $request->input('stock_id');
        $sto = Stock::findOrFail($stId);
        $sto->last_status_id = 3;
        $sto->save();

        $message->save();
        $message->prospectActivity()->save($acty);

        $request->session()->flash('alert-success', 'Prospect was successful updated!');
        return redirect()->route('prospects.do');
    }

    public function prospectSpk($id) {
        $prospect = Prospect::with('prospectActivity')->findOrFail($id);
        $units = Unit::selectRaw('CONCAT (name, " - ", katashiki, " - ", suffix) as colums, id')->pluck('colums', 'id');
        $colors = Color::selectRaw('CONCAT (name, " - ", code) as colums, id')->pluck('colums', 'id');
        $statusProspects = StatusProspect::whereIn('id', array(4))->orderBy('status_order')->pluck('name', 'id');
        $stocks = Stock::selectRaw('CONCAT (chassis_code, " - ", engine_code) as colums, id')
            ->where('unit_id', '=', $prospect->unit_id)->where('color_id', '=', $prospect->color_id)
            ->where('branch_id', '=', Helpers::getBranch()->id)->where('last_status_id', '=', 1)
            ->pluck('colums', 'id');
        $options = DB::table('marketing_has_employees')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.name AS svp', 'employees.id', 'employees.name')
            ->where('branch_id', '=', Helpers::getBranch()->id)
            ->get();
        $mg = DB::table('marketing_groups')
            ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.id', 'marketing_groups.name')
            ->get();
        $sal = DB::table('marketing_has_employees')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.id AS svp', 'marketing_has_employees.id', 'employees.name')
            ->where('branch_id', '=', Helpers::getBranch()->id)
            ->get();
        foreach ($mg as $value) {
            foreach ($sal as $val) {
                if($val->svp == $value->id){
                    $optional[''. $value->name .''] = [$val->id => $val->name];
                }
            }
        }

        if($prospect->prospectActivity[0]->status_prospect_id === 3 ){
            return view('prospects.prospectSpk', compact('prospect', 'units', 'colors', 'statusProspects', 'optional', 'stocks'));
        }else{
            return redirect()->route('prospects.spk');
        }
    }

    public function prospectDo($id) {
        $prospect = Prospect::with('prospectActivity')->findOrFail($id);
        $units = Unit::selectRaw('CONCAT (name, " - ", katashiki, " - ", suffix) as colums, id')->pluck('colums', 'id');
        $colors = Color::selectRaw('CONCAT (name, " - ", code) as colums, id')->pluck('colums', 'id');
        $statusProspects = StatusProspect::whereIn('id', array(5))->orderBy('status_order')->pluck('name', 'id');
        $stocks = Stock::join('prospect_activities', 'prospect_activities.stock_id', '=', 'stocks.id')
            ->selectRaw('CONCAT (chassis_code, " - ", engine_code) as colums, stocks.id')
            ->where('prospect_activities.id', $prospect->prospectActivity[0]->id)
            ->pluck('colums', 'stocks.id');
        $options = DB::table('marketing_has_employees')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.name AS svp', 'employees.id', 'employees.name')
            ->where('branch_id', '=', Helpers::getBranch()->id)
            ->get();
        $mg = DB::table('marketing_groups')
            ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.id', 'marketing_groups.name')
            ->get();
        $sal = DB::table('marketing_has_employees')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->select('marketing_groups.id AS svp', 'marketing_has_employees.id', 'employees.name')
            ->where('branch_id', '=', Helpers::getBranch()->id)
            ->get();
        foreach ($mg as $value) {
            foreach ($sal as $val) {
                if($val->svp == $value->id){
                    $optional[''. $value->name .''] = [$val->id => $val->name];
                }
            }
        }
        if($prospect->prospectActivity[0]->status_prospect_id === 4){
            return view('prospects.prospectDo', compact('prospect', 'units', 'colors', 'statusProspects', 'optional', 'stocks'));
        }else{
            return redirect()->route('prospects.do');
        }
    }

    public function salesperleasing(Request $request){
        $n = \Carbon\Carbon::now();

        $bid = Helpers::getBranch()->id;
        $branches = Branch::where('id', '>', 1)->pluck('name', 'id');
        $leasings = Leasing::select('id', 'name')->get();

        $sales = Prospect::selectRaw('leasings.id, leasings.name, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
            ->join('prospect_activities', function($pa){
                $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                    ->where('prospect_activities.status_prospect_id', 5);
            })
            ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
            ->join('leasings', 'leasings.id', '=', 'prospect_activities.leasing_id')
            //->where('branch_id', '=', 1)
            ->where('last_status_id', '=', 3)
            ->where(function ($query){
                $n = \Carbon\Carbon::now();
                $year = \Request::get('yearsearch');
                $id = \Request::get('branch_id');
                if(isset($year)){
                    $query->where(DB::raw('YEAR(do_date)'), '=', $year);
                }else{
                    $query->where(DB::raw('YEAR(do_date)'), '=', $n->year);
                }
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->groupBy('leasings.name', DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'leasings.id')
            ->get();

        return view('sales.salesperleasing', compact('leasings', 'sales', 'branches', 'bid'));
    }

    public function salesperleasingajax(Request $request){
        if($request->ajax()){
            $n = \Carbon\Carbon::now();

            $branches = Branch::where('id', '>', 1)->pluck('name', 'id');
            $leasings = Leasing::select('id', 'name')->get();

            $sales = Prospect::selectRaw('leasings.id, leasings.name, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
                ->join('prospect_activities', function($pa){
                    $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                        ->where('prospect_activities.status_prospect_id', 5);
                })
                ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
                ->join('leasings', 'leasings.id', '=', 'prospect_activities.leasing_id')
                //->where('branch_id', '=', 1)
                ->where('last_status_id', '=', 3)
                ->where(function ($query){
                    $n = \Carbon\Carbon::now();
                    $year = \Request::get('yearsearch');
                    $id = \Request::get('branch_id');
                    if(isset($year)){
                        $query->where(DB::raw('YEAR(do_date)'), '=', $year);
                    }else{
                        $query->where(DB::raw('YEAR(do_date)'), '=', $n->year);
                    }
                })
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->groupBy('leasings.name', DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'leasings.id')
                ->get();
            }
        $data = view('sales.salesperleasingajax', compact('leasings', 'sales', 'branches'))->render();
        return response()->json(['options'=>$data]);
    }

    public function salespercolor(Request $request){
        $n = \Carbon\Carbon::now();
        $bid = Helpers::getBranch()->id;
        $branches = Branch::where('id', '>', 1)->pluck('name', 'id');
        $colors = Color::select('id', 'name', 'code')->get();

        $sales = Prospect::selectRaw('colors.id, colors.name, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
            ->join('prospect_activities', function($pa){
                $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                    ->where('prospect_activities.status_prospect_id', 5);
            })
            ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
            ->join('colors', 'colors.id', '=', 'prospects.color_id')
            //->where('branch_id', '=', 1)
            ->where('last_status_id', '=', 3)
            ->where(function ($query){
                $n = \Carbon\Carbon::now();
                $year = \Request::get('yearsearch');
                $id = \Request::get('branch_id');
                if(isset($year)){
                    $query->where(DB::raw('YEAR(do_date)'), '=', $year);
                }else{
                    $query->where(DB::raw('YEAR(do_date)'), '=', $n->year);
                }
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->groupBy('colors.name', DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'colors.id')
            ->get();

        return view('sales.salespercolor', compact('colors', 'sales', 'branches', 'bid'));
    }

    public function salespercolorajax(Request $request){
        if($request->ajax()){
            $n = \Carbon\Carbon::now();

            $branches = Branch::where('id', '>', 1)->pluck('name', 'id');
            $colors = Color::select('id', 'name', 'code')->get();

            $sales = Prospect::selectRaw('colors.id, colors.name, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
                ->join('prospect_activities', function($pa){
                    $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                        ->where('prospect_activities.status_prospect_id', 5);
                })
                ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
                ->join('colors', 'colors.id', '=', 'prospects.color_id')
                //->where('branch_id', '=', 1)
                ->where('last_status_id', '=', 3)
                ->where(function ($query){
                    $n = \Carbon\Carbon::now();
                    $year = \Request::get('yearsearch');
                    $id = \Request::get('branch_id');
                    if(isset($year)){
                        $query->where(DB::raw('YEAR(do_date)'), '=', $year);
                    }else{
                        $query->where(DB::raw('YEAR(do_date)'), '=', $n->year);
                    }
                })
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->groupBy('colors.name', DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'colors.id')
                ->get();
            }
        $data = view('sales.salespercolorajax', compact('colors', 'sales', 'branches'))->render();
        return response()->json(['options'=>$data]);
    }

    public function salespermodel(Request $request){
        $n = \Carbon\Carbon::now();
        $bid = Helpers::getBranch()->id;
        $branches = Branch::where('id', '>', 1)->pluck('name', 'id');
        $unitModels = UnitModel::select('id', 'name')->get();

        $sales = Prospect::selectRaw('unit_models.id, unit_models.name, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
            ->join('prospect_activities', function($pa){
                $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                    ->where('prospect_activities.status_prospect_id', 5);
            })
            ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
            ->join('units', 'units.id', '=', 'prospects.unit_id')
            ->join('unit_models', 'unit_models.id', '=', 'units.unit_model_id')
            //->where('branch_id', '=', 1)
            ->where('last_status_id', '=', 3)
            ->where(function ($query){
                $n = \Carbon\Carbon::now();
                $year = \Request::get('yearsearch');
                $id = \Request::get('branch_id');
                if(isset($year)){
                    $query->where(DB::raw('YEAR(do_date)'), '=', $year);
                }else{
                    $query->where(DB::raw('YEAR(do_date)'), '=', $n->year);
                }
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->groupBy('unit_models.name', DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'unit_models.id')
            ->get();

        return view('sales.salespermodel', compact('unitModels', 'sales', 'branches', 'bid'));
    }

    public function salespermodelajax(Request $request){
        if($request->ajax()){
            $n = \Carbon\Carbon::now();

            $branches = Branch::where('id', '>', 1)->pluck('name', 'id');
            $unitModels = UnitModel::select('id', 'name')->get();

            $sales = Prospect::selectRaw('unit_models.id, unit_models.name, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
                ->join('prospect_activities', function($pa){
                    $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                        ->where('prospect_activities.status_prospect_id', 5);
                })
                ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
                ->join('units', 'units.id', '=', 'prospects.unit_id')
                ->join('unit_models', 'unit_models.id', '=', 'units.unit_model_id')
                //->where('branch_id', '=', 1)
                ->where('last_status_id', '=', 3)
                ->where(function ($query){
                    $n = \Carbon\Carbon::now();
                    $year = \Request::get('yearsearch');
                    $id = \Request::get('branch_id');
                    if(isset($year)){
                        $query->where(DB::raw('YEAR(do_date)'), '=', $year);
                    }else{
                        $query->where(DB::raw('YEAR(do_date)'), '=', $n->year);
                    }
                })
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->groupBy('unit_models.name', DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'unit_models.id')
                ->get();
            }
        $data = view('sales.salespermodelajax', compact('unitModels', 'sales', 'branches'))->render();
        return response()->json(['options'=>$data]);
    }

    public function salesperformance(Request $request){
        $n = \Carbon\Carbon::now();
        $bid = Helpers::getBranch()->id;
        $branches = Branch::where('id', '>', 1)->pluck('name', 'id');

        $subBranches = SubBranch::select('id', 'branch_id', 'name')
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->get();

        $teams = MarketingGroup::select('marketing_groups.id', 'marketing_groups.name', 'sub_branches.id AS sb_id')
            ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->where(function($q){
                if(Helpers::getBranch()->alias != 'HO'){
                    $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                }
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->get();
        $sellers = MarketingHasEmployee::selectRaw('marketing_has_employees.id, marketing_has_employees.marketing_group_id, employees.id AS employ_id, employees.name')
            ->leftjoin('employees', 'employees.id', 'marketing_has_employees.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->where(function($q){
                if(Helpers::getBranch()->alias != 'HO'){
                    $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                }
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->get();

        $sales = Prospect::selectRaw('marketing_has_employees.id, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
            ->join('prospect_activities', function($pa){
                $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                    ->where('prospect_activities.status_prospect_id', 5);
            })
            ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
            ->join('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
            ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
            ->where('last_status_id', '=', 3)
            ->where(function($q){
                if(Helpers::getBranch()->alias != 'HO'){
                    $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                }
            })
            ->where(function ($query){
                $n = \Carbon\Carbon::now();
                $year = \Request::get('yearsearch');
                $id = \Request::get('branch_id');
                if(isset($year)){
                    $query->where(DB::raw('YEAR(do_date)'), '=', $year);
                }else{
                    $query->where(DB::raw('YEAR(do_date)'), '=', $n->year);
                }
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->groupBy(DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'marketing_has_employees.id', 'marketing_groups.id')
            ->get();

        return view('sales.salesperformance', compact('subBranches', 'sales', 'branches', 'teams', 'sellers', 'bid'));
    }

    public function salesperformanceajax(Request $request){
        if($request->ajax()){
            $n = \Carbon\Carbon::now();

            $branches = Branch::where('id', '>', 1)->pluck('name', 'id');

            $subBranches = SubBranch::select('id', 'branch_id', 'name')
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->get();

            $teams = MarketingGroup::select('marketing_groups.id', 'marketing_groups.name', 'sub_branches.id AS sb_id')
                ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
                ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->where(function($q){
                    if(Helpers::getBranch()->alias != 'HO'){
                        $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                    }
                })
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->get();
            $sellers = MarketingHasEmployee::selectRaw('marketing_has_employees.id, marketing_has_employees.marketing_group_id, employees.id AS employ_id, employees.name')
                ->leftjoin('employees', 'employees.id', 'marketing_has_employees.employee_id')
                ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->where(function($q){
                    if(Helpers::getBranch()->alias != 'HO'){
                        $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                    }
                })
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->get();

            $sales = Prospect::selectRaw('marketing_has_employees.id, YEAR(do_date) AS y, MONTH(do_date) AS m, count(prospects.id) AS tot')
                ->join('prospect_activities', function($pa){
                    $pa->on('prospect_activities.prospect_id', '=', 'prospects.id')
                        ->where('prospect_activities.status_prospect_id', 5);
                })
                ->join('stocks', 'stocks.id', '=', 'prospect_activities.stock_id')
                ->join('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
                ->join('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->join('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
                ->where('last_status_id', '=', 3)
                ->where(function($q){
                    if(Helpers::getBranch()->alias != 'HO'){
                        $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                    }
                })
                ->where(function ($query){
                    $n = \Carbon\Carbon::now();
                    $year = \Request::get('yearsearch');
                    $id = \Request::get('branch_id');
                    if(isset($year)){
                        $query->where(DB::raw('YEAR(do_date)'), '=', $year);
                    }else{
                        $query->where(DB::raw('YEAR(do_date)'), '=', $n->year);
                    }
                })
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->groupBy(DB::raw('YEAR(do_date)'), DB::raw('MONTH(do_date)'), 'marketing_has_employees.id', 'marketing_groups.id')
                ->get();
            }
        $data = view('sales.salesperformanceajax', compact('subBranches', 'sales', 'branches', 'teams', 'sellers'))->render();
        return response()->json(['options'=>$data]);
    }

    public function salesactivity(Request $request){
        $n = \Carbon\Carbon::now();
        $bid = Helpers::getBranch()->id;
        $branches = Branch::where('id', '>', 1)->pluck('name', 'id');

        $subBranches = SubBranch::select('id', 'branch_id', 'name')
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->get();

        $teams = MarketingGroup::select('marketing_groups.id', 'marketing_groups.name', 'sub_branches.id AS sb_id')
            ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
            ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->where(function($q){
                if(Helpers::getBranch()->alias != 'HO'){
                    $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                }
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->get();

        $sellers = MarketingHasEmployee::selectRaw('marketing_has_employees.id, marketing_has_employees.marketing_group_id, employees.id AS employ_id, employees.name, targets.target, targets.formula')
            ->leftjoin('employees', 'employees.id', 'marketing_has_employees.employee_id')
            ->leftjoin('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->leftjoin('targets', function($q){
                $n = \Carbon\Carbon::now();
                $q->on('targets.marketing_has_employee_id', 'marketing_has_employees.id')
                    ->where('month', $n->month)
                    ->where('year', $n->year);
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->where(function($q){
                if(Helpers::getBranch()->alias != 'HO'){
                    $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                }
            })
            //->where('marketing_group_id', Helpers::getBranch()->marketingId)
            //->whereRaw('marketing_has_employees.end_work IS NULL')
            ->get();

        $activities = Prospect::selectRaw('marketing_has_employees.employee_id, prospect_activities.status_prospect_id, count(prospects.id) AS tot')
            ->leftjoin('prospect_activities', 'prospect_activities.prospect_id', '=', 'prospects.id')
            ->leftjoin('status_prospects', 'status_prospects.id', '=', 'prospect_activities.status_prospect_id')
            ->leftjoin('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
            ->leftjoin('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
            ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
            ->leftjoin('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
            ->where('status_prospects.id', '>', 2)
            ->where(function($q){
                if(Helpers::getBranch()->alias != 'HO'){
                    $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                }
            })
            ->where(function ($query){
                $id = \Request::get('branch_id');
                if(isset($id)){
                    $query->where('branch_id', '=', $id);
                }else{
                    if(Helpers::getBranch()->alias == 'HO'){
                        $query->where('branch_id', '=', 2);
                    }else{
                        $query->where('branch_id', '=', Helpers::getBranch()->id);
                    }
                }
            })
            ->whereMonth('prospect_date', $n->month)
            ->whereYear('prospect_date', $n->year)
            ->groupBy('prospects.id', 'prospect_activities.status_prospect_id', 'marketing_has_employees.employee_id')
            ->get();

        return view('sales.salesactivity', compact('bid', 'branches', 'subBranches', 'teams', 'sellers', 'activities'));
    }

    public function salesactivityajax(Request $request){
        if($request->ajax()){
            $n = \Carbon\Carbon::now();
            $bid = Helpers::getBranch()->id;
            $branches = Branch::where('id', '>', 1)->pluck('name', 'id');

            $subBranches = SubBranch::select('id', 'branch_id', 'name')
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->get();

            $teams = MarketingGroup::select('marketing_groups.id', 'marketing_groups.name', 'sub_branches.id AS sb_id')
                ->join('employees', 'employees.id', '=', 'marketing_groups.employee_id')
                ->join('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->where(function($q){
                    if(Helpers::getBranch()->alias != 'HO'){
                        $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                    }
                })
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->get();

                $sellers = MarketingHasEmployee::selectRaw('marketing_has_employees.id, marketing_has_employees.marketing_group_id, employees.id AS employ_id, employees.name, targets.target, targets.formula')
                    ->leftjoin('employees', 'employees.id', 'marketing_has_employees.employee_id')
                    ->leftjoin('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                    ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                    ->leftjoin('targets', function($q){
                        $n = \Carbon\Carbon::now();
                        $q->on('targets.marketing_has_employee_id', 'marketing_has_employees.id')
                            ->where('month', $n->month)
                            ->where(function ($query){
                                $n = \Carbon\Carbon::now();
                                $year = \Request::get('yearsearch');
                                $id = \Request::get('branch_id');
                                if(isset($year)){
                                    $query->where('year', '=', $year);
                                }else{
                                    $query->where('year', '=', $n->year);
                                }
                            });
                    })
                    ->where(function($q){
                        if(Helpers::getBranch()->alias != 'HO'){
                            $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                        }
                    })
                    ->where(function ($query){
                        $id = \Request::get('branch_id');
                        if(isset($id)){
                            $query->where('branch_id', '=', $id);
                        }else{
                            if(Helpers::getBranch()->alias == 'HO'){
                                $query->where('branch_id', '=', 2);
                            }else{
                                $query->where('branch_id', '=', Helpers::getBranch()->id);
                            }
                        }
                    })
                    //->where('marketing_group_id', Helpers::getBranch()->marketingId)
                    //->whereRaw('marketing_has_employees.end_work IS NULL')
                    ->get();

            $activities = Prospect::selectRaw('marketing_has_employees.employee_id, prospect_activities.status_prospect_id, count(prospects.id) AS tot')
                ->leftjoin('prospect_activities', 'prospect_activities.prospect_id', '=', 'prospects.id')
                ->leftjoin('status_prospects', 'status_prospects.id', '=', 'prospect_activities.status_prospect_id')
                ->leftjoin('marketing_has_employees', 'marketing_has_employees.id', '=', 'prospects.marketing_has_employee_id')
                ->leftjoin('employees', 'employees.id', '=', 'marketing_has_employees.employee_id')
                ->leftjoin('marketing_groups', 'marketing_groups.id', '=', 'marketing_has_employees.marketing_group_id')
                ->leftjoin('sub_branches', 'sub_branches.id', '=', 'employees.sub_branch_id')
                ->where('status_prospects.id', '>', 2)
                ->where(function($q){
                    if(Helpers::getBranch()->alias != 'HO'){
                        $q->where('marketing_groups.id', Helpers::getBranch()->marketingId);
                    }
                })
                ->where(function ($query){
                    $id = \Request::get('branch_id');
                    if(isset($id)){
                        $query->where('branch_id', '=', $id);
                    }else{
                        if(Helpers::getBranch()->alias == 'HO'){
                            $query->where('branch_id', '=', 2);
                        }else{
                            $query->where('branch_id', '=', Helpers::getBranch()->id);
                        }
                    }
                })
                ->where(function ($query){
                    $n = \Carbon\Carbon::now();
                    $year = \Request::get('yearsearch');
                    $id = \Request::get('branch_id');
                    if(isset($year)){
                        $query->where(DB::raw('YEAR(prospect_date)'), '=', $year);
                    }else{
                        $query->where(DB::raw('YEAR(prospect_date)'), '=', $n->year);
                    }
                })
                //->whereMonth('prospect_date', $n->month)
                ->whereYear('prospect_date', $n->year)
                ->groupBy('prospects.id', 'prospect_activities.status_prospect_id', 'marketing_has_employees.employee_id')
                ->get();
        }
        $data = view('sales.salesactivityajax', compact('bid', 'branches', 'subBranches', 'teams', 'sellers', 'activities'))->render();
        return response()->json(['options'=>$data]);
    }

    public function destroy($id) {
        $prospect = Prospect::findOrFail($id);
        $prospect->delete();
        Session::flash('alert-info', 'Prospect was successful deleted!');
        return redirect()->route('prospects.index');
    }
}
