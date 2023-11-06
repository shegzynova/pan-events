@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Register For Events'])
        <!-- END: Top Bar -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-small mr-auto float-left">
                Registering for {{$event->title}} at <em>{{ $event->location }}</em> on {{ $event->date }}
            </h2>

            <h2 class="text-lg font-small float-right">
                ₦ <span id="event-price">{{ number_format($event->price) ?? number_format(session('purchase')['event_price']) }}</span>
            </h2>
        </div>

        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                    {{ $error }}
                </div>
            @endforeach
        @endif

        <div class="intro-y box py-10 sm:py-20 mt-5">
            <div class="relative before:hidden before:lg:block before:absolute before:w-[69%] before:h-[3px] before:top-0 before:bottom-0 before:mt-4 before:bg-slate-100 before:dark:bg-darkmode-400 flex flex-col lg:flex-row justify-center px-5 sm:px-20">

                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">1</button>
                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Setup User Details</div>
                </div>
                <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                    <button class="w-10 h-10 rounded-full btn btn-primary">2</button>
                    <div class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto">Accommodation</div>
                </div>
                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">3</button>
                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Details Page</div>
                </div>
                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">4</button>
                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Finalize and Pay</div>
                </div>
            </div>
            <form method="POST" action="{{ route('user.events.step_two_post', $event->id) }}" enctype="multipart/form-data" id="eventForm">
                @csrf
                @method('POST')
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-10">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div class="intro-y box p-5">
                                <div class="flex">
                                    @php
                                        $user = auth()->user();
                                    @endphp
                                    <div class="flex-1 mt-3 ">
                                        <label for="title" class="form-label">Select Hotel</label>
                                        <select required class="tom-select w-full" name="hotel_id" id="title">
                                            <option disabled selected>Select Hotel</option>
                                            @foreach($hotels AS $hotel)
                                                <option value="{{$hotel->id}}" >{{ $hotel->name }} -- Remaining {{ $hotel->no_rooms_available }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="flex">
                                    @php
                                        $user = auth()->user();
                                    @endphp
                                    <div class="flex-1 mt-3 ">
                                        <label for="title" class="form-label">Quantity</label>
                                        <select required class="tom-select w-full" name="quantity" id="title">
                                            <option disabled selected>Select Quantity</option>
                                            <option value="1" >1</option>
                                            <option value="2" >2</option>
                                            <option value="3" >3</option>
                                            <option value="4" >4</option>
                                            <option value="5" >5</option>
                                            <option value="6" >6</option>
                                            <option value="7" >7</option>
                                            <option value="8" >8</option>
                                            <option value="9" >9</option>
                                            <option value="10" >10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-right mt-5">
                                    <button class="btn btn-primary w-64">Start Registration</button>
                                </div>

                            </div>
                        </div>
                        <!-- END: Form Layout -->
                    </div>

                </div>
            </form>
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

