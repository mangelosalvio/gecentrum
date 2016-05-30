@extends('stocks_receiving.rr')
@section('body')
    {!! $StocksReceiving->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>RR#</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($StocksReceiving as $Receive)
            <tr onclick="window.location.href='{{ url("/rr/$Receive->id/edit") }}'">
                <td>{{ str_pad($Receive->id,7,0,STR_PAD_LEFT) }}</td>
                <td>{{ $Receive->date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $StocksReceiving->render() !!}
@endsection
