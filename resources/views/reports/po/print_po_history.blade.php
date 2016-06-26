@extends('reports.master')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>PO HISTORY <br/> as of {{ $from_date }} to {{ $to_date }} </small>
            </h3>
        </div>

        <div class="row">
            @if( isset($POs) )
                <div class="col-sm-12">
                    <table class="table-content">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>PO#</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Cost</th>
                            <th class="text-right">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($POs as $PO)
                            @foreach($PO->details as $Detail)
                                <tr>
                                    <td>{{ $PO->date }}</td>
                                    <td>{{ str_pad($PO->id,7,0,STR_PAD_LEFT) }}</td>
                                    <td>{{ $PO->supplier->supplier_name }}</td>
                                    <td>{{ $Detail->product->product_name }}</td>
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