@extends('reports.master')
@section('content')



    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>PURCHASE ORDER</small>
            </h3>
        </div>

        <div class="row">
            <div class="col-xs-offset-8 col-xs-1" >No.</div>
            <div class="col-xs-3" style="font-size: 20px; font-weight: bold;">{{ str_pad($PO->id,7,0,STR_PAD_LEFT) }}</div>

        </div>

        <div class="row">
            <div class="col-xs-1">To</div>
            <div class="col-xs-7">
                {{ $PO->supplier->supplier_name }}
            </div>
            <div class="col-xs-2">Date</div>
            <div class="col-xs-2">{{ $PO->date }}</div>

        </div>

        <div class="row">
            <table class="table-content">
                <thead>
                <tr>
                    <th class="text-right">QTY</th>
                    <th>UNIT</th>
                    <th class="text-center">DESCRIPTION</th>
                    <th class="text-right">UNIT PRICE</th>
                    <th class="text-right">AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                @foreach($PO->products as $Product)
                    <tr>
                        <td class="text-right">{{ $Product->pivot->quantity }}</td>
                        <td>{{ $Product->unit }}</td>
                        <td>{{ $Product->product_name }}</td>
                        <td class="text-right">{{ number_format($Product->pivot->cost,2) }}</td>
                        <td class="text-right">{{ number_format($Product->pivot->amount,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td class="text-right"><strong>{{ number_format($PO->details->sum('quantity'),2) }}</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><strong>{{ number_format($PO->details->sum('amount'),2) }}</strong></td>
                </tr>
                </tfoot>
            </table>

        </div>

        <div class="row" style="margin-top: 20px;">
            <div class="col-xs-3">
                <div class="row">
                    <div>Approved By:</div>
                    <div style="border-bottom: 1px solid #000; margin-top: 30px;"></div>
                </div>
            </div>
            <div class="col-xs-offset-3 col-xs-6 text-right" style="font-size: 20px;">
                THIS P.O. IS VALID FOR 30 DAYS
            </div>

        </div>

    </div>

@endsection