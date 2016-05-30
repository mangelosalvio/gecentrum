@extends('suppliers.suppliers')
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

    {!! Form::model($Supplier, [ 'url' => 'suppliers',  'class' => 'form-horizontal'  ]) !!}
    {!! Form::hidden('id', null) !!}

    <div class="form-group">
        {!! Form::label('supplier_code', 'Supplier Code', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('supplier_code', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('supplier_name', 'Supplier Name', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('supplier_name', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('address', 'Address', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('address', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('contact_person', 'Contact Person', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('contact_person', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('email_address', 'Email Address', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('email_address', null, [
            'class' => 'form-control'
            ]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('contact_no', 'Contact No.', [
        'class' => 'col-sm-2 control-label'
        ]) !!}
        <div class="col-sm-10">
            {!! Form::text('contact_no', null, [
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

            @if( !empty($Supplier->id) )
                {!! Form::submit('Delete',[
                'class' => 'btn btn-danger',
                'name' => 'action'
                ]) !!}
            @endif

        </div>
    </div>

    {!! Form::close() !!}
@endsection