<?php

namespace App\Http\Controllers;

use App\PO;
use App\PODetails;
use App\Products;
use App\RRDetail;
use App\StocksReceiving;
use App\Suppliers;
use App\Warehouses;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PurchaseOrderController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

        $Suppliers = Suppliers::orderBy('supplier_name')->lists('supplier_name','id');
        $Products = Products::orderBy('product_name')->lists('product_name','id');

        return view()->share(compact([
            'Suppliers',
            'Products',
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
            $PO = PO::orWhere('date','like',$keyword.'%')
                ->orderBy('date');
        } else {
            $PO = PO::orderBy('date');
        }

        $PO->get()->each(function($Order){
            $Order->ss = 'ss';
        });

        $PO = $PO->paginate();

        return view('purchase_orders.po_search', compact(['PO']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PO = new PO();
        return view('purchase_orders.po_edit', compact(['PO']));
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
            PO::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/po")->with(compact('status'));
        } elseif ( $request->input('action') == 'Receive' ) {
            return redirect("/po/" . $request->input('id') . "/receive");
        }

        $arr_validation  = [
            'date' => 'required',
            'supplier_id' => 'required'
        ];

        $arr_messages = [
            'date.required' => 'Enter Date',
            'supplier_id.required' => 'Select a Supplier',
        ];

        $this->validate($request, $arr_validation, $arr_messages);

        if ( !$request->has('id') ) {
            $PO = PO::create($request->all());
            $status = "Transaction Saved";
        } else {
            $PO = PO::find($request->input('id'));
            $PO->update($request->all());
            $status = "Transaction Updated";
        }

        if ( $request->input('action') == 'Close' ) {
            $PO->status = "X";
            $PO->save();
        }

        /**
         * For printing
         */

        $url = null;
        if ( $request->input('action') == 'Print Preview' ) {
            $url = 'po/'.$PO->id.'/print';
        }

        return redirect("/po/$PO->id/edit")->with(compact([
            'status',
            'url'
        ]));
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

        PO::findOrNew($id)
            ->products()->attach($request->input('product_id'),[
                'quantity' => $request->input('quantity'),
                'cost' => $request->input('cost'),
                'amount' => $request->input('amount')

            ]);

        $status = 'Product added';

        return redirect("/po/$id/edit")->with(compact('status'));
    }

    public function deleteDetail($id)
    {
        $PO = PODetails::findOrNew($id)->PO;
        PODetails::findOrNew($id)->delete();
        $status = 'Detail Deleted';

        return redirect("/po/$PO->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $PO = PO::whereId($id)->with('details')->first();

        $PO->details->each(function($Detail) {
            $Detail->rr_qty = $this->receivedQty($Detail->id);
        });

        return view('purchase_orders.po_edit', compact([
            'PO'
        ]));
    }

    public function receivePO($id)
    {
        $PO = PO::whereId($id)->with('details')->first();

        $PO->details->each(function($Detail) use ($PO){
            $Detail->rr_qty = $this->receivedQty($PO->id, $Detail->product_id);
            $Detail->quantity -= $Detail->rr_qty;
            $Detail->amount = $Detail->quantity * $Detail->cost;
        });

        return view('purchase_orders.po_receive', compact(['PO']));
    }

    public function receive(Request $request)
    {

        $arr_validation = [
          'date' => 'required',
          'supplier_id' => 'required',
          'warehouse_id' => 'required'
        ];

        $arr_messages = [
          'supplier_id.required' => 'Select a Supplier',
          'warehouse_id.required' => 'Select a Warehouse'
        ];

        $this->validate($request, $arr_validation, $arr_messages);


        $RR = StocksReceiving::create($request->all());

        if ( count( $request->input('arr_product_id') ) ) {
            foreach ( $request->input('arr_product_id') as $i => $product_id ) {
                $arr_detail = [
                  'quantity' => $request->input('arr_quantity')[$i],
                  'cost' => $request->input('arr_cost')[$i],
                  'amount' => $request->input('arr_amount')[$i]
                ];

                $RR->products()->attach($product_id, $arr_detail);
            }
        }


        return redirect("rr/$RR->id/edit");
    }

    public function receivedQty($po_detail_id)
    {
        return DB::table('rr')
            ->join('products_rr', 'rr.id', '=', 'products_rr.rr_id')
            ->wherePoDetailId($po_detail_id)
            ->whereNull('products_rr.deleted_at')
            ->sum('quantity');
    }

    public function getPOStatus($id)
    {
        /**
         * pending if no rr
         */

        if ( StocksReceiving::wherePoId($id)->count() <= 0 ) {
            return "Pending";
        } else {
            return "";
        }
    }

    public function printTransaction(Request $request,$id)
    {
        $PO = PO::find($id);

        return view('reports.po.print_po', compact([
            'PO'
        ]));
    }
}
