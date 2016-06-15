@extends('sales_returns.sales_returns')
@section('body')
    {!! $SalesReturns->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>SR#</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($SalesReturns as $SalesReturn)
            <tr onclick="window.location.href='{{ url("/sales_returns/$SalesReturn->id/edit") }}'">
                <td>{{ str_pad($SalesReturn->id,7,0,STR_PAD_LEFT) }}</td>
                <td>{{ $SalesReturn->date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $SalesReturns->render() !!}
@endsection
