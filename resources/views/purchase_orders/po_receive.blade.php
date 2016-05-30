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

    {!! Form::open([ 'url' => 'po/'.$PO->id.'/receive',  'class' => 'form-horizontal'  ]) !!}
    {!! Form::hidden('id', null) !!}

    <div class="form-group">
        <div class="col-sm-12">
            <h4>Receive items from <b>PO# {{ $PO->id }}</b></h4>
        </div>

    </div>

    <div class="form-group">
        {!! Form::label('po_id', 'PO #', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('po_id', $PO->id, [
            'class' => 'form-control',
            'readonly' => 'readonly'
            ]) !!}
        </div>
    </div>

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
            {!! Form::select('supplier_id', $Suppliers, $PO->supplier_id, [
            'placeholder' => 'Select a Supplier',
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('invoice_no', 'Invoice No.', [
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
            <a href="{{ url("/po/$PO->id/edit") }}" class="btn btn-default">Back</a>
        </div>
    </div>




    @if( !empty($PO->id) )
        <div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
            <div class="panel-body">
                <div class="row">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th class="text-right">QUANTITY</th>
                            <th class="text-right">COST</th>
                            <th class="text-right">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($PO->details as $Detail)
                            <tr>
                                <td>
                                    {{ $Detail->product->product_name }}
                                    <input type="hidden" name="arr_product_id[]" value="{{ $Detail->product_id }}">
                                </td>
                                <td class="text-right">
                                    <input type="text" class="form-control input-sm" name="arr_quantity[]" value="{{ $Detail->quantity }}" onclick="this.select();" >
                                </td>
                                <td class="text-right">
                                    <input type="text" class="form-control input-sm text-right form-control" name="arr_cost[]" value="{{ $Detail->cost }}" >
                                </td>
                                <td class="text-right">
                                    <input type="text" class="form-control input-sm text-right form-control" name="arr_amount[]" value="{{ $Detail->amount }}" readonly >
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    {!! Form::close() !!}

    <script>

        $("input[name='arr_quantity[]'], input[name='arr_cost[]']").keyup(function(){
            computeAmount(this);
        });

        function computeAmount(e)
        {
            var quantity = parseFloat($(e).parent().parent().find("input[name='arr_quantity[]']").val());
            var cost = parseFloat($(e).parent().parent().find("input[name='arr_cost[]']").val());
            var amount = quantity * cost;

            if ( isNaN(amount) ) {
                amount = 0;
            }

            $(e).parent().parent().find("input[name='arr_amount[]']").val(amount);
        }
    </script>
@endsection