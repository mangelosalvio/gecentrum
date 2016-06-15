{!! Form::token(); !!}
{!! Form::hidden('id', $SalesReturn->id) !!}
<table class="table">
    <thead>
    <th class="text-center">PRODUCT</th>
    <th class="text-center">SERIAL NO.</th>
    <th class="text-center">QUANTITY</th>
    <th class="text-center">PRICE</th>
    <th class="text-center">AMOUNT</th>
    </thead>
    <tbody>
    @foreach($DeliveryReceipt->details as $DeliveryReceiptDetail)
        <tr>
            <td>
                {{ $DeliveryReceiptDetail->product->product_name }}
                <input type="hidden" name="arr_product_id[]" value="{{ $DeliveryReceiptDetail->product_id }}">
                <input type="hidden" name="arr_delivery_receipt_detail_id[]" value="{{ $DeliveryReceiptDetail->id}}">
            </td>
            <td>
                <input type="text" name="arr_serial_no[]" class="form-control" value="{{ $DeliveryReceiptDetail->serial_no }}" readonly>
            </td>
            <td>
                <input type="text" name="arr_quantity[]" class="form-control text-right quantity" onclick="this.select();">
            </td>
            <td>
                <input type="text" name="arr_price[]" class="form-control text-right price" value="{{ $DeliveryReceiptDetail->price }}" onclick="this.select();" readonly>
            </td>
            <td>
                <input type="text" name="arr_amount[]" class="form-control text-right amount" value="{{ round($DeliveryReceiptDetail->quantity * $DeliveryReceiptDetail->price, 2) }}" readonly>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div>
    <input type="submit" value="Add" class="btn btn-primary">
</div>