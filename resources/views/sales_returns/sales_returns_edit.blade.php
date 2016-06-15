@extends('sales_returns.sales_returns')
@section('body')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($SalesReturn, [ 'url' => 'sales_returns',  'class' => 'form-horizontal'  ]) !!}
    {!! Form::hidden('id', null,[ 'id' => 'id' ]) !!}

    @if( isset( $SalesReturn->id ) )
    <div class="form-group">
        {!! Form::label('rr_id', 'SR#', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::label(null, str_pad($SalesReturn->id,7,0,STR_PAD_LEFT), [
            'class' => 'control-label'
            ]) !!}
        </div>
    </div>
    @endif

    <div class="form-group">
        {!! Form::label('date', 'Date', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('date', null, [
            'class' => 'form-control',
            'data-provide' => 'datepicker-inline',
            'data-date-format' => 'yyyy-mm-dd',
            'readonly' => 'readonly'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('remarks', 'Remarks', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('remarks', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save',[
            'class' => 'btn btn-primary',
            'name' => 'action'
            ]) !!}

            @if( isset($SalesReturn->id) )
                @if ( session('url') )
                    {!! Form::button('Back',[
                    'class' => 'btn btn-default',
                    'onclick' => "window.location.href='".url('sales_returns/'.$SalesReturn->id.'/edit')."'"
                    ]) !!}
                    {!! Form::button('Print',[
                    'class' => 'btn btn-default',
                    'onclick' => "printIframe('JOframe')"
                    ]) !!}
                @else
                    {!! Form::submit('Print Preview',[
                    'class' => 'btn btn-default',
                    'name' => 'action'
                    ]) !!}
                @endif
            @endif

            @if( !empty($SalesReturn->id) )
                {!! Form::submit('Delete',[
                'class' => 'btn btn-danger',
                'name' => 'action'
                ]) !!}
            @endif

        </div>
    </div>

    {!! Form::close() !!}

    @if( session('url') )
        <iframe id='JOframe' name='JOframe' frameborder='0'
                src='{!! url(session("url")) !!}' width='100%'
                height='500'></iframe>
    @elseif( !empty($SalesReturn->id) )
        <div class="panel panel-default">
            <div class="panel-heading">
                Search
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 form-inline">

                        <div class="form-group col-sm-4">
                            DR #<br/>
                            {!! Form::text('delivery_receipt_id', null, [
                            'class' => 'form-control input-sm',
                            'id' => 'delivery_receipt_id'
                            ]) !!}
                            <input type="button" class="btn btn-default" id="search_btn" value="Search" >
                        </div>
                    </div>

                    {!! Form::open(['url' => 'sales_returns/'.$SalesReturn->id.'/returnProducts', 'class' => 'col-sm-12', 'id' => 'form', 'onkeypress' => 'return event.keyCode != 13;']) !!}


                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="width:4%;"></th>
                        <th>PRODUCT</th>
                        <th>SERIAL NO</th>
                        <th class="text-right">QUANTITY</th>
                        <th class="text-right">COST</th>
                        <th class="text-right">AMOUNT</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($SalesReturn->details as $Detail)
                        <tr>
                            <td><a href="{{ url("sales_returns/".$Detail->id."/detail/delete") }}"><span
                                            class="glyphicon glyphicon-remove" style="color:#ff0000;"></span></a>
                            </td>
                            <td>{{ $Detail->product->product_name }}</td>
                            <td>{{ $Detail->serial_no }}</td>
                            <td class="text-right">{{ number_format($Detail->quantity,2) }}</td>
                            <td class="text-right">{{ number_format($Detail->price,2) }}</td>
                            <td class="text-right">{{ number_format($Detail->amount,2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">{{ number_format($SalesReturn->details()->sum('quantity'),2) }}</td>
                        <td></td>
                        <td class="text-right">{{ number_format($SalesReturn->details()->sum('amount'),2) }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    @endif

    <script>

        $("input[name='quantity'], input[name='price']").keyup(function(){
            computeAmount();
        });

        function computeAmount()
        {
            var quantity = parseFloat($("input[name='quantity']").val());
            var price = parseFloat($("input[name='price']").val());
            var amount = quantity * price;

            if ( isNaN(amount) ) {
                amount = 0;
            }
            $("input[name='amount']").val(amount);
        }

        $('#search_btn').click(searchDeliveryReceipt);
        $('#delivery_receipt_id').keyup(function(event){
            if ( event.keyCode == 13 ) {
                searchDeliveryReceipt();
            }
        });


        function searchDeliveryReceipt()
        {
            var form_data = {
                '_token' : '{{ csrf_token() }}',
                'delivery_receipt_id' : $('#delivery_receipt_id').val(),
                'id' : $('#id').val()
            };

            console.log(form_data);

            $.post("{{ url('/sales_returns/delivery_receipt') }}", form_data, function (data) {
                $('#form').html(data);

                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                });

                $('.quantity, .price').keyup(function(){
                    var quantity = parseFloat($(this).parent().parent().find('.quantity').val());
                    var price = parseFloat($(this).parent().parent().find('.price').val());
                    var amount = parseFloat(numeral(quantity * price).format('0.00'));

                    $(this).parent().parent().find('.amount').val(amount);

                });


            });
        }

    </script>
@endsection