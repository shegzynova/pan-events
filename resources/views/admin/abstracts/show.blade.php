@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => $abstract->abstract_title])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            {{ $abstract->abstract_title }}
            @if($abstract->status == 'p')
                <button class="btn btn-rounded btn-pending-soft btn-sm w-24 mr-1 mb-2">Pending</button>
            @elseif($abstract->status == 'a')
                <button class="btn btn-rounded btn-success-soft btn-sm w-24 mr-1 mb-2">Approved</button>
            @else
                <button class="btn btn-rounded btn-danger-soft btn-sm w-24 mr-1 mb-2">Declined</button>
            @endif
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
            <div class="col-span-12 lg:col-span-12 mr-2">
                <div class="tab-content">
                    <div id="details" class="tab-pane active" role="tabpanel" aria-labelledby="details-tab">
                        <div class="box p-5 mt-5">
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                                <div>
                                    <div class="text-slate-500">Abstract Title</div>
                                    <div class="mt-1">{{ $abstract->abstract_title }}</div>
                                </div>
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">No Of Pages</div>
                                    <div class="mt-1">{{ $abstract->no_of_pages }}</div>
                                </div>
                                <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Duration</div>
                                    <div class="mt-1">{{ $abstract->duration }}</div>
                                </div>
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center pt-5 border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Additional Information</div>
                                    <div class="mt-1">{!! $abstract->additional_information !!}</div>
                                </div>
                                <i data-lucide="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center pt-5">
                                <div>
                                    <div class="text-slate-500">Abstract File
                                        @if($abstract->status == 'a')
                                            <button class="btn btn-success btn-sm">APPROVED</button>
                                        @elseif($abstract->status == 'p')
                                            <button class="btn btn-secondary btn-sm">PENDING</button>
                                        @else
                                            <button class="btn btn-danger btn-sm">DECLINED</button>
                                        @endif
                                    </div>
                                    <div class="flex mt-4">
                                        @if(!is_null($abstract->file))
                                            <div class="mr-3">
                                                <a href="{{ asset($abstract->file) }}" target="_blank" class="btn btn-secondary-soft shadow-md mr-2">VIEW FILE</a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ asset($abstract->file) }}" download class="btn btn-secondary-soft shadow-md mr-2">DOWNLOAD FILE</a>
                                            </div>
                                            @if($abstract->status != 'a')
                                            <div class="mr-3">
                                                <a href="{{ route('admin.abstracts.approve', $abstract->id) }}" target="_blank" class="btn btn-primary shadow-md mr-2">APPROVE</a>
                                            </div>
                                            @else
                                            <div>
                                                <a href="{{ route('admin.abstracts.decline', $abstract->id) }}" class="btn btn-danger shadow-md mr-2">DECLINE</a>
                                            </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <i data-lucide="book-open" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            @if(!is_null($abstract->full_paper))
                            <div class="flex items-center pt-5">
                                <div>
                                    <div class="text-slate-500">Full Paper
                                        @if($abstract->full_paper_status == 'a')
                                            <button class="btn btn-success btn-sm">APPROVED</button>
                                        @elseif($abstract->full_paper_status == 'p')
                                            <button class="btn btn-secondary btn-sm">PENDING</button>
                                        @else
                                            <button class="btn btn-danger btn-sm">DECLINED</button>
                                        @endif</div>
                                    <div class="flex mt-4">

                                            <div class="mr-3">
                                                <a href="{{ asset('storage/'.$abstract->full_paper) }}" target="_blank" class="btn btn-secondary-soft shadow-md mr-2">VIEW FILE</a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ asset('storage/'.$abstract->full_paper) }}" download class="btn btn-secondary-soft shadow-md mr-2">DOWNLOAD FILE</a>
                                            </div>
                                        @if($abstract->full_paper_status != 'a')
                                            <div class="mr-3">
                                                <a href="{{ route('admin.abstracts.approve_full_paper', $abstract->id) }}" target="_blank" class="btn btn-primary shadow-md mr-2">APPROVE</a>
                                            </div>
                                        @else
                                            <div>
                                                <a href="{{ route('admin.abstracts.decline_full_paper', $abstract->id) }}" class="btn btn-danger shadow-md mr-2">DECLINE</a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <i data-lucide="book-open" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            @endif
                            @if(!is_null($abstract->presentation))
                            <div class="flex items-center pt-5">
                                <div>
                                    <div class="text-slate-500">Presentation
                                        @if($abstract->presentation_status == 'a')
                                            <button class="btn btn-success btn-sm">APPROVED</button>
                                        @elseif($abstract->presentation_status == 'p')
                                            <button class="btn btn-secondary btn-sm">PENDING</button>
                                        @else
                                            <button class="btn btn-danger btn-sm">DECLINED</button>
                                        @endif
                                    </div>
                                    <div class="flex mt-4">

                                            <div class="mr-3">
                                                <a href="{{ asset('storage/'.$abstract->presentation) }}" target="_blank" class="btn btn-secondary-soft shadow-md mr-2">VIEW FILE</a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ asset('storage/'.$abstract->presentation) }}" download class="btn btn-secondary-soft shadow-md mr-2">DOWNLOAD FILE</a>
                                            </div>

                                        @if($abstract->presentation_status != 'a')
                                            <div class="mr-3">
                                                <a href="{{ route('admin.abstracts.approve_presentation', $abstract->id) }}" target="_blank" class="btn btn-primary shadow-md mr-2">APPROVE</a>
                                            </div>
                                        @else
                                            <div>
                                                <a href="{{ route('admin.abstracts.decline_presentation', $abstract->id) }}" class="btn btn-danger shadow-md mr-2">DECLINE</a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <i data-lucide="book-open" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
{{--            <div class="col-span-12 lg:col-span-4">--}}
{{--                <div class="tab-content">--}}
{{--                    <div id="details" class="tab-pane active" role="tabpanel" aria-labelledby="details-tab">--}}
{{--                        <div class="box p-5 mt-5">--}}
{{--                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">--}}
{{--                                <div>--}}
{{--                                    --}}{{--                                    <div class="text-slate-500">Image</div>--}}
{{--                                    <div class="mt-1"><img width="250px" src="{{ asset('dist/images/1600px-Paystack_Logo.png') }}"></div>--}}
{{--                                </div>--}}
{{--                                <i data-lucide="image" class="w-4 h-4 text-slate-500 ml-auto"></i>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">--}}
{{--                                <div>--}}
{{--                                    --}}{{--                                    <div class="text-slate-500">Image</div>--}}
{{--                                    <div class="mt-3"><img width="250px" src="{{ asset('dist/images/bank.png') }}"></div>--}}
{{--                                </div>--}}
{{--                                <i data-lucide="image" class="w-4 h-4 text-slate-500 ml-auto"></i>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">--}}
{{--                                <div>--}}
{{--                                    <div class="text-slate-500">Price</div>--}}
{{--                                    <div class="mt-1">₦{{ number_format($event->regular_price) }}</div>--}}
{{--                                </div>--}}
{{--                                <i data-lucide="usder" class="w-4 h-4 text-slate-500 ml-auto">₦</i>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">--}}
{{--                                <div>--}}
{{--                                    <div class="text-slate-500">Exhibition Price</div>--}}
{{--                                    <div class="mt-1">₦{{ number_format($event->exhibition_price) }}</div>--}}
{{--                                </div>--}}
{{--                                <i data-lucide="usehrs" class="w-4 h-4 text-slate-500 ml-auto">₦</i>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center pt-5 py-5">--}}
{{--                                <div>--}}
{{--                                    <div class="text-slate-500">Speaker Price</div>--}}
{{--                                    <div class="mt-1">₦{{ number_format($event->speaker_price) }}</div>--}}
{{--                                </div>--}}
{{--                                <i data-lucide="emic" class="w-4 h-4 text-slate-500 ml-auto">₦</i>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center pt-5 ">--}}
{{--                                --}}{{--                                <div>--}}
{{--                                --}}{{--                                    <div class="text-slate-500">Speaker Price</div>--}}
{{--                                --}}{{--                                    <div class="mt-1">₦{{ number_format($event->speaker_price) }}</div>--}}
{{--                                --}}{{--                                </div>--}}
{{--                                --}}{{--                                <i data-lucide="emic" class="w-4 h-4 text-slate-500 ml-auto">₦</i>--}}
{{--                                <div class="float-right w-full">--}}
{{--                                    <a href="{{ route('user.events.step_one_get', $event) }}" class="btn btn-primary shadow-md mr-2">Start Registration</a>--}}
{{--                                </div>--}}

{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
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