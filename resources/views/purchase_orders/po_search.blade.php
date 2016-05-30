@extends('purchase_orders.po')
@section('body')
    {!! $PO->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>PO#</th>
            <th>Date</th>
            <th>Supplier</th>
            <!-- <th class="text-center">PO Status</th> -->
        </tr>
        </thead>
        <tbody>
        @foreach($PO as $Order)
            <tr onclick="window.location.href='{{ url("/po/$Order->id/edit") }}'">
                <td>{{ str_pad($Order->id,7,0,STR_PAD_LEFT) }}</td>
                <td>{{ $Order->date }}</td>
                <td>{{ $Order->supplier->supplier_name}}</td>
                <!-- <td class="text-center">{{ $Order->po_status}}</td> -->
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $PO->render() !!}
@endsection
