@extends('reports.master')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>STOCK CARD</small>
            </h3>
        </div>

        <div class="col-sm-12">
            @if( isset($StocksReceiving) )
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="3" class="text-center">STOCKS ARRIVAL</th>
                        <th colspan="3" class="text-center">DELIVERY RECEIPTS</th>
                        <th colspan="2" class="text-center">SALES RETURN</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- <tr>
                        <td colspan="5">Balance</td>
                        <td class="text-right">{{ number_format($beg_balance,2) }}</td>
                    </tr> -->
                    @foreach($StocksReceiving as $i => $RR)
                        <?php $c = 0; $d = 0?>
                        @foreach($RR->details as $Detail)
                            @foreach($Detail->serials as $Serial)
                                <tr>
                                    @if( $c == 0 && $d == 0)
                                        <td>{{ $RR->date }}</td>
                                        <td>
                                            {{ $Detail->product->product_name }} <br/>
                                            <small>#{{ $Detail->document_no }} {{ $Detail->date_received }}</small>
                                        </td>
                                    @elseif( $d > 0 )
                                        <td></td>
                                        <td>
                                            {{ $Detail->product->product_name }} <br/>
                                            <small>#{{ $Detail->document_no }} {{ $Detail->date_received }}</small>
                                        </td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif

                                    <td class="text-right">{{ $Serial->serial_no }}</td>
                                    <td>{{ isset($Serial->sales) ? $Serial->sales->date : '' }}</td>
                                    <td>{{ isset($Serial->sales) ? str_pad($Serial->sales->id,7,0,STR_PAD_LEFT) : '' }}</td>
                                    <td>{{ isset($Serial->sales) ? $Serial->sales->customer->customer_name : '' }}</td>

                                    @if( isset($Serial->sales_return) )
                                        <td>{{ isset($Serial->sales_return) ? $Serial->sales_return->date : '' }}</td>
                                        <td>{{ isset($Serial->sales_return) ? str_pad($Serial->sales_return->id,7,0,STR_PAD_LEFT) : '' }}</td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                                <?php $c++; ?>
                            @endforeach
                            <?php $d++ ?>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            @endif
            @if ( isset($StockCard) )
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>DATE</th>
                        <th>TRANSACTION</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>BALANCE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="4">Balance</td>
                        <td class="text-right">{{ number_format($beg_balance,2) }}</td>
                    </tr>
                    @foreach($StockCard as $r)
                        <tr>
                            <td>{{ $r->date }}</td>
                            <td>{{ $r->transaction }}</td>
                            <td class="text-right">{{ number_format($r->in_qty,2) }}</td>
                            <td class="text-right">{{ number_format($r->out_qty,2) }}</td>
                            <td class="text-right">{{ number_format($r->balance,2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @endif
        </div>

    </div>

@endsection