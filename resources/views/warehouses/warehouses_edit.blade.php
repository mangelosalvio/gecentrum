@extends('warehouses.warehouses')
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

    {!! Form::model($Warehouse, [ 'url' => 'warehouses',  'class' => 'form-horizontal'  ]) !!}
    {!! Form::hidden('id', null) !!}

    <div class="form-group">
        {!! Form::label('warehouse_code', 'Warehouse Code', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('warehouse_code', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('warehouse_name', 'Warehouse Name', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('warehouse_name', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <label>
                {!! Form::checkbox('is_main_warehouse',1) !!}
                Main Warehouse
            </label>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save',[
                'class' => 'btn btn-primary',
                'name' => 'action'
            ]) !!}

            @if( !empty($Warehouse->id) )
                {!! Form::submit('Delete',[
                'class' => 'btn btn-danger',
                'name' => 'action'
                ]) !!}
            @endif

        </div>
    </div>



    {!! Form::close() !!}
@endsection