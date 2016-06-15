@extends('reports.master')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>STOCK ARRIVAL</small>
            </h3>
        </div>

        <div class="row">
            <div class="col-xs-offset-8 col-xs-1 text-right" >No.</div>
            <div class="col-xs-3" style="font-size: 20px; font-weight: bold;">{{ str_pad($StocksReceiving->id,7,0,STR_PAD_LEFT) }}</div>

        </div>

        <div class="row">
            <div class="col-xs-1">Issue:</div>
            <div class="col-xs-offset-2 col-xs-1">Verified:</div>
            <div class="col-xs-offset-2 col-xs-1">Posted:</div>
            <div class="col-xs-offset-2 col-xs-1">Date:</div>
            <div class="col-xs-2">{{ $StocksReceiving->date }}</div>

        </div>

        <div class="row">
            <table class="table-content">
                <thead>
                <tr>
                    <th class="text-center">QTY</th>
                    <th class="text-center">MODEL</th>
                    <th class="text-center">INVOICE</th>
                </tr>
                </thead>
                <tbody>
                @foreach($StocksReceiving->details as $Detail)
                    <tr>
                        <td class="text-right" style="vertical-align: top;">{{ $Detail->quantity }}</td>
                        <td>
                            {{ $Detail->product->product_name }}
                            @if(count($Detail->serials))
                            <ul>
                                @foreach($Detail->serials as $Serial)
                                    <li>{{ $Serial->serial_no }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </td>
                        <td style="vertical-align: top;">{{ $Detail->PODetail->PO->supplier->supplier_name }} - {{ $Detail->document_no  }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection