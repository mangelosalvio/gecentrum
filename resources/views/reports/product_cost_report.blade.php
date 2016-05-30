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
                    Product Cost Report
                </div>
                <div class="panel-body">
                    {!! Form::open([ 'url' => '/reports/product-cost-report',  'class' => 'form-horizontal', 'method' => 'GET'  ]) !!}
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
                            {!! Form::label('product_name', 'Product', [
                            'class' => 'col-sm-2 control-label'
                            ]) !!}
                            <div class="col-sm-8">
                                {!! Form::text('product_name', $product_name, [
                                'class' => 'form-control input-sm typeahead',
                                'id' => 'product_name',
                                'autocomplete' => 'off'
                                ]) !!}
                                {!! Form::hidden('product_id', $product_id, [
                                'class' => 'typeahead',
                                'id' => 'product_id'
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

                    @if( isset($RRs) )
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>RR#</th>
                                <th>Supplier</th>
                                <th class="text-right">Cost</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($RRs as $RR)
                                @foreach($RR->products as $Product)
                                    <tr>
                                        <td>{{ $RR->date }}</td>
                                        <td>{{ str_pad($RR->id,7,0,STR_PAD_LEFT) }}</td>
                                        <td>{{ $RR->supplier->supplier_name }}</td>
                                        <td class="text-right">{{ $Product->pivot->cost }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right" style="font-weight: bold;" colspan="3">Average Costing:</th>
                                <th class="text-right" style="font-weight: bold;">{{ number_format($avg,2) }}</th>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
    @include('scripts.product_ac')
@endsection