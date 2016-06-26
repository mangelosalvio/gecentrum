@extends('reports.master')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                GC Appliance Centrum <br/>
                <small>Inventory Balance Report <br/> as of {{ $date }}</small>
            </h3>
        </div>

        <div class="col-sm-12">
            @if( isset($Products) )
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th class="text-right">Reorder Level</th>
                            <th class="text-right">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Products as $Product)
                            <tr>
                                <td>{{ $Product->product_code }}</td>
                                <td>{{ $Product->product_name }}</td>
                                <td class="text-right">{{ number_format($Product->reorder_level,2) }}</td>
                                <td class="text-right">{{ number_format($Product->balance,2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            @endif

        </div>

    </div>

@endsection