<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Branch;

class BranchController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
     $this->middleware(['auth', 'role:Super User']);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $branches = DB::table('branches')->get();

    return view('branches.index', ['branches' => $branches]);
    //  return view('Branch');
  }

  public function store(Request $request)
  {
      $this->validate($request, [
        'name' => 'required|unique:branches,name',
        'alias' => 'required|unique:branches,alias',
      ]);

      $message = new Branch;
      $message->name = $request->input('name');
      $message->alias = $request->input('alias');
      $message->save();

      //Display a successful message upon save
      $request->session()->flash('alert-success', 'Branch was successful added!');
      return redirect()->route('branches.index');

      //return redirect('/branchs');
  }

  public function create(){
    return view('branches.create');
  }

  public function show($id) {
    $Branch = Branch::findOrFail($id); //Find post of id = $id
    return view ('branches.show', compact('Branch'));
  }

  public function edit($id) {
    $branch = Branch::findOrFail($id);
    return view('branches.edit', compact('branch'));
  }

  public function update(Request $request, $id) {
    $this->validate($request, [
        'name' => 'required|unique:branches,name,'. $id,
        'alias' => 'required|unique:branches,alias,'. $id,
    ]);

    $message = Branch::findOrFail($id);
    $message->name = $request->input('name');
    $message->alias = $request->input('alias');
    $message->save();
    $request->session()->flash('alert-success', 'Branch was successful updated!');
    return redirect()->route('branches.index');
  }

  public function destroy($id) {
    $branch = Branch::findOrFail($id);
    $branch->delete();
    Session::flash('alert-info', 'Branch was successful deleted!');
    return redirect()->route('branches.index');
  }
}
