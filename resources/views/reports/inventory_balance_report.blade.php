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
                    Inventory Balance Report
                </div>
                <div class="panel-body">
                    {!! Form::open([ 'url' => '/reports/inventory-balance-report',  'class' => 'form-horizontal', 'method' => 'GET'  ]) !!}
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('date', 'Date', [
                            'class' => 'col-sm-2 control-label'
                            ]) !!}
                            <div class="col-sm-8">
                                {!! Form::text('date', $date , [
                                'class' => 'form-control',
                                'data-provide' => 'datepicker-inline',
                                'data-date-format' => 'yyyy-mm-dd',
                                'readonly' => 'readonly'
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('warehouse_id', 'Warehouse', [
                            'class' => 'col-sm-2 control-label'
                            ]) !!}
                            <div class="col-sm-8">
                                {!! Form::select('warehouse_id', $Warehouses, $warehouse_id, [
                                'placeholder' => 'Select Warehouse',
                                'class' => 'form-control'
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

                    @if( isset($Products) )
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th class="text-right">Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Products as $Product)
                                <tr>
                                    <td>{{ $Product->product_code }}</td>
                                    <td>{{ $Product->product_name }}</td>
                                    <td class="text-right">{{ number_format($Product->balance,2) }}</td>
                                </tr>
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