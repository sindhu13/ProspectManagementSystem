<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Departement;

class DepartementController extends Controller
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
        $departements = DB::table('departements')
            ->orderBy('name')
            ->get();
        return view('departements.index', ['departements' => $departements]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departements,name',
        ]);

        $message = new Departement;
        $message->name = $request->input('name');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Departement was successful added!');
        return redirect()->route('departements.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('departements.create');
    }

    public function show($id) {
        $departement = Departement::findOrFail($id); //Find post of id = $id
        return view ('departements.show', compact('departement'));
    }

    public function edit($id) {
        $departement = Departement::findOrFail($id);
        return view('departements.edit', compact('departement'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:departements,name,'. $id,
        ]);

        $message = Departement::findOrFail($id);
        $message->name = $request->input('name');
        $message->save();
        $request->session()->flash('alert-success', 'Departement was successful updated!');
        return redirect()->route('departements.index');
    }

    public function destroy($id) {
        $departement = Departement::findOrFail($id);
        $departement->delete();
        Session::flash('alert-info', 'Departement was successful deleted!');
        return redirect()->route('departements.index');
    }
}
