@extends('purchase_returns.purchase_returns')
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

    {!! Form::model($PurchaseReturns, [ 'url' => '/purchase_returns',  'class' => 'form-horizontal'  ]) !!}
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
        {!! Form::label('invoice_no', 'Invoice No', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('invoice_no', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('warehouse_id', 'Warehouse', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::select('warehouse_id', $MainWarehouses, null, [
            'placeholder' => 'Select Main Warehouse',
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

            @if( !empty($PurchaseReturns->id) )
                {!! Form::submit('Delete',[
                'class' => 'btn btn-danger',
                'name' => 'action'
                ]) !!}
            @endif

        </div>
    </div>

    {!! Form::close() !!}


    @if( !empty($PurchaseReturns->id) )
        <div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::open(['url' => '/purchase_returns/'.$PurchaseReturns->id, 'class' => 'form-inline']) !!}

                        <div class="form-group">
                            Product <br/>
                            {!! Form::select('product_id', $Products, null, [
                            'placeholder' => 'Select Product',
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

                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="width:4%;"></th>
                            <th>PRODUCT</th>
                            <th class="text-right">QUANTITY</th>
                            <th class="text-right">COST</th>
                            <th class="text-right">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($PurchaseReturns->details as $Detail)
                            <tr>
                                <td><a href="{{ url("/purchase_returns/".$Detail->id."/detail/delete") }}"><span
                                                class="glyphicon glyphicon-remove" style="color:#ff0000;"></span></a>
                                </td>
                                <td>{{ $Detail->product->product_name }}</td>
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
                            <td class="text-right">{{ number_format($PurchaseReturns->details()->sum('quantity'),2) }}</td>
                            <td></td>
                            <td class="text-right">{{ number_format($PurchaseReturns->details()->sum('amount'),2) }}</td>
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