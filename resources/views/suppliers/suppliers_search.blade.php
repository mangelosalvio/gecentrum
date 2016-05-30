@extends('suppliers.suppliers')
@section('body')
    {!! $Suppliers->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Supplier Code</th>
            <th>Supplier Name</th>
            <th>Address</th>
            <th>Contact Person</th>
            <th>Email Address</th>
            <th>Contact No.</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Suppliers as $Supplier)
            <tr onclick="window.location.href='{{ url("/suppliers/$Supplier->id/edit") }}'">
                <td>{{ $Supplier->supplier_code }}</td>
                <td>{{ $Supplier->supplier_name }}</td>
                <td>{{ $Supplier->address }}</td>
                <td>{{ $Supplier->contact_person }}</td>
                <td>{{ $Supplier->email_address }}</td>
                <td>{{ $Supplier->contact_no }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $Suppliers->render() !!}
@endsection
