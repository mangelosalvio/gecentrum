@extends('layouts.app')
@section('content')
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

                                @if ( isset($url) )
                                    {!! Form::button('Print',[
                                    'class' => 'btn btn-default',
                                    'onclick' => "printIframe('JOframe')"
                                    ]) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                    @if( isset($url) )
                        <div class="row">
                            <iframe id='JOframe' name='JOframe' frameborder='0'
                                    src='{!! $url !!}' width='100%'
                                    height='500'></iframe>
                        </div>
                    @endif




                </div>
            </div>
        </div>
    </div>
    @include('scripts.product_ac')
@endsection