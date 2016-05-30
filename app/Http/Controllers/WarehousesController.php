<?php

namespace App\Http\Controllers;

use App\Warehouses;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class WarehousesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = Input::get('search','');

        if ( !empty( $keyword ) ) {
            $Warehouses = Warehouses::orWhere('warehouse_name', 'like', $keyword.'%')
                ->orWhere('warehouse_code', 'like', $keyword.'%')
                ->orderBy('warehouse_name');
        } else {
            $Warehouses = Warehouses::orderBy('warehouse_name');
        }

        $Warehouses = $Warehouses->paginate();

        return view('warehouses.warehouses_search', compact(['Warehouses']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Warehouse = new Warehouses();
        return view('warehouses.warehouses_edit', compact(['Warehouse']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ( $request->input('action') == 'Delete' ) {
            Warehouses::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/warehouses")->with(compact('status'));
        }

        $arr_validation = [];
        if ( !$request->has('id') ) {
            $arr_validation['warehouse_name'] = "required|unique:warehouses";
        } else {
            $arr_validation['warehouse_name'] = "required|unique:warehouses,warehouse_name,".$request->input('id');
        }

        $this->validate($request,$arr_validation);

        if ( !$request->has('id') ) {
            $Warehouse = Warehouses::create($request->all());
            $status = "Transaction Saved";
        } else {
            $Warehouse = Warehouses::find($request->input('id'));
            $Warehouse->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/warehouses/$Warehouse->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Warehouse = Warehouses::findOrNew($id);
        return view('warehouses.warehouses_edit', compact(['Warehouse']));
    }
}
