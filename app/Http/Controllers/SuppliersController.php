<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SuppliersController extends Controller
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
            $Suppliers = Suppliers::orWhere('supplier_name', 'like', $keyword.'%')
                ->orWhere('supplier_code', 'like', $keyword.'%')
                ->orderBy('supplier_name');
        } else {
            $Suppliers = Suppliers::orderBy('supplier_name');
        }

        $Suppliers = $Suppliers->paginate();

        return view('suppliers.suppliers_search', compact(['Suppliers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Supplier = new Suppliers();
        return view('suppliers.suppliers_edit', compact(['Supplier']));
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
            Suppliers::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/suppliers")->with(compact('status'));
        }

        $arr_validation = [];
        if ( !$request->has('id') ) {
            $arr_validation['supplier_name'] = "required|unique:suppliers";
        } else {
            $arr_validation['supplier_name'] = "required|unique:suppliers,supplier_name,".$request->input('id');
        }

        $this->validate($request,$arr_validation);

        if ( !$request->has('id') ) {
            $Supplier = Suppliers::create($request->all());
            $status = "Transaction Saved";
        } else {
            $Supplier = Suppliers::find($request->input('id'));
            $Supplier->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/suppliers/$Supplier->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Supplier = Suppliers::findOrNew($id);
        return view('suppliers.suppliers_edit', compact(['Supplier']));
    }
}
