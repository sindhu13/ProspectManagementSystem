<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Helpers;
use App\Stock;
use App\Unit;
use App\Color;
use App\Position;
use App\StatusStock;
use App\Branch;

class StockController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Super User|Admin')->only('create', 'edit', 'destroy');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $brch = Helpers::getBranch();

        $stocks = Stock::with('unit', 'position', 'branch')
            ->where('last_status_id', '<', 3)
            ->where(function($query){
                if(Helpers::getBranch()->alias != 'HO'){
                    $query->where('branch_id', Helpers::getBranch()->id);
                }
            })
            ->orderBy('id')
            ->get();

        return view('stocks.index', compact('stocks'));
        //  return view('Branch');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'branch_id' => 'required',
            'unit_id' => 'required',
            'color_id' => 'required',
            'chassis_code' => 'required',
            'engine_code' => 'required',
            'year' => 'required',
            'position_id' => 'required',
        ]);

        $message = new Stock;
        $message->branch_id = $request->input('branch_id');
        $message->unit_id = $request->input('unit_id');
        $message->color_id = $request->input('color_id');
        $message->chassis_code = $request->input('chassis_code');
        $message->engine_code = $request->input('engine_code');
        $message->year = $request->input('year');
        $message->position_id = $request->input('position_id');
        $message->status_id = $request->input('status_id');
        $message->last_status_id = $request->input('status_id');
        $message->save();

        //Display a successful message upon save
        $request->session()->flash('alert-success', 'Stock was successful added!');
        return redirect()->route('stocks.index');

        //return redirect('/branchs');
    }

    public function create(){
        $units = Unit::selectRaw('CONCAT (name, " - ", katashiki, " - ", suffix) as colums, id')->pluck('colums', 'id');
        $colors = Color::selectRaw('CONCAT (name, " - ", code) as colums, id')->pluck('colums', 'id');
        $positions = Position::pluck('name', 'id');
        $statusStocks = StatusStock::pluck('name', 'id');
        $branchs = Branch::where('id', '>', 1)->orderBy('id')->pluck('name', 'id');
        $brn = Helpers::getBranch()->id;
        return view('stocks.create', compact('units', 'colors', 'positions', 'statusStocks', 'branchs', 'brn'));
    }

    public function show($id) {
        $stock = Stock::findOrFail($id); //Find post of id = $id
        return view ('stocks.show', compact('stock'));
    }

    public function edit($id) {
        $stock = Stock::findOrFail($id);
        $units = Unit::selectRaw('CONCAT (name, " - ", katashiki, " - ", suffix) as colums, id')->pluck('colums', 'id');
        $colors = Color::selectRaw('CONCAT (name, " - ", code) as colums, id')->pluck('colums', 'id');
        $positions = Position::pluck('name', 'id');
        $statusStocks = StatusStock::pluck('name', 'id');
        $branchs = Branch::where('id', '>', 1)->orderBy('id')->pluck('name', 'id');
        $brn = Helpers::getBranch()->id;
        return view('stocks.edit', compact('stock', 'units', 'colors', 'positions', 'statusStocks', 'branchs', 'brn'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'branch_id' => 'required',
            'unit_id' => 'required',
            'color_id' => 'required',
            'chassis_code' => 'required',
            'engine_code' => 'required',
            'year' => 'required',
            'position_id' => 'required',
        ]);

        $message = Stock::findOrFail($id);
        $message->branch_id = $request->input('branch_id');
        $message->unit_id = $request->input('unit_id');
        $message->color_id = $request->input('color_id');
        $message->chassis_code = $request->input('chassis_code');
        $message->engine_code = $request->input('engine_code');
        $message->year = $request->input('year');
        $message->position_id = $request->input('position_id');
        $message->last_status_id = $request->input('last_status_id');
        $message->save();
        $request->session()->flash('alert-success', 'Stock was successful updated!');
        return redirect()->route('stocks.index');
    }

    public function getChassis(Request $request) {
    	if($request->ajax()){
    		// $states = DB::table('states')->where('id_country',$request->id_country)->pluck("name","id")->all();
    		// $data = view('ajax-select',compact('states'))->render();
    		// return response()->json(['options'=>$data]);

            $stocks = Stock::selectRaw('CONCAT (chassis_code, " - ", engine_code) as colums, id')
                ->where('unit_id', '=', $request->unitid)
                ->where('color_id', '=', $request->colorid)
                ->where('branch_id', '=', 1)
                ->where('last_status_id', '=', 1)
                ->pluck('colums', 'id');

            $data = view('stocks.getChassis',compact('stocks'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

    public function destroy($id) {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        Session::flash('alert-info', 'Stock was successful deleted!');
        return redirect()->route('stocks.index');
    }
}
