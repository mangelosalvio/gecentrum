@extends('reports.master')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>SALES RETURNS HISTORY <br/> as of {{ $from_date }} to {{ $to_date }} </small>
            </h3>
        </div>

        <div class="row">
            @if( isset($SalesReturns) )
                <div class="col-sm-12">
                    <table class="table-content">
                        <thead>
                        <tr>
                            <th>DATE</th>
                            <th>SR#</th>
                            <th>CUSTOMER</th>
                            <th>PRODUCT</th>
                            <th>SERIAL</th>
                            <th class="text-right">QTY</th>
                            <th class="text-right">PRICE</th>
                            <th class="text-right">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                            $arr_total = array();
                            $arr_total['amount'] = 0;
                            $arr_total['quantity'] = 0;
                        ?>
                        @foreach($SalesReturns as $SalesReturn)
                            @foreach($SalesReturn->details as $Detail)
                                <?
                                        $arr_total['amount'] += $Detail->amount;
                                        $arr_total['quantity'] += $Detail->quantity;
                                ?>
                                <tr>
                                    <td>{{ $SalesReturn->date }}</td>
                                    <td>{{ str_pad($SalesReturn->id,7,0,STR_PAD_LEFT) }}</td>
                                    <td>{{ $Detail->DeliveryReceiptDetail->DeliveryReceipt->customer->customer_name }}</td>
                                    <td>{{ $Detail->product->product_name }}</td>
                                    <td>{{ $Detail->serial_no }}</td>
                                    <td class="text-right">{{ number_format($Detail->quantity,2) }}</td>
                                    <td class="text-right">{{ number_format($Detail->price,2) }}</td>
                                    <td class="text-right">{{ number_format($Detail->amount,2) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">{{ number_format($arr_total['quantity'],2) }}</td>
                            <td></td>
                            <td class="text-right">{{ number_format($arr_total['amount'],2) }}</td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            @endif
        </div>
    </div>
@endsection