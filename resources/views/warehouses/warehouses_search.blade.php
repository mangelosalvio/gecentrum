@extends('warehouses.warehouses')
@section('body')
    {!! $Warehouses->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Warehouse Code</th>
            <th>Warehouse Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Warehouses as $Warehouse)
            <tr onclick="window.location.href='{{ url("/warehouses/$Warehouse->id/edit") }}'">
                <td>{{ $Warehouse->warehouse_code }}</td>
                <td>{{ $Warehouse->warehouse_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $Warehouses->render() !!}
@endsection
