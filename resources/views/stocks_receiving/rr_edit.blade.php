@extends('stocks_receiving.rr')
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

    {!! Form::model($StocksReceiving, [ 'url' => 'rr',  'class' => 'form-horizontal'  ]) !!}
    {!! Form::hidden('id', null,[ 'id' => 'id' ]) !!}

    @if( isset( $StocksReceiving->id ) )
    <div class="form-group">
        {!! Form::label('rr_id', 'RR#', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::label('rr_id', str_pad($StocksReceiving->id,7,0,STR_PAD_LEFT), [
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

            @if( isset($StocksReceiving->id) )
                @if ( session('url') )
                    {!! Form::button('Back',[
                    'class' => 'btn btn-default',
                    'onclick' => "window.location.href='".url('rr/'.$StocksReceiving->id.'/edit')."'"
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

            @if( !empty($StocksReceiving->id) )
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
    @elseif( !empty($StocksReceiving->id) )
        <div class="panel panel-default">
            <div class="panel-heading">
                Search
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 form-inline">

                        <div class="form-group col-sm-4">
                            PO #<br/>
                            {!! Form::text('po_id', null, [
                            'class' => 'form-control input-sm',
                            'id' => 'po_id'
                            ]) !!}
                            <input type="button" class="btn btn-default" id="search_btn" value="Search" >
                        </div>
                    </div>

                    {!! Form::open(['url' => 'rr/'.$StocksReceiving->id.'/receivePO', 'class' => 'col-sm-12', 'id' => 'rr_form', 'onkeypress' => 'return event.keyCode != 13;']) !!}


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
                        <th>DATE RECEIVED</th>
                        <th>DOCUMENT NO</th>
                        <th class="text-right">QUANTITY</th>
                        <th class="text-right">COST</th>
                        <th class="text-right">AMOUNT</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($StocksReceiving->details as $Detail)
                        <tr>
                            <td><a href="{{ url("rr/".$Detail->id."/detail/delete") }}"><span
                                            class="glyphicon glyphicon-remove" style="color:#ff0000;"></span></a>
                            </td>
                            <td>{{ $Detail->product->product_name }}</td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach($Detail->serials as $Serial)
                                        <li>{{ $Serial->serial_no }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td> {{ $Detail->date_received }}</td>
                            <td> {{ $Detail->document_no }}</td>
                            <td class="text-right">{{ number_format($Detail->quantity,2) }}</td>
                            <td class="text-right">{{ number_format($Detail->cost,2) }}</td>
                            <td class="text-right">{{ number_format($Detail->amount,2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">{{ number_format($StocksReceiving->details()->sum('quantity'),2) }}</td>
                        <td></td>
                        <td class="text-right">{{ number_format($StocksReceiving->details()->sum('amount'),2) }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    @endif

    <script>

        $("input[name='quantity'], input[name='cost']").keyup(function(){
            computeAmount();
        });

        function computeAmount()
        {
            var quantity = parseFloat($("input[name='quantity']").val());
            var cost = parseFloat($("input[name='cost']").val());
            var amount = quantity * cost;

            if ( isNaN(amount) ) {
                amount = 0;
            }
            $("input[name='amount']").val(amount);
        }

        $('#search_btn').click(searchPO);
        $('#po_id').keyup(function(event){
            if ( event.keyCode == 13 ) {
                searchPO();
            }
        });


        function searchPO()
        {
            var form_data = {
                '_token' : '{{ csrf_token() }}',
                'po_id' : $('#po_id').val(),
                'id' : $('#id').val()
            };

            console.log(form_data);

            $.post("{{ url('/rr/po') }}", form_data, function (data) {
                $('#rr_form').html(data);

                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                });

                $('.quantity, .cost').keyup(function(){
                    var quantity = parseFloat($(this).parent().parent().find('.quantity').val());
                    var cost = parseFloat($(this).parent().parent().find('.cost').val());

                    var amount = parseFloat(numeral(quantity * cost).format('0.00'));

                    $(this).parent().parent().find('.amount').val(amount);

                });


            });
        }

        function appendSerial(event,e)
        {
            if ( $(e).next().length <= 0 ) {
                if ( $(e).val() != '' ) {
                    $(e).parent().append($(e).clone().val(''));
                }
            }

            if ( $(e).val() == '' && $(e).parent().find("input").length > 1 ) {
                $(e).remove();
            }

            if ( event.keyCode == 13 ) {
                $(e).next().focus();
                return false;
            }
        }


    </script>
@endsection