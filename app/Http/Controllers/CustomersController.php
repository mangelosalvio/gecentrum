<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CustomersController extends Controller
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
            $Customers = Customers::orWhere('customer_name', 'like', $keyword.'%')
                ->orWhere('customer_code', 'like', $keyword.'%')
                ->orderBy('customer_name');
        } else {
            $Customers = Customers::orderBy('customer_name');
        }

        $Customers = $Customers->paginate();

        return view('customers.customers_search', compact(['Customers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Customer = new Customers();
        return view('customers.customers_edit', compact(['Customer']));
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
            Customers::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/customers")->with(compact('status'));
        }

        $arr_validation = [];
        if ( !$request->has('id') ) {
            $arr_validation['customer_name'] = "required|unique:customers";
        } else {
            $arr_validation['customer_name'] = "required|unique:customers,customer_name,".$request->input('id');
        }

        $this->validate($request,$arr_validation);

        if ( !$request->has('id') ) {
            $Customer = Customers::create($request->all());
            $status = "Transaction Saved";
        } else {
            $Customer = Customers::find($request->input('id'));
            $Customer->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/customers/$Customer->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Customer = Customers::findOrNew($id);
        return view('customers.customers_edit', compact(['Customer']));
    }
}
