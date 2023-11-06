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
                <td>{{ optional(optional($each)->hotel)->name }}</td>
                <td>{{ $each->user->first_name }} {{ $each->user->last_name }}</td>
                <td>{{ optional($each->event)->title }}</td>
                <td>{{ $each->quantity }}</td>
                <td>
                    @if($each->isPaid) Paid @else Reserved @endif
                </td>
            </tr>
        @empty
            <tr>No Events Yet!!</tr>
        @endforelse
        </tbody>
    </table>

@endsection