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
        @forelse($data as $index => $event)
            <tr>
                <td> {{ $index + 1 }} </td>
                <td> {{ $event['category'] == 'c' ? 'Conference' : 'Webinar' }} </td>
                <td> {{ $event['title'] }} </td>
                <td> {{ $event['unique_id'] }} </td>
                <td> {{ $event['location'] }} </td>
                <td> {{ $event['ordinary_member_price'] }} </td>
                <td> {{ $event['trainee_member_price'] }} </td>
                <td> {{ $event['associate_member_price'] }} </td>
                <td> {{ $event['is_published'] ? 'Published' : 'Not Published' }} </td>
                <td> {{ date('d M, Y', strtotime($event['date'])) }} </td>
            </tr>
        @empty
            <tr>No Events Yet!!</tr>
        @endforelse
        </tbody>
    </table>

@endsection