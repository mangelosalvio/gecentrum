<?php

namespace App\Http\Controllers;

use App\DeliveryReceipt;
use App\Facades\Inventory;
use App\PO;
use App\Products;
use App\PurchaseReturns;
use App\SalesReturn;
use App\StocksReceiving;
use App\WarehouseReleases;
use App\Warehouses;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ReportsController extends Controller
{
    public function __construct()
    {

        return view()->share(compact([

        ]));
    }

    public function getInventoryBalanceReport()
    {

        $date = Input::get('date');

        if ( !empty($date ) ) {
            $url = url("reports/print-inventory-balance-report?date=$date");
        }

        return view('reports.inventory_balance_report', compact([
            'date',
            'Products',
            'url'
        ]));
    }

    public function getPrintInventoryBalanceReport(Request $request)
    {

        $date = $request->get('date');

        if ( !empty($date ) ) {
            $Products = Products::orderBy('product_name')->get();

            $Products->each(function($Product) use ($date){
                $Product->balance = Inventory::inventoryBalance($date,$Product->id);
            });

        }

        return view('reports.print_inventory_balance_report', compact([
            'date',
            'Products'
        ]));
    }

    public function getStockCardReport(Request $request)
    {

        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');
        $product_name = Input::get('product_name');
        $product_id   = Input::get('product_id');


        if ( !empty( $from_date ) && !empty( $to_date ) ) {
            $arr_validation  = [
                'product_id' => 'required'
            ];

            $arr_messages = [
                'product_id.required' => 'Please select a Product'
            ];

            $this->validate($request, $arr_validation, $arr_messages);
            $url = url("reports/print-stock-card-report?from_date=$from_date&to_date=$to_date&product_id=$product_id");
        }

        return view('reports.stock_card_report', compact([
            'from_date',
            'to_date',
            'product_name',
            'product_id',
            'url'
        ]));
    }


    public function getPrintStockCardReport(Request $request)
    {
        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');
        $product_name = Input::get('product_name');
        $product_id   = Input::get('product_id');

        if ( !empty( $from_date )
            && !empty( $to_date )
        ) {

            $beg_balance = $balance = Inventory::inventoryBalance(Carbon::parse($from_date)->subDay(1),$product_id);

            $Product = Products::find($product_id);

            if ( $Product->has_serial_no ) {
                $StocksReceiving = Inventory::stockCard($from_date, $to_date, $product_id);
            } else {
                $StockCard = Inventory::stockCard($from_date, $to_date, $product_id);

                if ( count($StockCard) ) {
                    foreach ( $StockCard as $Item ) {
                        $balance += $Item->in_qty;
                        $balance -= $Item->out_qty;
                        $Item->balance = $balance;
                    }
                }
            }
        }

        return view('reports.print_stock_card_report', compact([
            'from_date',
            'to_date',
            'product_name',
            'product_id',
            'StocksReceiving',
            'beg_balance',
            'StockCard'
        ]));
    }




    public function getPoHistory()
    {

        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');


        if ( !empty( $from_date )
            && !empty( $to_date ) ) {
            $url = url("reports/print-po-history?from_date=$from_date&to_date=$to_date");
        }

        return view('reports.po_history', compact([
            'url',
            'from_date',
            'to_date'
        ]));
    }

    public function getPrintPoHistory(Request $request){

        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $POs = PO::with('details','supplier')
            ->whereBetween('date',[$from_date, $to_date])
            ->orderBy('date')
            ->get();

        $arr_total = [];
        $arr_total['amount'] = 0;
        $arr_total['quantity'] = 0;

        if ( count( $POs ) ) {
            foreach ( $POs as $PO ) {
                if ( count( $PO->details ) ) {
                    foreach ( $PO->details as $Detail ) {
                        $arr_total['amount'] += $Detail->amount;
                        $arr_total['quantity'] += $Detail->quantity;

                    }
                }
            }

        }

        return view('reports.po.print_po_history', compact([
            'POs',
            'from_date',
            'to_date',
            'arr_total'
        ]));
    }

    public function getRrHistory()
    {

        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');

        if ( !empty( $from_date )
            && !empty( $to_date ) ) {

            $url = url("reports/print-rr-history?from_date=$from_date&to_date=$to_date");
        }

        return view('reports.rr_history', compact([
            'from_date',
            'to_date',
            'url'
        ]));
    }

    public function getPrintRrHistory(Request $request){

        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $RRs = StocksReceiving::with('details')
            ->whereBetween('date',[$from_date, $to_date])
            ->orderBy('date')
            ->get();

        return view('reports.rr.print_rr_history', compact([
            'RRs',
            'from_date',
            'to_date'
        ]));
    }

    public function getDeliveryReceiptsHistory()
    {
        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');


        if ( !empty( $from_date )
            && !empty( $to_date ) ) {
            $url = url("reports/print-delivery-receipts-history?from_date=$from_date&to_date=$to_date");
        }

        return view('reports.delivery_receipts.delivery_receipts_history', compact([
            'url',
            'from_date',
            'to_date'
        ]));
    }

    public function getPrintDeliveryReceiptsHistory(Request $request)
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $DRs = DeliveryReceipt::with('details','customer')
            ->whereBetween('date',[$from_date, $to_date])
            ->orderBy('date')
            ->get();

        return view('reports.delivery_receipts.print_delivery_receipts_history', compact([
            'DRs',
            'from_date',
            'to_date'
        ]));
    }

    public function getPurchaseReturnHistory()
    {
        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');

        if ( !empty( $from_date )
            && !empty( $to_date ) ) {

            $PurchaseReturns = PurchaseReturns::with('products','supplier','warehouse')
                ->orderBy('date')
                ->get();
        }

        return view('reports.purchase_return_history', compact([
            'from_date',
            'to_date',
            'PurchaseReturns'
        ]));
    }

    public function getWarehouseReleaseHistory()
    {
        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');

        if ( !empty( $from_date )
            && !empty( $to_date ) ) {

            $WarehouseReleases = WarehouseReleases::with('products','fromWarehouse','toWarehouse')
                ->orderBy('date')
                ->get();
        }

        return view('reports.warehouse_release_history', compact([
            'from_date',
            'to_date',
            'WarehouseReleases'
        ]));
    }

    public function getProductCostReport()
    {

        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');
        $product_name = Input::get('product_name');
        $product_id   = Input::get('product_id');


        if ( !empty( $from_date )
            && !empty( $to_date ) ) {

            $RRs = StocksReceiving::with([ 'products' => function($query) use ($product_id){
                    $query->where('products.id',$product_id);
                } ])
                ->orderBy('date')
                ->get();

            $sum = 0;
            $c = 0;
            if ( count( $RRs ) ) {
                foreach ( $RRs as $RR ) {
                    if ( count( $RR->products ) ) {
                        foreach ( $RR->products as $Product ) {
                            $sum += $Product->pivot->cost;
                            $c++;
                        }
                    }

                }
            }
            $avg = $sum / $c;
        }

        return view('reports.product_cost_report', compact([
            'from_date',
            'to_date',
            'product_name',
            'product_id',
            'RRs',
            'avg'
        ]));
    }

    public function getSalesReturnsHistory()
    {
        $from_date    = Input::get('from_date');
        $to_date      = Input::get('to_date');


        if ( !empty( $from_date )
            && !empty( $to_date ) ) {
            $url = url("reports/print-sales-returns-history?from_date=$from_date&to_date=$to_date");
        }

        return view('reports.sales_returns.sales_returns_history', compact([
            'url',
            'from_date',
            'to_date'
        ]));
    }

    public function getPrintSalesReturnsHistory(Request $request)
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $SalesReturns = SalesReturn::with('details')
            ->whereBetween('date',[$from_date, $to_date])
            ->orderBy('date')
            ->get();

        return view('reports.sales_returns.print_sales_returns_history', compact([
            'SalesReturns',
            'from_date',
            'to_date'
        ]));
    }


}
