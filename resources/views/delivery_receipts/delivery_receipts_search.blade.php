@extends('delivery_receipts.delivery_receipts')
@section('body')
    {!! $DeliveryReceipts->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>DR#</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Salesman</th>
            <th>Remarks</th>
        </tr>
        </thead>
        <tbody>
        @foreach($DeliveryReceipts as $DeliveryReceipt)
            <tr onclick="window.location.href='{{ url("/delivery_receipts/$DeliveryReceipt->id/edit") }}'">
                <td>{{ str_pad($DeliveryReceipt->id,7,0,STR_PAD_LEFT) }}</td>
                <td>{{ $DeliveryReceipt->date }}</td>
                <td>{{ isset( $DeliveryReceipt->customer->customer_name ) ? $DeliveryReceipt->customer->customer_name : '-' }}</td>
                <td>{{ $DeliveryReceipt->salesman }}</td>
                <td>{{ $DeliveryReceipt->remarks }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $DeliveryReceipts->render() !!}
@endsection
