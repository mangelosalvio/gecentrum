@extends('reports.master')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>SALES RETURN</small>
            </h3>
        </div>

        <div class="row">
            <div class="col-xs-offset-8 col-xs-1 text-right" >No.</div>
            <div class="col-xs-3" style="font-size: 20px; font-weight: bold;">{{ str_pad($SalesReturn->id,7,0,STR_PAD_LEFT) }}</div>

        </div>

        <div class="row">
            <div class="col-xs-1">Issue:</div>
            <div class="col-xs-offset-2 col-xs-1">Verified:</div>
            <div class="col-xs-offset-2 col-xs-1">Posted:</div>
            <div class="col-xs-offset-2 col-xs-1">Date:</div>
            <div class="col-xs-2">{{ $SalesReturn->date }}</div>

        </div>

        <div class="row">
            <table class="table-content">
                <thead>
                <tr>
                    <th class="text-center">PRODUCT</th>
                    <th class="text-center">SERIAL NO</th>
                    <th class="text-center">QTY</th>
                    <th class="text-center">PRICE</th>
                    <th class="text-center">AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                @foreach($SalesReturn->details as $Detail)
                    <tr>
                        <td>{{ $Detail->product->product_name }} (DR#{{ str_pad($Detail->DeliveryReceiptDetail->DeliveryReceipt->id,7,0,STR_PAD_LEFT) }}) - {{ $Detail->DeliveryReceiptDetail->DeliveryReceipt->customer->customer_name }}</td>
                        <td>{{ $Detail->serial_no }}</td>
                        <td class="text-right" style="vertical-align: top;">{{ number_format($Detail->quantity,2) }}</td>
                        <td class="text-right" style="vertical-align: top;">{{ number_format($Detail->price,2) }}</td>
                        <td class="text-right" style="vertical-align: top;">{{ number_format($Detail->amount,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{ number_format($SalesReturn->details->sum('quantity'),2) }}</td>
                    <td></td>
                    <td class="text-right">{{ number_format($SalesReturn->details->sum('amount'),2) }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection