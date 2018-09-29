<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Employee;
use App\Departement;
use App\SubBranch;

class EmployeeController extends Controller
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
        $employees = Employee::with('departement')
            ->orderBy('departement_id', 'name')
            ->get();
        return view('employees.index', ['employees' => $employees]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'departement_id' => 'required',
            'sub_branch_id' => 'required',
            'begin_work' => 'required'
        ]);

        $message = new Employee;
        $message->name = $request->input('name');
        $message->phone = $request->input('phone');
        $message->address = $request->input('address');
        $message->departement_id = $request->input('departement_id');
        $message->sub_branch_id = $request->input('sub_branch_id');
        $message->begin_work = $request->input('begin_work');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Employee was successful added!');
        return redirect()->route('employees.index');

        //return redirect('/branchs');
    }

    public function create(){
        $departements = Departement::pluck('name', 'id');
        $subBranchs = SubBranch::pluck('name', 'id');
        return view('employees.create', compact('departements', 'subBranchs'));
    }

    public function show($id) {
        $employee = Employee::findOrFail($id); //Find post of id = $id
        return view ('employees.show', compact('employee'));
    }

    public function edit($id) {
        $employee = Employee::findOrFail($id);
        $departements = Departement::pluck('name', 'id');
        $subBranchs = SubBranch::pluck('name', 'id');
        return view('employees.edit', compact('employee', 'departements', 'subBranchs'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'departement_id' => 'required',
            'sub_branch_id' => 'required',
            'begin_work' => 'required'
        ]);

        $message = Employee::findOrFail($id);
        $message->name = $request->input('name');
        $message->phone = $request->input('phone');
        $message->address = $request->input('address');
        $message->departement_id = $request->input('departement_id');
        $message->sub_branch_id = $request->input('sub_branch_id');
        $message->begin_work = $request->input('begin_work');
        if(($request->input('end_work')) !== null){
            $message->end_work = $request->input('end_work');
        }
        $message->save();
        $request->session()->flash('alert-success', 'Employee was successful updated!');
        return redirect()->route('employees.index');
    }

    public function destroy($id) {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        Session::flash('alert-info', 'Employee was successful deleted!');
        return redirect()->route('employees.index');
    }
}
