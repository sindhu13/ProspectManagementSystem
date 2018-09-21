<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Leasing;

class LeasingController extends Controller
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
        $leasings = DB::table('leasings')
            ->orderBy('name')
            ->get();
        return view('leasings.index', ['leasings' => $leasings]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:leasings,name',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $message = new Leasing;
        $message->name = $request->input('name');
        $message->address = $request->input('address');
        $message->phone = $request->input('phone');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Leasing was successful added!');
        return redirect()->route('leasings.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('leasings.create');
    }

    public function show($id) {
        $leasing = Leasing::findOrFail($id); //Find post of id = $id
        return view ('leasings.show', compact('leasing'));
    }

    public function edit($id) {
        $leasing = Leasing::findOrFail($id);
        return view('leasings.edit', compact('leasing'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:leasings,name,'. $id,
            'address' => 'required',
            'phone' => 'required',
        ]);

        $message = Leasing::findOrFail($id);
        $message->name = $request->input('name');
        $message->address = $request->input('address');
        $message->phone = $request->input('phone');
        $message->save();
        $request->session()->flash('alert-success', 'Leasing was successful updated!');
        return redirect()->route('leasings.index');
    }

    public function destroy($id) {
        $leasing = Leasing::findOrFail($id);
        $leasing->delete();
        Session::flash('alert-info', 'Leasing was successful deleted!');
        return redirect()->route('leasings.index');
    }
}
