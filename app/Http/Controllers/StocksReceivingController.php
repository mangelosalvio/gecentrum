<?php

namespace App\Http\Controllers;

use App\PO;
use App\Products;
use App\RRDetail;
use App\StocksReceiving;
use App\Suppliers;
use App\Warehouses;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class StocksReceivingController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

        $Suppliers = Suppliers::orderBy('supplier_name')->lists('supplier_name','id');
        $Products = Products::orderBy('product_name')->lists('product_name','id');

        return view()->share(compact([
            'Suppliers',
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
            $StocksReceiving = StocksReceiving::orWhere('date','like',$keyword.'%')
                ->orderBy('date');
        } else {
            $StocksReceiving = StocksReceiving::orderBy('id','desc');
        }

        $StocksReceiving = $StocksReceiving->paginate();

        return view('stocks_receiving.rr_search', compact(['StocksReceiving']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $StocksReceiving = new StocksReceiving();
        return view('stocks_receiving.rr_edit', compact(['StocksReceiving']));
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
            StocksReceiving::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/rr")->with(compact('status'));
        }

        $arr_validation  = [
            'date' => 'required',
        ];

        $arr_messages = [
            'date.required' => 'Enter Date',
        ];

        $this->validate($request, $arr_validation, $arr_messages);

        if ( !$request->has('id') ) {
            $StocksReceiving = StocksReceiving::create($request->all());
            $status = "Transaction Saved";
        } else {
            $StocksReceiving = StocksReceiving::find($request->input('id'));
            $StocksReceiving->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/rr/$StocksReceiving->id/edit")->with(compact('status'));
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

        StocksReceiving::findOrNew($id)
            ->products()->attach($request->input('product_id'),[
                'quantity' => $request->input('quantity'),
                'cost' => $request->input('cost'),
                'amount' => $request->input('amount')

            ]);

        $status = 'Product added';

        return redirect("/rr/$id/edit")->with(compact('status'));
    }

    public function deleteDetail($id)
    {
        $RR = RRDetail::findOrNew($id)->RR;
        RRDetail::findOrNew($id)->delete();
        $status = 'Detail Deleted';

        return redirect("/rr/$RR->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $StocksReceiving = StocksReceiving::findOrNew($id);
        return view('stocks_receiving.rr_edit', compact(['StocksReceiving']));
    }

    public function searchPO(Request $request)
    {
        $PO = PO::find($request->input('po_id'));
        $StocksReceiving = StocksReceiving::find($request->input('id'));
        return view('stocks_receiving.rr_po',compact([
            'PO',
            'StocksReceiving'
        ]));
    }

    public function receivePO(Request $request)
    {

        //dd($request->all());

        $StocksReceiving = StocksReceiving::find($request->input('id'));

        if ( $request->has('arr_product_id') ) {
            foreach ( $request->input('arr_product_id') as $i => $product_id ) {

                if ( $request->input('arr_quantity')[$i] <= 0) {
                    continue;
                }

                $RRDetail = new RRDetail([
                    'product_id' => $product_id,
                    'po_detail_id' => $request->input('arr_po_detail_id')[$i],
                    'document_no' => $request->input('arr_document_no')[$i],
                    'quantity' => $request->input('arr_quantity')[$i],
                    'cost' => $request->input('arr_cost')[$i],
                    'amount' => $request->input('arr_amount')[$i],
                    'date_received' => $request->input('arr_date_received')[$i]
                ]);

                $StocksReceiving->details()
                    ->save($RRDetail);

                if ( isset($request->input('arr_serial_no')['po'.$request->input('arr_po_detail_id')[$i]]) ) {
                    $serials = $request->input('arr_serial_no')['po'.$request->input('arr_po_detail_id')[$i]];

                    if ( count( $serials ) ){
                        foreach ( $serials as $serial ) {
                            if ( !empty( $serial ) ) {
                                $RRDetail->serials()
                                    ->create([
                                        'serial_no' => $serial
                                    ]);
                            }
                        }
                    }
                }
            }

        }
        $status = "Items Added";
        return redirect("/rr/" . $StocksReceiving->id . "/edit")->with(compact('status'));
    }
}
