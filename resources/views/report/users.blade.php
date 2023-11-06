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
                <td> {{ $each->first_name }} </td>
                <td> {{ $each->last_name }} </td>
                <td> {{ $each->username }} </td>
                <td> {{ $each->phone }} </td>
                <td>{{ $each->email }}</td>
                <td> {{ ucwords(str_replace('_',' ',  $each->user_type)) }} </td>
            </tr>
        @empty
            <tr>No Events Yet!!</tr>
        @endforelse
        </tbody>
    </table>

@endsection