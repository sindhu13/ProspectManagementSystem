<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\StatusProspect;

class StatusProspectController extends Controller
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
        $statusProspects = DB::table('status_prospects')
            ->orderBy('status_order')
            ->get();
        return view('statusProspects.index', ['statusProspects' => $statusProspects]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status_order' => 'required',
            'status_order' => 'required|unique:status_prospects',
        ]);

        $message = new StatusProspect;
        $message->name = $request->input('name');
        $message->status_order = $request->input('status_order');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Prospect Status was successful added!');
        return redirect()->route('statusProspects.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('statusProspects.create');
    }

    public function show($id) {
        $statusProspect = StatusProspect::findOrFail($id); //Find post of id = $id
        return view ('statusProspects.show', compact('statusProspect'));
    }

    public function edit($id) {
        $statusProspect = StatusProspect::findOrFail($id);
        return view('statusProspects.edit', compact('statusProspect'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'status_order' => 'required|unique:status_prospects,status_order,'.$id,
        ]);

        $message = StatusProspect::findOrFail($id);
        $message->name = $request->input('name');
        $message->status_order = $request->input('status_order');
        $message->save();
        $request->session()->flash('alert-success', 'Prospect Status was successful updated!');
        return redirect()->route('statusProspects.index');
    }

    public function destroy($id) {
        $statusProspect = StatusProspect::findOrFail($id);
        $statusProspect->delete();
        Session::flash('alert-info', 'Prospect Status was successful deleted!');
        return redirect()->route('statusProspects.index');
    }
}
