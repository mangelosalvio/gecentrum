@extends('reports.master')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>DELIVERY RECEIPT</small>
            </h3>
        </div>

        <div class="row">
            <div class="col-xs-offset-8 col-xs-1" >No.</div>
            <div class="col-xs-3" style="font-size: 20px; font-weight: bold;">{{ str_pad($DeliveryReceipt->id,7,0,STR_PAD_LEFT) }}</div>

        </div>

        <div class="row">
            <div class="col-xs-1">To</div>
            <div class="col-xs-7">
                {{ $DeliveryReceipt->customer->customer_name }}
            </div>
            <div class="col-xs-2">Date</div>
            <div class="col-xs-2">{{ $DeliveryReceipt->date }}</div>

            <div class="col-xs-1">Salesman</div>
            <div class="col-xs-7">
                {{ $DeliveryReceipt->salesman }}
            </div>
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
                @foreach($DeliveryReceipt->products as $Product)
                    <tr>
                        <td class="text-right">{{ $Product->pivot->quantity }}</td>
                        <td>{{ $Product->unit }}</td>
                        <td>
                            {{ $Product->product_name }}
                            @if( !empty($Product->pivot->serial_no) )
                                <em>SN: {{ $Product->pivot->serial_no }}</em>
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($Product->pivot->price,2) }}</td>
                        <td class="text-right">{{ number_format($Product->pivot->amount,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td class="text-right"><strong>{{ number_format($DeliveryReceipt->details->sum('quantity'),2) }}</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><strong>{{ number_format($DeliveryReceipt->details->sum('amount'),2) }}</strong></td>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>

@endsection