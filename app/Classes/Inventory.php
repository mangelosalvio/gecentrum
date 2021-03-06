<?php
namespace App\Classes;

use App\Products;
use App\StocksReceiving;
use Illuminate\Support\Facades\DB;

class Inventory
{
    public function inventoryBalance($date,$product_id)
    {
        $received = DB::table('rr')
            ->join('products_rr','products_rr.rr_id','=','rr.id')
            ->whereNull('rr.deleted_at')
            ->whereNull('products_rr.deleted_at')
            ->where('date','<=', $date)
            ->where('product_id', $product_id)
            ->sum('quantity');

        $deliveries = DB::table('delivery_receipts')
            ->join('delivery_receipt_details','delivery_receipt_details.delivery_receipt_id','=','delivery_receipts.id')
            ->whereNull('delivery_receipts.deleted_at')
            ->whereNull('delivery_receipt_details.deleted_at')
            ->where('date','<=', $date)
            ->where('product_id', $product_id)
            ->sum('quantity');

        $sales_returns = DB::table('sales_returns')
            ->join('sales_return_details','sales_return_details.sales_return_id','=','sales_returns.id')
            ->whereNull('sales_returns.deleted_at')
            ->whereNull('sales_return_details.deleted_at')
            ->where('date','<=',$date)
            ->where('product_id',$product_id)
            ->sum('quantity');


        return $received - $deliveries + $sales_returns;
    }

    public function stockCard($from_date, $to_date, $product_id)
    {
        $Product = Products::find($product_id);

        if ( $Product->has_serial_no ) {
            $StocsReceiving = StocksReceiving::whereBetween('date',[$from_date,$to_date])
                ->whereHas('details', function($query) use ($product_id){
                    $query->whereProductId($product_id);
                })
                ->with([ 'details' => function($query) use ($product_id) {
                    $query->whereProductId($product_id)
                    ->with('serials');
            }]);

            //dd($StocsReceiving->get()->toArray());
            return $StocsReceiving->get();
        } else {
            $stocks_receiving = DB::table('rr')
                ->join('products_rr','products_rr.rr_id','=','rr.id')
                ->join('products','products.id','=','products_rr.product_id')
                ->whereNull('rr.deleted_at')
                ->whereNull('products_rr.deleted_at')
                ->whereBetween('date',[$from_date, $to_date])
                ->where('product_id', $product_id)
                ->select(DB::raw("date, concat('#', document_no,' ',date_received) as transaction, rr.id as reference, quantity as in_qty, 0 as out_qty"));

            $delivery_receipts = DB::table('delivery_receipts')
                ->join('delivery_receipt_details','delivery_receipt_details.delivery_receipt_id','=','delivery_receipts.id')
                ->join('customers','customers.id','=','delivery_receipts.customer_id')
                ->whereNull('delivery_receipts.deleted_at')
                ->whereNull('delivery_receipt_details.deleted_at')
                ->whereBetween('date',[$from_date, $to_date])
                ->where('product_id', $product_id)
                ->select(DB::raw("date, concat('#',delivery_receipt_id,' ',customer_name) as transaction, delivery_receipts.id as reference, 0 as in_qty, quantity as out_qty"));

            $sales_returns = DB::table('sales_returns')
                ->join('sales_return_details','sales_returns.id','=','sales_return_details.sales_return_id')
                ->join('delivery_receipt_details','delivery_receipt_details.id','=','sales_return_details.delivery_receipt_detail_id')
                ->join('delivery_receipts','delivery_receipts.id','=','delivery_receipt_details.delivery_receipt_id')
                ->join('customers','customers.id','=','delivery_receipts.customer_id')
                ->whereNull('sales_returns.deleted_at')
                ->whereNull('sales_return_details.deleted_at')
                ->whereBetween('sales_returns.date',[$from_date, $to_date])
                ->where('sales_return_details.product_id', $product_id)
                ->select(DB::raw("sales_returns.date, concat('#',sales_returns.id,' ',customer_name) as transaction, sales_returns.id as reference, sales_return_details.quantity as in_qty, 0 as out_qty"));

            $StockCard = $stocks_receiving->unionAll($delivery_receipts)
                ->unionAll($sales_returns)
                ->orderBy('date');

            $StockCard = collect($StockCard->get());

            $StockCardFiltered = $StockCard->filter(function($Item){
                if ( $Item->in_qty > 0 || $Item->out_qty > 0 ) {
                    return true;
                } else {
                    return false;
                }
            });

            //dd($StockCardFiltered->all());

            return $StockCardFiltered->all();
        }

    }

}