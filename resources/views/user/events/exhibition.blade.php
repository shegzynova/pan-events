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
                ₦ <span id="event-price">{{ number_format(session('purchase')['event_price']) }}</span>
            </h2>
        </div>

        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"><i data-lucide="alert-triangle"
                                                                                            class="w-6 h-6 mr-2"></i>
                    {{ $error }}
                </div>
            @endforeach
        @endif

        @if( !is_null( session('error') ) || isset($error) )
            <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                {{ session('error') ?? $error ?? '' }}
            </div>
        @endif

        <div class="intro-y box py-10 sm:py-20 mt-5">
            {{--@include('admin.layouts.sections', ['page' => 4])--}}
            @include('admin.layouts.sections', ['page' => 3])
            <form method="POST" action="{{ route('user.events.register.exhibition_post', $event->id) }}"
                  enctype="multipart/form-data" id="eventForm">
                @csrf
                @method('POST')
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-10">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div class="intro-y box p-5">

                                <div class="flex mb-5">
                                    <div class="flex-1 mt-3">
                                        <label for="title" class="form-label">Please select exhibition(s)</label>
{{--                                        <select class="tom-select w-full" name="exhibition" id="title">--}}
{{--                                            <option value="" selected>Select Exhibition</option>--}}
{{--                                            @foreach($exhibitions AS $exhibition)--}}
{{--                                                <option value="{{$exhibition->id}}">{{ $exhibition->description }} ----}}
{{--                                                    ₦{{ number_format($exhibition->amount) }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
                                        <select data-placeholder="Select Exhibitions" class="tom-select w-full" name="exhibition[]"
                                                multiple>
                                            @foreach($exhibition_types AS $type)
                                                <optgroup label="{{ $type->type }}">
                                                    @foreach($type->exhibitions AS $exhibition)
                                                        <option value="{{ $exhibition->id }}" {{ in_array($exhibition->id, $exhibitionIds) ? 'selected' : '' }}>{{ $exhibition->category }} - {{ $exhibition->description }} - ₦{{ number_format($exhibition->amount) }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <div class="text-right mt-5">
                                    <a class="btn btn-secondary w-64" href="{{ route('user.events.step_two', $event->id) }}">Previous</a>
                                    <button class="btn btn-primary w-64 mt-2">Continue</button>
                                    <a href="{{ route('user.events.register.final_get', $event->id) }}"
                                       class="btn btn-danger-soft w-32 mt-2">Skip</a>
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

