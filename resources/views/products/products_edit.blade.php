@extends('products.products')
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

    {!! Form::model($Product, [ 'url' => 'products',  'class' => 'form-horizontal'  ]) !!}
    {!! Form::hidden('id', null) !!}
    <div class="form-group">
        {!! Form::label('product_code', 'Product Code', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('product_code', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('product_name', 'Model', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('product_name', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <!-- <div class="form-group">
        {!! Form::label('category_id', 'Category', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::select('category_id', $Categories, null, [
                'placeholder' => 'Select a Category',
                'class' => 'form-control'
            ]) !!}

        </div>
    </div> -->

    <div class="form-group">
        {!! Form::label('unit', 'Unit', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('unit', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('reorder_level', 'Reoreder Level', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('reorder_level', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('has_serial_no',1) !!} Has Serial
                </label>
            </div>
        </div>

    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save',[
                'class' => 'btn btn-primary',
                'name' => 'action'
            ]) !!}

            @if( !empty($Product->id) )
                {!! Form::submit('Delete',[
                'class' => 'btn btn-danger',
                'name' => 'action'
                ]) !!}
            @endif

        </div>
    </div>


    {!! Form::close() !!}
@endsection