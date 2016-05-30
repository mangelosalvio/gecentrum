@extends('categories.categories')
@section('body')
    {!! $Categories->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Category Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Categories as $Category)
            <tr onclick="window.location.href='{{ url("/categories/$Category->id/edit") }}'">
                <td>{{ $Category->category_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $Categories->render() !!}
@endsection
