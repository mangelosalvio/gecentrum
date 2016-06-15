<?php

namespace App\Http\Controllers;

use App\DeliveryReceipt;
use App\Products;
use App\SalesReturn;
use App\SalesReturnDetail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SalesReturnController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

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
            $SalesReturns = SalesReturn::orWhere('date','like',$keyword.'%')
                ->orderBy('date');
        } else {
            $SalesReturns = SalesReturn::orderBy('id','desc');
        }

        $SalesReturns = $SalesReturns->paginate();

        return view('sales_returns.sales_returns_search', compact(['SalesReturns']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $SalesReturn = new SalesReturn();
        return view('sales_returns.sales_returns_edit', compact(['SalesReturn']));
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
            SalesReturn::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/sales_returns")->with(compact('status'));
        }

        $arr_validation  = [
            'date' => 'required',
        ];

        $arr_messages = [
            'date.required' => 'Enter Date',
        ];

        $this->validate($request, $arr_validation, $arr_messages);

        if ( !$request->has('id') ) {
            $SalesReturn = SalesReturn::create($request->all());
            $status = "Transaction Saved";
        } else {
            $SalesReturn = SalesReturn::find($request->input('id'));
            $SalesReturn->update($request->all());
            $status = "Transaction Updated";
        }

        /**
         * For printing
         */

        $url = null;
        if ( $request->input('action') == 'Print Preview' ) {
            $url = 'sales_returns/'.$SalesReturn->id.'/print';
        }

        return redirect("/sales_returns/$SalesReturn->id/edit")->with(compact([
            'status',
            'url'
        ]));
    }

    public function addProduct($id, Request $request)
    {
        $arr_validation = [
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'amount' => 'required|numeric'
        ];

        $arr_messages = [
            'product_id.required' => 'Select a product'
        ];

        $this->validate($request,$arr_validation,$arr_messages);

        SalesReturn::findOrNew($id)
            ->products()->attach($request->input('product_id'),[
                'quantity' => $request->input('quantity'),
                'price' => $request->input('price'),
                'amount' => $request->input('amount')

            ]);

        $status = 'Product added';

        return redirect("/sales_returns/$id/edit")->with(compact('status'));
    }

    public function deleteDetail($id)
    {
        $SalesReturn = SalesReturnDetail::findOrNew($id)->SalesReturn;
        SalesReturnDetail::findOrNew($id)->delete();
        $status = 'Detail Deleted';

        return redirect("/sales_returns/$SalesReturn->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $SalesReturn = SalesReturn::findOrNew($id);
        return view('sales_returns.sales_returns_edit', compact(['SalesReturn']));
    }

    public function searchDeliveryReceipt(Request $request)
    {
        $DeliveryReceipt = DeliveryReceipt::find($request->input('delivery_receipt_id'));
        $SalesReturn = SalesReturn::find($request->input('id'));
        return view('sales_returns.sales_returns_delivery_receipts',compact([
            'DeliveryReceipt',
            'SalesReturn'
        ]));
    }

    public function returnProducts(Request $request)
    {
        $SalesReturn = SalesReturn::find($request->input('id'));

        if ( $request->has('arr_product_id') ) {
            foreach ( $request->input('arr_product_id') as $i => $product_id ) {

                if ( $request->input('arr_quantity')[$i] <= 0) {
                    continue;
                }

                $SalesReturnDetail = new SalesReturnDetail([
                    'product_id' => $product_id,
                    'delivery_receipt_detail_id' => $request->input('arr_delivery_receipt_detail_id')[$i],
                    'serial_no' => $request->input('arr_serial_no')[$i],
                    'quantity' => $request->input('arr_quantity')[$i],
                    'price' => $request->input('arr_price')[$i],
                    'amount' => $request->input('arr_amount')[$i],
                ]);

                $SalesReturn->details()
                    ->save($SalesReturnDetail);
            }

        }
        $status = "Items Added";
        return redirect("/sales_returns/" . $SalesReturn->id . "/edit")->with(compact('status'));
    }

    public function printTransaction(Request $request,$id)
    {
        $SalesReturn = SalesReturn::find($id);
        return view('reports.sales_returns.print_sales_return', compact([
            'SalesReturn'
        ]));
    }
}
