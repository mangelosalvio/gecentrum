@extends('delivery_receipts.delivery_receipts')
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

    {!! Form::model($DeliveryReceipt, [ 'url' => '/delivery_receipts',  'class' => 'form-horizontal'  ]) !!}
    {!! Form::hidden('id', null) !!}
    @if( isset( $DeliveryReceipt->id ) )
        <div class="form-group">
            {!! Form::label('dr_id', 'DR#', [
            'class' => 'col-sm-2 control-label'
            ]) !!}
            <div class="col-sm-10">
                {!! Form::label('dr_id', str_pad($DeliveryReceipt->id,7,0,STR_PAD_LEFT), [
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
        {!! Form::label('customer_id', 'Customer', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::select('customer_id', $Customers, null, [
            'placeholder' => 'Select Customer',
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('salesman', 'Salesman', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('salesman', null, [
            'class' => 'form-control'
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

            @if( !empty($DeliveryReceipt->id) )
                {!! Form::submit('Delete',[
                'class' => 'btn btn-danger',
                'name' => 'action'
                ]) !!}
            @endif

        </div>
    </div>

    {!! Form::close() !!}


    @if( !empty($DeliveryReceipt->id) )
        <div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::open(['url' => '/delivery_receipts/'.$DeliveryReceipt->id, 'class' => 'form-inline']) !!}

                        <div class="form-group">
                            Product <br/>
                            {!! Form::text('product_name', null, [
                            'class' => 'form-control input-sm typeahead',
                            'id' => 'product_name',
                            'autocomplete' => 'off',
                            'style' => 'width:400px;'
                            ]) !!}
                            {!! Form::hidden('product_id', null, [
                            'class' => 'typeahead',
                            'id' => 'product_id'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            Serial<br/>
                            {!! Form::text('serial_no', null, [
                            'class' => 'form-control input-sm'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            Qty<br/>
                            {!! Form::text('quantity', null, [
                            'class' => 'form-control input-sm'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            Price<br/>
                            {!! Form::text('price', null, [
                            'class' => 'form-control input-sm'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            Amount<br/>
                            {!! Form::text('amount', null, [
                            'class' => 'form-control input-sm'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <br/>
                            {!! Form::submit('Add', [
                            'class' => 'btn btn-primary form-control'
                            ]) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>

                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="width:4%;"></th>
                            <th>PRODUCT</th>
                            <th>SERIAL NO</th>
                            <th class="text-right">QUANTITY</th>
                            <th class="text-right">PRICE</th>
                            <th class="text-right">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($DeliveryReceipt->details as $Detail)
                            <tr>
                                <td><a href="{{ url("/delivery_receipts/".$Detail->id."/detail/delete") }}"><span
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
                            <td class="text-right">{{ number_format($DeliveryReceipt->details()->sum('quantity'),2) }}</td>
                            <td></td>
                            <td class="text-right">{{ number_format($DeliveryReceipt->details()->sum('amount'),2) }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

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
            var cost = parseFloat($("input[name='price']").val());
            var amount = quantity * cost;

            if ( isNaN(amount) ) {
                amount = 0;
            }
            $("input[name='amount']").val(amount);
        }
    </script>
@endsection