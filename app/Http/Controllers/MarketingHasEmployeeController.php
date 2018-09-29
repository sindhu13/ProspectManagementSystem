<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\MarketingHasEmployee;
use App\MarketingGroup;
use App\Employee;
use App\Target;

class MarketingHasEmployeeController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware(['auth', 'role:Super User|HRD']);
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $marketingHasEmployees = DB::table('marketing_has_employees')
            ->orderBy('name')
            ->get();
        return view('marketingHasEmployees.index', ['marketingHasEmployees' => $marketingHasEmployees]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'marketing_group_id' => 'required',
            'employee_id' => 'required|unique:marketing_has_employees,employee_id',
            'begin_work' => 'required',
        ]);

        $message = new MarketingHasEmployee;
        $message->marketing_group_id = $request->input('marketing_group_id');
        $message->employee_id = $request->input('employee_id');
        $message->begin_work = $request->input('begin_work');
        $message->save();

        $target = new Target;
        $target->target = $request->input('target');
        $target->month = $request->input('month');
        $target->year = $request->input('year');
        $message->target()->save($target);


        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Sales Force was successful added!');
        return redirect()->route('marketingGroups.show', $request->input('marketing_group_id'));

        //return redirect('/branchs');
    }

    public function create($id){
        $svp = MarketingGroup::findOrFail($id);
        $sbid = Employee::findOrFail($svp->employee_id);
        $employees = Employee::where('departement_id', 3)->where('sub_branch_id', $sbid->sub_branch_id)->orderBy('name')->pluck('name', 'id');
        return view('marketingHasEmployees.create', compact('employees', 'id'));
    }

    public function show($id) {
        $marketingHasEmployee = MarketingHasEmployee::findOrFail($id); //Find post of id = $id
        return view ('marketingHasEmployees.show', compact('marketingHasEmployee'));
    }

    public function edit($id) {
        $marketingHasEmployee = MarketingHasEmployee::findOrFail($id);
        $svp = MarketingGroup::findOrFail($marketingHasEmployee->marketing_group_id);
        $mgid = $marketingHasEmployee->marketing_group_id;
        $sbid = Employee::findOrFail($svp->employee_id);
        $employees = Employee::where('departement_id', 3)->where('sub_branch_id', $sbid->sub_branch_id)->orderBy('name')->pluck('name', 'id');
        return view('marketingHasEmployees.edit', compact('marketingHasEmployee', 'employees', 'mgid'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'employee_id' => 'required',
            'begin_work' => 'required',
        ]);

        $message = MarketingHasEmployee::findOrFail($id);
        $message->employee_id = $request->input('employee_id');
        $message->begin_work = $request->input('begin_work');
        $message->end_work = $request->input('end_work');
        $message->save();

        $target = Target::findOrFail($request->input('target_id'));
        $target->target = $request->input('target');
        $target->month = $request->input('month');
        $target->year = $request->input('year');
        $target->save();

        $request->session()->flash('alert-success', 'Sales Force was successful updated!');
        return redirect()->route('marketingGroups.show', $request->input('marketing_group_id'));
    }

    public function destroy($id) {
        $marketingHasEmployee = MarketingHasEmployee::findOrFail($id);
        $marketingHasEmployee->delete();
        Session::flash('alert-info', 'MarketingHasEmployee was successful deleted!');
        return redirect()->route('marketingHasEmployees.index');
    }

    public function formula(){
        $marketingHasEmployee = MarketingHasEmployee::wherehas('target', function($q){
            $n = \Carbon\Carbon::now();
            $q->where('year', $n->year)
                ->where('month', $n->month);
            })
            ->limit(1)
            ->get();
        return view('marketingHasEmployees.formula', compact('marketingHasEmployee'));
    }

    public function setformula(Request $request){
        $this->validate($request, [
            'formula' => 'required',
        ]);
        $n = \Carbon\Carbon::now();
        $message = Target::where('year', $n->year)
            ->where('month', $n->month)
            ->update(['formula' => $request->input('formula')]);

        $request->session()->flash('alert-success', 'Formula was successful Set!');
        return redirect()->route('marketingGroups.index');
    }
}
