@extends('purchase_returns.purchase_returns')
@section('body')
    {!! $PurchaseReturns->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>PR#</th>
            <th>Date</th>
            <th>Supplier</th>
            <th>Invoice</th>
            <th>Warehouse</th>
        </tr>
        </thead>
        <tbody>
        @foreach($PurchaseReturns as $PurchaseReturn)
            <tr onclick="window.location.href='{{ url("/purchase_returns/$PurchaseReturn->id/edit") }}'">
                <td>{{ str_pad($PurchaseReturn->id,7,0,STR_PAD_LEFT) }}</td>
                <td>{{ $PurchaseReturn->date }}</td>
                <td>{{ $PurchaseReturn->supplier->supplier_name}}</td>
                <td>{{ $PurchaseReturn->invoice_no }}</td>
                <td>{{ $PurchaseReturn->warehouse->warehouse_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $PurchaseReturns->render() !!}
@endsection
