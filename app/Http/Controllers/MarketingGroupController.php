<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\MarketingGroup;
use App\subBranch;
use App\Employee;
use App\MarketingHasEmployee;

class MarketingGroupController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $marketingGroups = MarketingGroup::with('employee')
            ->orderBy('employee_id', 'name')
            ->get();
        return view('marketingGroups.index', ['marketingGroups' => $marketingGroups]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:marketing_groups,name',
            'employee_id' => 'required',
        ]);

        $message = new MarketingGroup;
        $message->name = $request->input('name');
        $message->employee_id = $request->input('employee_id');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Marketing Group was successful added!');
        return redirect()->route('marketingGroups.index');

        //return redirect('/branchs');
    }

    public function create(){
        $employees = Employee::where('departement_id', 2)->pluck('name', 'id');
        $subBranch = subBranch::pluck('name', 'id');
        return view('marketingGroups.create', compact('employees', 'subBranch'));
    }

    public function show($id) {
        $marketingGroup = MarketingGroup::with('employee')->findOrFail($id); //Find post of id = $id
        $marketingHasEmployees = MarketingHasEmployee::with('employee')->where('marketing_group_id', $id)->get();
        return view ('marketingGroups.show', compact('marketingGroup', 'marketingHasEmployees'));
    }

    public function edit($id) {
        $marketingGroup = MarketingGroup::findOrFail($id);
        $employees = Employee::where('departement_id', 2)->pluck('name', 'id');
        $subBranch = subBranch::pluck('name', 'id');
        return view('marketingGroups.edit', compact('marketingGroup', 'employees', 'subBranch'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:marketing_groups,name,'. $id,
            'employee_id' => 'required',
        ]);

        $message = MarketingGroup::findOrFail($id);
        $message->name = $request->input('name');
        $message->employee_id = $request->input('employee_id');
        $message->save();
        $request->session()->flash('alert-success', 'Marketing Group was successful updated!');
        return redirect()->route('marketingGroups.index');
    }

    public function destroy($id) {
        $marketingGroup = MarketingGroup::findOrFail($id);
        $marketingGroup->delete();
        Session::flash('alert-info', 'Marketing Group was successful deleted!');
        return redirect()->route('marketingGroups.index');
    }
}
