@extends('report.layout')

@section('content')

    <h3>{{ $title }}</h3>
    <table style="min-width: 100% !important;">
        <thead>
        <tr>
        <tr>
            @foreach($headers AS $header)
                <th class="whitespace-nowrap">{{ $header }}</th>
            @endforeach
        </tr>
        </tr>
        </thead>
        <tbody>
        @forelse($data as $index => $each)
            <tr>
                <td> {{ $index + 1 }} </td>
                <td>{{ $each->category }}</td>
                <td>{{ number_format($each->amount) }}</td>
                <td>{{ $each->description }}</td>
                <td>{{ optional(optional($each)->type)->type }}</td>
            </tr>
        @empty
            <tr>No Events Yet!!</tr>
        @endforelse
        </tbody>
    </table>

@endsection