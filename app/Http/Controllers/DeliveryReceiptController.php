<?php

namespace App\Http\Controllers;

use App\Customers;
use App\DeliveryReceipt;
use App\DeliveryReceiptDetail;
use App\Products;
use App\Suppliers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DeliveryReceiptController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

        $Suppliers = Suppliers::orderBy('supplier_name')->lists('supplier_name','id');
        $Products = Products::orderBy('product_name')->lists('product_name','id');
        $Customers = Customers::orderBy('customer_name')->lists('customer_name','id');

        return view()->share(compact([
            'Suppliers',
            'Products',
            'Customers'
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
            $DeliveryReceipts = DeliveryReceipt::orWhere('date','like',$keyword.'%')
                ->orderBy('date');
        } else {
            $DeliveryReceipts = DeliveryReceipt::orderBy('id','desc');
        }

        $DeliveryReceipts = $DeliveryReceipts->paginate();

        return view('delivery_receipts.delivery_receipts_search', compact(['DeliveryReceipts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $DeliveryReceipt = new DeliveryReceipt();
        return view('delivery_receipts.delivery_receipts_edit', compact(['DeliveryReceipt']));
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
            DeliveryReceipt::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/delivery_receipts")->with(compact('status'));
        }

        $arr_validation  = [
            'date' => 'required',
            'customer_id' => 'required'
        ];

        $arr_messages = [
            'date.required' => 'Enter Date',
            'customer_id.required' => 'Select a Customer',
        ];

        $this->validate($request, $arr_validation, $arr_messages);

        if ( !$request->has('id') ) {
            $DeliveryReceipt = DeliveryReceipt::create($request->all());
            $status = "Transaction Saved";
        } else {
            $DeliveryReceipt = DeliveryReceipt::find($request->input('id'));
            $DeliveryReceipt->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/delivery_receipts/$DeliveryReceipt->id/edit")->with(compact('status'));
    }

    public function addProduct($id, Request $request)
    {
        $arr_validation = [
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
        ];

        $arr_messages = [
            'product_id.required' => 'Select a product'
        ];

        $this->validate($request,$arr_validation,$arr_messages);

        DeliveryReceipt::findOrNew($id)
            ->products()->attach($request->input('product_id'),[
                'quantity' => $request->input('quantity'),
                'price' => $request->input('price'),
                'amount' => $request->input('amount'),
                'serial_no' => $request->input('serial_no')
            ]);

        $status = 'Product added';

        return redirect("/delivery_receipts/$id/edit")->with(compact('status'));
    }

    public function deleteDetail($id)
    {

        $DeliveryReceipt = DeliveryReceiptDetail::findOrNew($id)->DeliveryReceipt;
        DeliveryReceiptDetail::find($id)->delete();
        $status = 'Detail Deleted';

        return redirect("/delivery_receipts/$DeliveryReceipt->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $DeliveryReceipt = DeliveryReceipt::findOrNew($id);
        return view('delivery_receipts.delivery_receipts_edit', compact(['DeliveryReceipt']));
    }
}
