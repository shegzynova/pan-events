@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => $event->title])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            {{ $event->title }}
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

        @if ($event->image)
            <div class="mt-2">
                <img class="img" src="{{ $event->image }}">
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 lg:col-span-8 mr-2">
                <div class="tab-content">
                    <div id="details" class="tab-pane active" role="tabpanel" aria-labelledby="details-tab">
                        <div class="box p-5 mt-5">
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                                <div>
                                    <div class="text-slate-500">Event Title</div>
                                    <div class="mt-1">{{ $event->title }}</div>
                                </div>
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Event Slug</div>
                                    <div class="mt-1">{{ $event->slug }}</div>
                                </div>
                                <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Location</div>
                                    <div class="mt-1">{{ $event->location }}</div>
                                </div>
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center pt-5 border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Date</div>
                                    <div class="mt-1">{{ $event->date }}</div>
                                </div>
                                <i data-lucide="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center pt-5">
                                <div>
                                    <div class="text-slate-500">Description</div>
                                    <div class="mt-1">{!! $event->description !!}</div>
                                </div>
                                <i data-lucide="book-open" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <div class="tab-content">
                    <div id="details" class="tab-pane active" role="tabpanel" aria-labelledby="details-tab">
                        <div class="box p-5 mt-5">
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                                <div>
{{--                                    <div class="text-slate-500">Image</div>--}}
                                    <div class="mt-1"><img width="250px" src="{{ asset('dist/images/1600px-Paystack_Logo.png') }}"></div>
                                </div>
                                <i data-lucide="image" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                                <div>
                                    {{--                                    <div class="text-slate-500">Image</div>--}}
                                    <div class="mt-3"><img width="250px" src="{{ asset('dist/images/bank.png') }}"></div>
                                </div>
                                <i data-lucide="image" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Ordinary Member</div>
                                    <div class="mt-1">₦{{ number_format($event->ordinary_member_price) }}</div>
                                </div>
                                <i data-lucide="usder" class="w-4 h-4 text-slate-500 ml-auto">₦</i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Trainee Member</div>
                                    <div class="mt-1">₦{{ number_format($event->trainee_member_price) }}</div>
                                </div>
                                <i data-lucide="usehrs" class="w-4 h-4 text-slate-500 ml-auto">₦</i>
                            </div>
                            <div class="flex items-center pt-5 py-5">
                                <div>
                                    <div class="text-slate-500">Associate Member</div>
                                    <div class="mt-1">₦{{ number_format($event->associate_member_price) }}</div>
                                </div>
                                <i data-lucide="emic" class="w-4 h-4 text-slate-500 ml-auto">₦</i>
                            </div>
                            <div class="flex items-center">
{{--                                <div>--}}
{{--                                    <div class="text-slate-500">Speaker Price</div>--}}
{{--                                    <div class="mt-1">₦{{ number_format($event->speaker_price) }}</div>--}}
{{--                                </div>--}}
{{--                                <i data-lucide="emic" class="w-4 h-4 text-slate-500 ml-auto">₦</i>--}}

                                @php
                                    $userAttendance = optional($event->userAttendance);
                                    $successfulTransaction = optional($userAttendance)->relatedLatestSuccessfulTransaction;
                                @endphp

                                <div class="float-right w-full">
                                    @if($userAttendance->user_id === null)
                                        <a href="{{ route('user.events.step_one_get', $event) }}"
                                           class="btn btn-primary shadow-md mr-2">Start Application</a>
                                    @else
                                        @if(!is_null($successfulTransaction))
                                            <a class="btn btn-outline-success shadow-md mr-2" disabled>Application
                                                Submitted Successfully</a>
                                        @else
                                            <span class="btn-outline-pending mb-4">Application
                                                Submitted. Pending Payment</span>
                                            <br>
                                            <a href="{{ route('user.events.step_one_get', $event) }}"
                                               class="btn btn-primary shadow-md mr-2 mt-2">Update Application Details</a>
                                        @endif
                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: Delete Confirmation Modal -->
        <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Are you sure?</div>
                            <div class="text-slate-500 mt-2">
                                Do you really want to delete these records?
                                <br>
                                This process cannot be undone.
                            </div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-danger w-24">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->
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