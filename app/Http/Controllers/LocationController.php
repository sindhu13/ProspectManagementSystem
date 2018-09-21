<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Location;

class LocationController extends Controller
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
        $locations = DB::table('locations')
            ->orderBy('name')
            ->get();
        return view('locations.index', ['locations' => $locations]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:locations,name'
        ]);

        $message = new Location;
        $message->name = $request->input('name');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Location was successful added!');
        return redirect()->route('locations.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('locations.create');
    }

    public function show($id) {
        $location = Location::findOrFail($id); //Find post of id = $id
        return view ('locations.show', compact('location'));
    }

    public function edit($id) {
        $location = Location::findOrFail($id);
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:locations,name,'. $id,
        ]);

        $message = Location::findOrFail($id);
        $message->name = $request->input('name');
        $message->save();
        $request->session()->flash('alert-success', 'Location was successful updated!');
        return redirect()->route('locations.index');
    }

    public function destroy($id) {
        $location = Location::findOrFail($id);
        $location->delete();
        Session::flash('alert-info', 'Location was successful deleted!');
        return redirect()->route('locations.index');
    }
}
