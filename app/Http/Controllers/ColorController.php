<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Color;

class ColorController extends Controller
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
        $colors = DB::table('colors')
            ->orderBy('name')
            ->get();
        return view('colors.index', ['colors' => $colors]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required'
        ]);

        $message = new Color;
        $message->name = $request->input('name');
        $message->code = $request->input('code');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Color was successful added!');
        return redirect()->route('colors.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('colors.create');
    }

    public function show($id) {
        $color = Color::findOrFail($id); //Find post of id = $id
        return view ('colors.show', compact('color'));
    }

    public function edit($id) {
        $color = Color::findOrFail($id);
        return view('colors.edit', compact('color'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required'
        ]);

        $message = Color::findOrFail($id);
        $message->name = $request->input('name');
        $message->code = $request->input('code');
        $message->save();
        $request->session()->flash('alert-success', 'Color was successful updated!');
        return redirect()->route('colors.index');
    }

    public function destroy($id) {
        $color = Color::findOrFail($id);
        $color->delete();
        Session::flash('alert-info', 'Color was successful deleted!');
        return redirect()->route('colors.index');
    }
}
