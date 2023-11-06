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
                <td> {{ optional(optional($each)->user)->full_name }} </td>
                <td> {{ optional(optional($each)->event)->title }} </td>
                <td>{{ $each->gender }}</td>
                <td> {{ $each->nature_practice }} </td>
                <td> {{ $each->institution }} </td>
                <td>{{ $each->city }}</td>
                <td>{{ optional(optional($each)->state_name)->name }}</td>
                <td>{{ optional(optional($each)->country)->name }}</td>
                <td> {{ $each->paid ? 'Paid' : 'Not Paid' }} </td>
                <td>{{ $each->payment_ref }}</td>
                <td> {{ $each->payment_type }} </td>
            </tr>
        @empty
            <tr>No Events Yet!!</tr>
        @endforelse
        </tbody>
    </table>

@endsection