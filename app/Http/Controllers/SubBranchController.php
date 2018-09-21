<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Branch;
use App\SubBranch;

class SubBranchController extends Controller
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
        $subBranches = subBranch::with('branch')
            ->orderBy('branch_id', 'name')
            ->get();
        return view('subBranches.index', ['subBranches' => $subBranches]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'branch_id' => 'required',
            'name' => 'required|unique:sub_branches,name',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $message = new SubBranch;
        $message->branch_id = $request->input('branch_id');
        $message->name = $request->input('name');
        $message->address = $request->input('address');
        $message->phone = $request->input('phone');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Sub Branch was successful added!');
        return redirect()->route('subBranches.index');

        //return redirect('/branchs');
    }

    public function create(){
        $branches = Branch::pluck('name', 'id');
        return view('subBranches.create', compact('branches'));
    }

    public function show($id) {
        $subBanch = SubBranch::findOrFail($id); //Find post of id = $id
        return view ('subBranches.show', compact('subBranch'));
    }

    public function edit($id) {
        $subBranch = SubBranch::findOrFail($id);
        $branches = Branch::pluck('name', 'id');
        return view('subBranches.edit', compact('subBranch', 'branches'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'branch_id' => 'required',
            'name' => 'required|unique:sub_branches,name,'. $id,
            'address' => 'required',
            'phone' => 'required',
        ]);

        $message = SubBranch::findOrFail($id);
        $message->branch_id = $request->input('branch_id');
        $message->name = $request->input('name');
        $message->address = $request->input('address');
        $message->phone = $request->input('phone');
        $message->save();
        $request->session()->flash('alert-success', 'Sub Branch was successful updated!');
        return redirect()->route('subBranches.index');
    }

    public function destroy($id) {
        $subBranch = SubBranch::findOrFail($id);
        $subBranch->delete();
        Session::flash('alert-info', 'Sub Branch was successful deleted!');
        return redirect()->route('subBranches.index');
    }
}
