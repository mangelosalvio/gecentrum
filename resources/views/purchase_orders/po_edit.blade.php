@extends('purchase_orders.po')
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

    {!! Form::model($PO, [ 'url' => 'po',  'class' => 'form-horizontal'  ]) !!}
    {!! Form::hidden('id', null) !!}
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
        {!! Form::label('supplier_id', 'Supplier', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::select('supplier_id', $Suppliers, null, [
            'placeholder' => 'Select a Supplier',
            'class' => 'form-control'
            ]) !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('unit', 'Remarks', [
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

            @if( isset($PO->id) )
                @if ( session('url') )
                    {!! Form::button('Back',[
                    'class' => 'btn btn-default',
                    'onclick' => "window.location.href='".url('po/'.$PO->id.'/edit')."'"
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

            <!--
            @if ( $PO->status != 'X' )
                {!! Form::submit('Close',[
                'class' => 'btn btn-info',
                'name' => 'action'
                ]) !!}
            @endif
            -->

            @if( !empty($PO->id) )
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
    @elseif( !empty($PO->id) )
        <div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
            <div class="panel-body">

                <div class="row">
                    @if ( $PO->status != 'X' )
                        <div class="col-sm-12">
                            {!! Form::open(['url' => 'po/'.$PO->id, 'class' => 'form-inline']) !!}

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
                                Qty<br/>
                                {!! Form::text('quantity', null, [
                                'class' => 'form-control input-sm'
                                ]) !!}
                            </div>

                            <div class="form-group">
                                Cost<br/>
                                {!! Form::text('cost', null, [
                                'class' => 'form-control input-sm'
                                ]) !!}
                            </div>

                            <div class="form-group">
                                Amount<br/>
                                {!! Form::text('amount', null, [
                                'class' => 'form-control input-sm',
                                'readonly' => 'readonly'
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
                    @endif
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="width:4%;"></th>
                            <th>PRODUCT</th>
                            <th class="text-right">PO QTY / RR QTY</th>
                            <th class="text-right">COST</th>
                            <th class="text-right">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($PO->details as $Detail)
                            <tr>
                                <td><a href="{{ url("/po/".$Detail->id."/detail/delete") }}"><span
                                                class="glyphicon glyphicon-remove" style="color:#ff0000;"></span></a>
                                </td>
                                <td>{{ $Detail->product->product_name }}</td>
                                <td class="text-right">
                                    {{ number_format($Detail->quantity,2) }} /
                                    {{ number_format($Detail->rr_qty,2) }}
                                </td>
                                <td class="text-right">{{ number_format($Detail->cost,2) }}</td>
                                <td class="text-right">{{ number_format($Detail->amount,2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right">{{ number_format($PO->details()->sum('quantity'),2) }}</td>
                            <td></td>
                            <td class="text-right">{{ number_format($PO->details()->sum('amount'),2) }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

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
    </script>
@endsection