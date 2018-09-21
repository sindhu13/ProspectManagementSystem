<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\StatusStock;

class StatusStockController extends Controller
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
        $statusStocks = DB::table('status_stocks')
            ->orderBy('name')
            ->get();
        return view('statusStocks.index', ['statusStocks' => $statusStocks]);
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:status_stocks,name'
        ]);

        $message = new StatusStock;
        $message->name = $request->input('name');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Stock Status was successful added!');
        return redirect()->route('statusStocks.index');

        //return redirect('/branchs');
    }

    public function create(){
        return view('statusStocks.create');
    }

    public function show($id) {
        $statusStock = StatusStock::findOrFail($id); //Find post of id = $id
        return view ('statusStocks.show', compact('statusStock'));
    }

    public function edit($id) {
        $statusStock = StatusStock::findOrFail($id);
        return view('statusStocks.edit', compact('statusStock'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:status_stocks,name,'. $id,
        ]);

        $message = StatusStock::findOrFail($id);
        $message->name = $request->input('name');
        $message->save();
        $request->session()->flash('alert-success', 'Stock Status was successful updated!');
        return redirect()->route('statusStocks.index');
    }

    public function destroy($id) {
        $statusStock = StatusStock::findOrFail($id);
        $statusStock->delete();
        Session::flash('alert-info', 'Stock Status was successful deleted!');
        return redirect()->route('statusStocks.index');
    }
}
