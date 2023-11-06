@extends('user.layouts.app')

@section('content')
{{--{{dd($event)}}--}}
    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Register For Events'])
        <!-- END: Top Bar -->
{{--        <div class="intro-y flex items-center mt-8">--}}
{{--            <h2 class="text-lg font-small mr-auto float-left">--}}
{{--                Registering for {{$event->title}} at <em>{{ $event->location }}</em> on {{ $event->date }}--}}
{{--            </h2>--}}

{{--            <h2 class="text-lg font-small float-right">--}}
{{--                ₦ <span id="event-price">{{ number_format(optional($event)->price) ?? number_format(session('purchase')['event_price']) }}</span>--}}
{{--            </h2>--}}
{{--        </div>--}}

        <p class="mt-4">
            {{--<a href="{{ route('user.events.step_two', $event->id) }}" class="btn btn-secondary-soft w-32">BACK</a>--}}
            <a href="{{ route('user.events.register.exhibition_get', $event->id) }}" class="btn btn-secondary-soft w-32">BACK</a>
        </p>
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                    {{ $error }}
                </div>
            @endforeach
        @endif

        @if( !is_null( session('error') ) || isset($error) )
            <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                {{ session('error') ?? $error ?? '' }}
            </div>
        @endif

{{--        <div class="intro-y box py-10 sm:py-20 mt-5">--}}
{{--            <div class="relative before:hidden before:lg:block before:absolute before:w-[69%] before:h-[3px] before:top-0 before:bottom-0 before:mt-4 before:bg-slate-100 before:dark:bg-darkmode-400 flex flex-col lg:flex-row justify-center px-5 sm:px-20">--}}

{{--                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">--}}
{{--                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">1</button>--}}
{{--                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Setup User Details</div>--}}
{{--                </div>--}}
{{--                <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">--}}
{{--                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">3</button>--}}
{{--                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Accommodation</div>--}}
{{--                </div>--}}
{{--                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">--}}
{{--                    <button class="w-10 h-10 rounded-full btn btn-primary">3</button>--}}
{{--                    <div class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto">Details Page</div>--}}
{{--                </div>--}}
{{--                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">--}}
{{--                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">4</button>--}}
{{--                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Finalize and Pay</div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}

        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Details of {{$event->title}} at <em>{{ $event->location }}</em> on {{ $event->date }}
            </h2>
{{--            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">--}}
{{--                <button class="btn btn-primary shadow-md mr-2">Print</button>--}}
{{--                <div class="dropdown ml-auto sm:ml-0">--}}
{{--                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">--}}
{{--                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>--}}
{{--                    </button>--}}
{{--                    <div class="dropdown-menu w-40">--}}
{{--                        <div class="dropdown-content">--}}
{{--                            <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export Word </a>--}}
{{--                            <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export PDF </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        @php
            $data = $purchase;
            $event_price = $data['event_price'];
            $exhibition = $hotel_price = 0;
            $isReserved = false;
            if(array_key_exists('hotel', $data)){
                $hotel_price = $data['hotel']['price'] * $data['hotel']['quantity'];
                $isReserved = $data['hotel']['reserved'];
            }

            if(array_key_exists('exhibition', $data)){
                $exhibition = optional($data)['exhibition'];
            }



            $total_price = $event_price + ($isReserved ? 0 : $hotel_price) + ( optional($data)['exhibition_total_price'] ?? 0 );
            $data['total_price'] =  $total_price;
            $qrcode = $purchase['attendance']['id'];

            session(['purchase' => $data]);
        @endphp
        <!-- BEGIN: Invoice -->
        <div class="intro-y box overflow-hidden mt-5">
            <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
                <div class="font-semibold text-primary text-3xl">ORDER DETAILS</div>
                <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                    <div class="text-xl text-primary font-medium">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                    <div class="mt-1">{{auth()->user()->email}}</div>
                    @php
                        echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG(str($qrcode), 'QRCODE') . '" alt="barcode" style="float: right;"   />';
                    @endphp
                </div>
            </div>
            <div class="px-5 sm:px-16 sm:py-10">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">PRICE</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td class="border-b dark:border-darkmode-400">
                                <div class="font-medium whitespace-nowrap">Event</div>
                                <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">{{optional(optional($data)['event'])['title']}}</div>
                            </td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">1</td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">{{ $event_price }}</td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">{{ $event_price }}</td>
                        </tr>
                        @if(!is_null(optional($data)['hotel']))
                        <tr>
                            <td class="border-b dark:border-darkmode-400">
                                <div class="font-medium whitespace-nowrap">Hotel <span class="text-red-500">{{ $isReserved ? "Reserved" : "" }}</span></div>
                                <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">{{ $data['hotel']['name'] }} </div>
                            </td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">{{ $data['hotel']['quantity'] }}</td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">{{ $data['hotel']['price'] }}</td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">{{ $hotel_price }}</td>
                        </tr>
                        @endif
                        @if(!is_null(optional($data)['exhibitions']))
                            @foreach(optional($data)['exhibitions'] AS $exhibition)
                                <tr>
                                    <td class="border-b dark:border-darkmode-400">
                                        <div class="font-medium whitespace-nowrap">{{ $exhibition->description }} -- Exhibition</div>
                                        <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">{{ $exhibition->category }}</div>
                                    </td>
                                    <td class="text-right border-b dark:border-darkmode-400 w-32">1</td>
                                    <td class="text-right border-b dark:border-darkmode-400 w-32">{{ $exhibition->amount }}</td>
                                    <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">{{ $exhibition->amount }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="px-5 sm:px-20 pb-10 sm:pb-20 sm:pt-20 flex flex-col-reverse sm:flex-row">
                <div class="text-center sm:text-left mt-10 sm:mt-0">
                    <div class="text-base text-slate-500 mb-6">Payment Methods</div>
                    <div class="mt-1"><img width="200px" src="{{ asset('dist/images/1600px-Paystack_Logo.png') }}"></div>
                    <div class="text-left mt-5">
                        <!-- Wrap the button in a form element with POST method -->
                        <form action="{{ route('user.startPayment') }}" method="POST">
                            @csrf <!-- Add CSRF token for security -->
                            <button type="submit" class="btn btn-primary w-64">PAY VIA CARD</button>
                        </form>
                    </div>
                    <div class="mt-5"><img width="200px" src="{{ asset('dist/images/bank.png') }}">
                        <h2 class="font-semibold text-2xl mt-4">Bank Details</h2>
                        <p>Bank Name: {{ config('pan.bank_name') }}</p>
                        <p>Account No: {{ config('pan.account_number') }}</p>
                        <p>Account Name: {{ config('pan.account_name') }}</p>
                    </div>
                    <div class="text-left mt-5">
                        <!-- Wrap the button in a form element with POST method -->
                        <form action="{{ route('user.bankTransfer') }}" method="POST">
                            @csrf <!-- Add CSRF token for security -->
                            <button type="submit" class="btn btn-primary w-64">PAY VIA BANK TRANSFER</button>
                        </form>


                    </div>
                </div>
                <div class="text-center sm:text-right sm:ml-auto">
                    <div class="text-base text-slate-500">Total Amount</div>
                    <div class="text-xl text-primary font-medium mt-2">₦{{ number_format($total_price) }}</div>
                </div>
            </div>



        </div>


    </div>

@endsection


@section('scripts')
    <script>
        function updateEventPrice(selectedOption) {
            var price = "Error";

            if (selectedOption === "regular") {
                price = 100; // Set the price for Regular registration
            } else if (selectedOption === "exhibition") {
                price = 150; // Set the price for Exhibition registration
            } else if (selectedOption === "speaker") {
                price = 200; // Set the price for Speaker registration
            }

            $("#event-price").text(price);
        }

    </script>
@endsection

