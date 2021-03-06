@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-6" style="margin-bottom: 20px;">
                {!! Form::open([
                    'url' => '/categories',
                    'method' => 'get'
                ]) !!}
                <div class="input-group">

                    <input type="text" class="form-control" name="search" placeholder="Search for...">
                    <span class="input-group-btn">
                        {!! Form::submit('Search', [
                            'class' => 'btn btn-default'
                        ]) !!}
                    </span>
                </div><!-- /input-group -->
                {!! Form::close() !!}
            </div>
            <div class="col-md-1">
                <a href="{{ url('/categories/create') }}" class="btn btn-default form-control">New</a>
            </div>
        </div>

        @if( session('status') )
        <div class="row">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session('status') }}
            </div>
        </div>
        @endif

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Categories
                </div>
                <div class="panel-body">
                    @yield('body')
                </div>
            </div>
        </div>
    </div>
@endsection