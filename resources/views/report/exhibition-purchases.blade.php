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
                <td>{{ optional($each->exhibition)->description }} - {{ optional($each->exhibition)->category }} ({{ optional(optional($each->exhibition)->type)->type }})</td>
                <td>{{ $each->attendance->first_name }} {{ $each->attendance->surname }}</td>
                <td>
                    @if($each->paid == 'paid') Paid @else Not Paid @endif
                </td>
            </tr>
        @empty
            <tr>No Events Yet!!</tr>
        @endforelse
        </tbody>
    </table>

@endsection