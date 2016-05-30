@extends('warehouse_releases.warehouse_releases')
@section('body')
    {!! $WarehouseReleases->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>WR#</th>
            <th>Date</th>
            <th>Customer</th>
            <th>From Warehouse</th>
            <th>To Warehouse</th>
            <th>Released By</th>
        </tr>
        </thead>
        <tbody>
        @foreach($WarehouseReleases as $WarehouseRelease)
            <tr onclick="window.location.href='{{ url("/warehouse_releases/$WarehouseRelease->id/edit") }}'">
                <td>{{ str_pad($WarehouseRelease->id,7,0,STR_PAD_LEFT) }}</td>
                <td>{{ $WarehouseRelease->date }}</td>
                <td>{{ isset( $WarehouseRelease->customer->customer_name ) ? $WarehouseRelease->customer->customer_name : '-' }}</td>
                <td>{{ $WarehouseRelease->fromWarehouse->warehouse_name }}</td>
                <td>{{ $WarehouseRelease->toWarehouse->warehouse_name }}</td>
                <td>{{ $WarehouseRelease->released_by }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $WarehouseReleases->render() !!}
@endsection
