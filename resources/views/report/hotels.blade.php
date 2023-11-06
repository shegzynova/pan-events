@extends('report.layout')

@section('content')

    <h3>{{ $title }}</h3>
    <style>
        .contact-column {
            max-width: 100px;
        }
    </style>

    <table style="width: 100%; max-width: 100%;">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th class="address-column">Address</th>
            <th>Contact</th>
            <th>Price</th>
            <th>No Rooms Ava</th>
            <th>Event</th>
        </tr>
        </thead>
        <tbody>
        @forelse($data as $index => $hotel)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $hotel['name'] }}</td>
                <td>{{ $hotel['address'] }}</td>
                <td class="contact-column">{{ $hotel['phone_contact'] }}</td>
                <td>{{ number_format($hotel['price']) }}</td>
                <td>{{ $hotel['no_rooms_available'] }}</td>
                <td>{{ optional(optional($hotel)->event)->title }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No Hotels Yet!!</td>
            </tr>
        @endforelse
        </tbody>
    </table>



@endsection