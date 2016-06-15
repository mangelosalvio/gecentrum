@extends('reports.master')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>STOCK ARRIVAL HISTORY <br/> as of {{ $from_date }} to {{ $to_date }} </small>
            </h3>
        </div>

        <div class="row">
            @if( isset($RRs) )
                <div class="col-sm-12">
                    <table class="table-content">
                        <thead>
                        <tr>
                            <th>DATE</th>
                            <th>RR#</th>
                            <th>PRODUCT</th>
                            <th>SERIAL NO</th>
                            <th>DATE RECEIVED</th>
                            <th>DOCUMENT NO</th>
                            <th class="text-right">QTY</th>
                            <th class="text-right">COST</th>
                            <th class="text-right">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                            $arr_total = array();
                            $arr_total['amount'] = 0;
                            $arr_total['quantity'] = 0;
                        ?>
                        @foreach($RRs as $RR)
                            @foreach($RR->details as $Detail)
                                <?
                                        $arr_total['amount'] += $Detail->amount;
                                        $arr_total['quantity'] += $Detail->quantity;
                                ?>
                                <tr>
                                    <td>{{ $RR->date }}</td>
                                    <td>{{ str_pad($RR->id,7,0,STR_PAD_LEFT) }}</td>
                                    <td>{{ $Detail->product->product_name }}</td>
                                    <td>
                                        @foreach($Detail->serials as $i => $Serial)
                                            {{ $Serial->serial_no }}
                                            @if( $i < count($Detail->serials) )
                                                <br/>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $Detail->date_received }}</td>
                                    <td>{{ $Detail->document_no }}</td>
                                    <td class="text-right">{{ number_format($Detail->quantity,2) }}</td>
                                    <td class="text-right">{{ number_format($Detail->cost,2) }}</td>
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