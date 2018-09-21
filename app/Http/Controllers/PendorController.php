<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Pendor;

class PendorController extends Controller
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
        $pendors = DB::table('vendors')
            ->orderBy('name')
            ->get();
        return view('pendors.index', ['pendors' => $pendors]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:vendors,name'
        ]);

        $message = new Pendor;
        $message->name = $request->input('name');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Vendor was successful added!');
        return redirect()->route('pendors.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('pendors.create');
    }

    public function show($id) {
        $pendor = Pendor::findOrFail($id); //Find post of id = $id
        return view ('pendors.show', compact('pendor'));
    }

    public function edit($id) {
        $pendor = Pendor::findOrFail($id);
        return view('pendors.edit', compact('pendor'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:vendors,name,'. $id
        ]);

        $message = Pendor::findOrFail($id);
        $message->name = $request->input('name');
        $message->save();
        $request->session()->flash('alert-success', 'Vendor was successful updated!');
        return redirect()->route('pendors.index');
    }

    public function destroy($id) {
        $pendor = Pendor::findOrFail($id);
        $pendor->delete();
        Session::flash('alert-info', 'Vendor was successful deleted!');
        return redirect()->route('pendors.index');
    }
}
