{!! Form::token(); !!}
{!! Form::hidden('id', $StocksReceiving->id) !!}
<table class="table">
    <thead>
    <th>PRODUCT</th>
    <th>SERIAL NO.</th>
    <th>DATE RECEIVED</th>
    <th>DOCUMENT NO</th>
    <th>QUANTITY</th>
    <th>COST</th>
    <th>AMOUNT</th>
    </thead>
    <tbody>
    @foreach($PO->details as $PODetail)
        <tr>
            <td>
                {{ $PODetail->product->product_name }}
                <input type="hidden" name="arr_product_id[]" value="{{ $PODetail->product_id }}">
                <input type="hidden" name="arr_po_detail_id[]" value="{{ $PODetail->id}}">
                <input type="hidden" name="arr_serial_count[]" value="{{ $PODetail->product->has_serial_no }}">
            </td>
            <td>
                @if ( $PODetail->product->has_serial_no )
                <input type="text" name="arr_serial_no[{{ "po".$PODetail->id }}][]" class="form-control" onkeyup="appendSerial(event,this);" style="margin-bottom: 5px;" onclick="this.select();">
                @endif
            </td>
            <td>
                <input type="text" name="arr_date_received[]" value="" class="form-control datepicker" >
            </td>
            <td>
                <input type="text" name="arr_document_no[]" value="" class="form-control" >
            </td>
            <td>
                <input type="text" name="arr_quantity[]" value="{{ $PODetail->quantity }}" class="form-control text-right quantity" onclick="this.select();">
            </td>
            <td>
                <input type="text" name="arr_cost[]" class="form-control text-right cost" value="{{ $PODetail->cost }}" onclick="this.select();">
            </td>
            <td>
                <input type="text" name="arr_amount[]" class="form-control text-right amount" value="{{ round($PODetail->quantity * $PODetail->cost, 2) }}">
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div>
    <input type="submit" value="Add" class="btn btn-primary">
</div>