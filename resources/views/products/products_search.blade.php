@extends('products.products')
@section('body')
    {!! $Products->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <!-- <th>Category</th> -->
            <th>Unit</th>
            <th>Reorder Level</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Products as $Product)
            <tr onclick="window.location.href='{{ url("/products/$Product->id/edit") }}'">
                <td>{{ $Product->product_code }}</td>
                <td>{{ $Product->product_name }}</td>
                <!-- <td>{{ isset($Product->category->category_name) ? $Product->category->category_name : '-'  }}</td> -->
                <td>{{ $Product->unit }}</td>
                <td>{{ number_format($Product->reorder_level,2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $Products->render() !!}
@endsection
