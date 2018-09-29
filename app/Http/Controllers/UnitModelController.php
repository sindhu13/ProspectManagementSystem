<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\UnitModel;

class UnitModelController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin|Super User']);
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $unitModels = DB::table('unit_models')
            ->orderBy('name')
            ->get();
        return view('unitModels.index', ['unitModels' => $unitModels]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:unit_models,name'
        ]);

        $message = new UnitModel;
        $message->name = $request->input('name');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Unit Model was successful added!');
        return redirect()->route('unitModels.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('unitModels.create');
    }

    public function show($id) {
        $unitModel = UnitModel::findOrFail($id); //Find post of id = $id
        return view ('unitModels.show', compact('unitModel'));
    }

    public function edit($id) {
        $unitModel = UnitModel::findOrFail($id);
        return view('unitModels.edit', compact('unitModel'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:unit_models,name,'. $id,
        ]);

        $message = UnitModel::findOrFail($id);
        $message->name = $request->input('name');
        $message->save();
        $request->session()->flash('alert-success', 'Unit Model was successful updated!');
        return redirect()->route('unitModels.index');
    }

    public function destroy($id) {
        $unitModel = UnitModel::findOrFail($id);
        $unitModel->delete();
        Session::flash('alert-info', 'Unit Model was successful deleted!');
        return redirect()->route('unitModels.index');
    }
}
