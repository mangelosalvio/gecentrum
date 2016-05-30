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
                    Stock Card Report
                </div>
                <div class="panel-body">
                    {!! Form::open([ 'url' => '/reports/stock-card-report',  'class' => 'form-horizontal', 'method' => 'GET'  ]) !!}
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
                                    'autocomplete' => 'off',
                                    'style' => 'width:500px;'
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


                    <div class="col-sm-12">
                        @if( isset($StocksReceiving) )
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th colspan="3" class="text-center">STOCKS ARRIVAL</th>
                                <th colspan="3" class="text-center">DELIVERY RECEIPTS</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- <tr>
                                <td colspan="5">Balance</td>
                                <td class="text-right">{{ number_format($beg_balance,2) }}</td>
                            </tr> -->
                            @foreach($StocksReceiving as $i => $RR)
                                <?php $c = 0; $d = 0?>
                                @foreach($RR->details as $Detail)
                                    @foreach($Detail->serials as $Serial)
                                        <tr>
                                            @if( $c == 0 && $d == 0)
                                                <td>{{ $RR->date }}</td>
                                                <td>
                                                    {{ $Detail->product->product_name }} <br/>
                                                    <small>#{{ $Detail->document_no }} {{ $Detail->date_received }}</small>
                                                </td>
                                            @elseif( $d > 0 )
                                                <td></td>
                                                <td>
                                                    {{ $Detail->product->product_name }} <br/>
                                                    <small>#{{ $Detail->document_no }} {{ $Detail->date_received }}</small>
                                                </td>
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif

                                            <td class="text-right">{{ $Serial->serial_no }}</td>
                                            <td>{{ isset($Serial->sales) ? $Serial->sales->date : '' }}</td>
                                            <td>{{ isset($Serial->sales) ? str_pad($Serial->sales->id,7,0,STR_PAD_LEFT) : '' }}</td>
                                            <td>{{ isset($Serial->sales) ? $Serial->sales->customer->customer_name : '' }}</td>
                                        </tr>
                                        <?php $c++; ?>
                                    @endforeach
                                    <?php $d++ ?>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                        @if ( isset($StockCard) )
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>TRANSACTION</th>
                                    <th>IN</th>
                                    <th>OUT</th>
                                    <th>BALANCE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4">Balance</td>
                                    <td class="text-right">{{ number_format($beg_balance,2) }}</td>
                                </tr>
                                @foreach($StockCard as $r)
                                    <tr>
                                        <td>{{ $r->date }}</td>
                                        <td>{{ $r->transaction }}</td>
                                        <td class="text-right">{{ number_format($r->in_qty,2) }}</td>
                                        <td class="text-right">{{ number_format($r->out_qty,2) }}</td>
                                        <td class="text-right">{{ number_format($r->balance,2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>



                </div>
            </div>
        </div>
    </div>
    @include('scripts.product_ac')
@endsection