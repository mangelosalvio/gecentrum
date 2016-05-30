@extends('physical_counts.physical_counts')
@section('body')
    {!! $PhysicalCounts->render() !!}
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>PC#</th>
            <th>Date</th>
            <th>Warehouse</th>
        </tr>
        </thead>
        <tbody>
        @foreach($PhysicalCounts as $PhysicalCount)
            <tr onclick="window.location.href='{{ url("/physical_counts/$PhysicalCount->id/edit") }}'">
                <td>{{ str_pad($PhysicalCount->id,7,0,STR_PAD_LEFT) }}</td>
                <td>{{ $PhysicalCount->date }}</td>
                <td>{{ $PhysicalCount->warehouse->warehouse_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $PhysicalCounts->render() !!}
@endsection
