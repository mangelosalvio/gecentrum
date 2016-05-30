@extends('layouts.app')
@section('content')
    <div class="container">
        @if( session('status') )
            <div class="row">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Purchase Return History
                </div>
                <div class="panel-body">
                    {!! Form::open([ 'url' => '/reports/purchase-return-history',  'class' => 'form-horizontal', 'method' => 'GET'  ]) !!}
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('from_date', 'From Date', [
                            'class' => 'col-sm-2 control-label'
                            ]) !!}
                            <div class="col-sm-8">
                                {!! Form::text('from_date', $from_date , [
                                'class' => 'form-control',
                                'data-provide' => 'datepicker-inline',
                                'data-date-format' => 'yyyy-mm-dd',
                                'data-todayhighlight' => 'true',
                                'readonly' => 'readonly'
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('to_date', 'To Date', [
                            'class' => 'col-sm-2 control-label'
                            ]) !!}
                            <div class="col-sm-8">
                                {!! Form::text('to_date', $to_date , [
                                'class' => 'form-control',
                                'data-provide' => 'datepicker-inline',
                                'data-date-format' => 'yyyy-mm-dd',
                                'readonly' => 'readonly'
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                {!! Form::submit('Search', [
                                    'class' => 'btn btn-primary'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                    @if( isset($PurchaseReturns) )
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>PR#</th>
                                <th>Supplier</th>
                                <th>Warehouse</th>
                                <th>Product</th>
                                <th class="text-right">Cost</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($PurchaseReturns as $PurchaseReturn)
                                @foreach($PurchaseReturn->products as $Product)
                                    <tr>
                                        <td>{{ $PurchaseReturn->date }}</td>
                                        <td>{{ str_pad($PurchaseReturn->id,7,0,STR_PAD_LEFT) }}</td>
                                        <td>{{ $PurchaseReturn->supplier->supplier_name }}</td>
                                        <td>{{ $PurchaseReturn->warehouse->warehouse_name }}</td>
                                        <td>{{ $Product->product_name }}</td>
                                        <td class="text-right">{{ $Product->pivot->quantity }}</td>
                                        <td class="text-right">{{ $Product->pivot->cost }}</td>
                                        <td class="text-right">{{ $Product->pivot->amount }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
    @include('scripts.product_ac')
@endsection