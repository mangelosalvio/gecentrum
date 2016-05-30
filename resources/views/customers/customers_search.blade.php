@extends('customers.customers')
@section('body')
    {!! $Customers->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Customer Code</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Contact Person</th>
            <th>Email Address</th>
            <th>Contact No.</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Customers as $Customer)
            <tr onclick="window.location.href='{{ url("/customers/$Customer->id/edit") }}'">
                <td>{{ $Customer->customer_code }}</td>
                <td>{{ $Customer->customer_name }}</td>
                <td>{{ $Customer->address }}</td>
                <td>{{ $Customer->contact_person }}</td>
                <td>{{ $Customer->email_address }}</td>
                <td>{{ $Customer->contact_no }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $Customers->render() !!}
@endsection
