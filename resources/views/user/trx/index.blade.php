@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Transactions'])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Transactions
        </h2>
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"><i data-lucide="alert-triangle"
                                                                                            class="w-6 h-6 mr-2"></i>
                    {{ $error }}
                </div>
            @endforeach
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x"
                                                                                                      class="w-4 h-4"></i>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x"
                                                                                                      class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    @if( $transactions->count() > 0 )
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">S/N</th>
                        <th class="whitespace-nowrap">Event</th>
                        <th class="whitespace-nowrap">Amount</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Transaction Reference</th>
                        <th class="whitespace-nowrap">Payment Method</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @endif
                    <tbody>

                    @forelse($transactions as $index => $transaction)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            <td> {{ $transaction->event->title }} </td>
                            <td> ₦{{ number_format($transaction->amount, 2) }} </td>
                            <td>
                                @if($transaction->status == 'pending')
                                    <button class="btn btn-rounded btn-pending-soft w-24 mr-1 mb-2">Pending</button>
                                @elseif($transaction->status == 'failed')
                                    <button class="btn btn-rounded btn-danger-soft w-24 mr-1 mb-2">Failed</button>
                                @else
                                    <button class="btn btn-rounded btn-success-soft w-24 mr-1 mb-2">Success</button>
                                @endif
                            </td>
                            <td> {{ $transaction->transaction_reference }} </td>
                            <td> {{ $transaction->payment_method == 'card' ? 'Card Payment' : 'Bank Transfer/Online Payment' }} </td>
                            <td>
                                @if( $transaction->status != 'successful' )
                                <a href="{{ route('user.startManualPayment', $transaction->id) }}"
                                   class='btn btn-default btn-primary btn-xs mr-2'>MAKE PAYMENT
                                </a>
                                @else
                                    <a href="{{ route('user.download-receipt', $transaction->id) }}" target="_blank"
                                       class='btn btn-default btn-primary btn-xs mr-2'>Download Receipt
                                    </a>
                                @endif
                            </td>
                        </tr>


                    @empty
                        <tr>No Transaction Yet!!</tr>
                    @endforelse

                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#post-form-5').on('change', function() {
                if ($(this).prop('checked')) {
                    console.log('Checkbox is checked');
                } else {
                    console.log('Checkbox is not checked');
                }
            });
        });

    </script>
@endsection