<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\UnitModel;
use App\Unit;

class UnitController extends Controller
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
        $units = Unit::with('unitModel')
            ->orderBy('unit_model_id', 'name')
            ->get();
        return view('units.index', ['units' => $units]);
        //  return view('UnitModel');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'unit_model_id' => 'required',
            'name' => 'required',
            'katashiki' => 'required',
            'suffix' => 'required',
        ]);

        $message = new Unit;
        $message->unit_model_id = $request->input('unit_model_id');
        $message->name = $request->input('name');
        $message->katashiki = $request->input('katashiki');
        $message->suffix = $request->input('suffix');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Unit was successful added!');
        return redirect()->route('units.index');

        //return redirect('/branchs');
    }

    public function create(){
        $unitModels = UnitModel::pluck('name', 'id');
        return view('units.create', compact('unitModels'));
    }

    public function show($id) {
        $unit = Unit::findOrFail($id); //Find post of id = $id
        return view ('units.show', compact('unit'));
    }

    public function edit($id) {
        $unit = Unit::findOrFail($id);
        $unitModels = UnitModel::pluck('name', 'id');
        return view('units.edit', compact('unit', 'unitModels'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'unit_model_id' => 'required',
            'name' => 'required',
            'katashiki' => 'required',
            'suffix' => 'required',
        ]);

        $message = Unit::findOrFail($id);
        $message->unit_model_id = $request->input('unit_model_id');
        $message->name = $request->input('name');
        $message->katashiki = $request->input('katashiki');
        $message->suffix = $request->input('suffix');
        $message->save();
        $request->session()->flash('alert-success', 'Unit was successful updated!');
        return redirect()->route('units.index');
    }

    public function destroy($id) {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        Session::flash('alert-info', 'Unit was successful deleted!');
        return redirect()->route('units.index');
    }
}
