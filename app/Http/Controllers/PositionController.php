<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Position;

class PositionController extends Controller
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
        $positions = DB::table('positions')
            ->orderBy('name')
            ->get();
        return view('positions.index', ['positions' => $positions]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:positions,name'
        ]);

        $message = new Position;
        $message->name = $request->input('name');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Position was successful added!');
        return redirect()->route('positions.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('positions.create');
    }

    public function show($id) {
        $position = Position::findOrFail($id); //Find post of id = $id
        return view ('positions.show', compact('position'));
    }

    public function edit($id) {
        $position = Position::findOrFail($id);
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:positions,name,'. $id,
        ]);

        $message = Position::findOrFail($id);
        $message->name = $request->input('name');
        $message->save();
        $request->session()->flash('alert-success', 'Position was successful updated!');
        return redirect()->route('positions.index');
    }

    public function destroy($id) {
        $position = Position::findOrFail($id);
        $position->delete();
        Session::flash('alert-info', 'Position was successful deleted!');
        return redirect()->route('positions.index');
    }
}
