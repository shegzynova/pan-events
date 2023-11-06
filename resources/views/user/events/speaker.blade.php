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
            @include('admin.layouts.sections', ['page' => 3])
            <form method="POST" action="{{ route('user.events.step_two_post', $event->id) }}" enctype="multipart/form-data" id="eventForm">
                @csrf
                @method('POST')
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-10">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div class="intro-y box p-5">
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Your Full Name:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="full_name" type="text" class="form-control" placeholder="John Doe" aria-describedby="input-group-1" value="{{ old('full_name') ?? auth()->user()->full_name }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">Email Address:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="email" type="email" class="form-control" placeholder="Your Email Address" aria-describedby="input-group-1" value="{{ old('email') ?? auth()->user()->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Contact Phone Number:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="contact_phone_number" type="text" class="form-control" placeholder="Your Phone Number" aria-describedby="input-group-1" value="{{ old('contact_phone_number') ?? auth()->user()->phone }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">Your address/Practice Location:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="address" type="text" class="form-control" placeholder="Your Address or practice Location" aria-describedby="input-group-1" value="{{ old('address') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Abstract Title:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="abstract_title" type="text" class="form-control" placeholder="Abstract Title" aria-describedby="input-group-1" value="{{ old('abstract_title') }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">No of Pages/Slides:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="no_of_pages" type="number" class="form-control" placeholder="No of Pages/Slides" aria-describedby="input-group-1" value="{{ old('no_of_pages') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Estimated Duration of Presentation (minutes):</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="duration" type="number" class="form-control" placeholder="Estimated Duration of Presentation (minutes)" aria-describedby="input-group-1" value="{{ old('duration') }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">Attach file for up:</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="file" type="file" class="form-control" placeholder="Select FIle" aria-describedby="input-group-1" value="{{ old('file') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-2">
                                        <label for="crud-form-3" class="form-label">Additional Information (optional):</label>
                                        <textarea name="additional_information" class="editor"></textarea>
                                    </div>
                                </div>
                                <div class="text-right mt-5">
                                    <button class="btn btn-primary w-64">Continue</button>
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

    <script>
        import InlineEditor from "@ckeditor/ckeditor5-build-inline"; $(".editor").each(function () { const el = this; InlineEditor.create(el).catch((error) => { console.error(error); }); });
    </script>
@endsection

