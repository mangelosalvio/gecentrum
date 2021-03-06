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