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
        @forelse($data as $index => $transaction)
            <tr>
                <td> {{ $index + 1 }} </td>
                <td> {{ optional(optional($transaction)->event)->title }} </td>
                <td> {{ optional(optional($transaction)->user)->full_name }} </td>
                <td> {{ number_format($transaction->amount) }} </td>
                <td>
                    @if($transaction->status == 'pending')
                        Pending
                    @elseif($transaction->status == 'failed')
                        Failed
                    @else
                        Success
                    @endif
                </td>
                <td>{{ $transaction->transaction_reference }}</td>
                <td> {{ $transaction->payment_method == 'card' ? 'Card Payment' : 'Bank Transfer/Online Payment' }} </td>
                <td> {{ date('d M, Y', strtotime($transaction->created_at)) }} </td>
            </tr>
        @empty
            <tr>No Events Yet!!</tr>
        @endforelse
        </tbody>
    </table>

@endsection