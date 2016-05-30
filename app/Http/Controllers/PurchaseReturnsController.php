<?php

namespace App\Http\Controllers;

use App\Products;
use App\PurchaseReturnDetails;
use App\PurchaseReturns;
use App\Suppliers;
use App\Warehouses;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PurchaseReturnsController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

        $Suppliers = Suppliers::orderBy('supplier_name')->lists('supplier_name','id');
        $MainWarehouses = Warehouses::mainWarehouse()->orderBy('warehouse_name')->lists('warehouse_name','id');
        $Products = Products::orderBy('product_name')->lists('product_name','id');

        return view()->share(compact([
            'Suppliers',
            'MainWarehouses',
            'Products'
        ]));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $keyword = Input::get('search','');

        if ( !empty( $keyword ) ) {
            $PurchaseReturns = PurchaseReturns::orWhere('date','like',$keyword.'%')
                ->orderBy('date');
        } else {
            $PurchaseReturns = PurchaseReturns::orderBy('id','desc');
        }

        $PurchaseReturns = $PurchaseReturns->paginate();

        return view('purchase_returns.purchase_returns_search', compact(['PurchaseReturns']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PurchaseReturns = new PurchaseReturns();
        return view('purchase_returns.purchase_returns_edit', compact(['PurchaseReturns']));
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
            PurchaseReturns::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/purchase_returns")->with(compact('status'));
        }

        $arr_validation  = [
            'date' => 'required',
            'supplier_id' => 'required',
            'warehouse_id' => 'required'
        ];

        $arr_messages = [
            'date.required' => 'Enter Date',
            'supplier_id.required' => 'Select a Supplier',
            'warehouse_id.required' => 'Select a Warehouse'
        ];

        $this->validate($request, $arr_validation, $arr_messages);

        if ( !$request->has('id') ) {
            $PurchaseReturns = PurchaseReturns::create($request->all());
            $status = "Transaction Saved";
        } else {
            $PurchaseReturns = PurchaseReturns::find($request->input('id'));
            $PurchaseReturns->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/purchase_returns/$PurchaseReturns->id/edit")->with(compact('status'));
    }

    public function addProduct($id, Request $request)
    {
        $arr_validation = [
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'cost' => 'required|numeric',
            'amount' => 'required|numeric'
        ];

        $arr_messages = [
            'product_id.required' => 'Select a product'
        ];

        $this->validate($request,$arr_validation,$arr_messages);

        PurchaseReturns::findOrNew($id)
            ->products()->attach($request->input('product_id'),[
                'quantity' => $request->input('quantity'),
                'cost' => $request->input('cost'),
                'amount' => $request->input('amount')

            ]);

        $status = 'Product added';

        return redirect("/purchase_returns/$id/edit")->with(compact('status'));
    }

    public function deleteDetail($id)
    {

        $PurchaseReturn = PurchaseReturnDetails::findOrNew($id)->PurchaseReturn;
        PurchaseReturnDetails::findOrNew($id)->delete();
        $status = 'Detail Deleted';

        return redirect("/purchase_returns/$PurchaseReturn->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $PurchaseReturns = PurchaseReturns::findOrNew($id);
        return view('purchase_returns.purchase_returns_edit', compact(['PurchaseReturns']));
    }
}
