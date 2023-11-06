@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Register For Conferences/Events'])
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

        <div class="intro-y box py-10 sm:py-20 mt-5">
            @include('admin.layouts.sections', ['page' => 3])
            <form method="POST" action="{{ route('user.events.register.abstract_post', $event->id) }}" enctype="multipart/form-data" id="eventForm">
                @csrf
                @method('POST')
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-10">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div class="intro-y box p-5">
                                <h3 class="mb-3">Fill out this section if you're registering as a speaker</h3>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Your Full Name:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3"  name="full_name" type="text" class="form-control" placeholder="John Doe" aria-describedby="input-group-1" value="{{ old('full_name') ?? auth()->user()->full_name }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">Email Address:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3"  name="email" type="email" class="form-control" placeholder="Your Email Address" aria-describedby="input-group-1" value="{{ old('email') ?? auth()->user()->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Contact Phone Number:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3"  name="contact_phone_number" type="text" class="form-control" placeholder="Your Phone Number" aria-describedby="input-group-1" value="{{ old('contact_phone_number') ?? auth()->user()->phone }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">Your address/Practice Location:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3"  name="address" type="text" class="form-control" placeholder="Your Address or practice Location" aria-describedby="input-group-1" value="{{ old('address') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">No of Pages/Slides:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3"  name="no_of_pages" type="number" class="form-control" placeholder="No of Pages/Slides" aria-describedby="input-group-1" value="{{ old('no_of_pages') }}">
                                        </div>
                                    </div>

                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Estimated Duration of Presentation (minutes):</label>
                                        <div class="input-group">
                                            <input id="crud-form-3"  name="duration" type="number" class="form-control" placeholder="Estimated Duration of Presentation (minutes)" aria-describedby="input-group-1" value="{{ old('duration') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Abstract Title:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3"  name="abstract_title" type="text" class="form-control" placeholder="Abstract Title" aria-describedby="input-group-1" value="{{ old('abstract_title') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 mb-4">
                                    <div class="alert alert-secondary show mb-2" role="alert">
                                        <div class="flex items-center">
                                            <div class="font-medium text-lg">Guidelines to '{{$event->title}}' Abstract Submission</div>
                                            <div class="text-xs bg-warning px-1 rounded-md text-slate-700 ml-auto">Abstract Guidelines</div>
                                        </div>
                                        <div class="mt-3 text-primary"><strong><a href="{{ asset('templates/PANConf-Abstract-Template.pdf') }}" download="PANConf-Abstract-Template.pdf">Download Sample PANConf Abstract Template</a></strong></div>
                                    </div>

                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">Upload Abstract Document:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3"  name="file" type="file" class="form-control" placeholder="Select FIle" aria-describedby="input-group-1" value="{{ old('file') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Additional Information (optional):</label>
                                        <textarea name="additional_information" class="editor"></textarea>
                                    </div>
                                </div>

{{--                                <h3 class="mt-5">Please select an exhibition (if you want to buy)</h3>--}}
{{--                                <div class="flex">--}}
{{--                                    <div class="flex-1 mt-3 ">--}}
{{--                                        <label for="title" class="form-label">Select Exhibition</label>--}}
{{--                                        <select  class="tom-select w-full" name="exhibition" id="title">--}}
{{--                                            <option value="" selected>Select Exhibition</option>--}}
{{--                                            @foreach($exhibitions AS $exhibition)--}}
{{--                                                <option value="{{$exhibition->id}}" >{{ $exhibition->description }} --  ₦{{ number_format($exhibition->amount) }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="text-right mt-5">
                                    <button class="btn btn-primary w-64">Continue</button>
                                    <a href="{{ route('user.events.register.exhibition_get', $event->id) }}" class="btn btn-danger-soft w-32">Skip</a>
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

