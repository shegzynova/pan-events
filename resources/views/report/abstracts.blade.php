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
                <td>{{ $each->full_name }}</td>
                <td>{{ $each->contact_phone_number }}</td>
                <td>{{ $each->email }}</td>
                <td>{{ $each->no_of_pages }}</td>
                <td>{{ $each->abstract_title }}</td>
                <td>{{ $each->duration }}</td>
                <td>
                    @if($each->status == 'p')Pending
                    @elseif($each->status == 'a')Approved
                    @else Declined
                    @endif
                </td>
                <td>
                    @if($each->full_paper_status == 'p')Pending
                    @elseif($each->full_paper_status == 'a')Approved
                    @else Declined
                    @endif
                </td>
                <td>
                    @if($each->presentation_status == 'p')Pending
                    @elseif($each->presentation_status == 'a')Approved
                    @else Declined
                    @endif
                </td>
            </tr>
        @empty
            <tr>No Abstract Yet!!</tr>
        @endforelse
        </tbody>
    </table>

@endsection