@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Conferences/Events'])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Conferences/Events
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
            <div class="alert alert-primary alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-circle" class="w-6 h-6 mr-2"></i> {{ session('success') }}
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
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">S/N</th>
                        <th class="whitespace-nowrap">Category</th>
                        <th class="whitespace-nowrap">Title</th>
                        <th class="whitespace-nowrap">Date</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($events as $index => $event)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            <td> {{ $event->category == 'c' ? 'Conference' : 'Webinar' }} </td>
                            <td> {{ $event->title }} </td>
                            <td> {{ date('d M, Y', strtotime($event->date)) }} </td>
                            <td>
                                @php
                                    $userAttendance = optional($event->userAttendance);
                                    $successfulTransaction = optional($userAttendance)->relatedLatestSuccessfulTransaction;
                                @endphp
                                <a href="{{ route('user.events.show', $event->id)}}" data-tw-toggle="modal" data-tw-target="#event-modal-{{ $event->id }}" class="btn btn-primary mr-1 mb-2">Show Details</a>

                                @if(!is_null($successfulTransaction) && ($event->userAccommodation == null || $event->userAccommodation->isPaid == 0))
                                    <a href="{{ route('user.events.book_hotel', $event->id)}}" data-tw-toggle="modal" data-tw-target="#event-modal-{{ $event->id }}" class="btn btn-outline-danger mr-1 mb-2">{{ $event->userAccommodation != null ? 'Update Reserved' : 'Add' }} Hotel Booking</a>
                                @endif

                                @if($userAttendance->user_id === null)
                                    <a href="{{ route('user.events.step_one_get', $event) }}" class="btn btn-primary shadow-md mr-2">Start Application</a>
                                @else
                                    @if(!is_null($successfulTransaction))
                                        <a class="btn btn-outline-success shadow-md mr-2" disabled>Application Submitted Successfully</a>
                                    @else
                                        <a href="{{ route('user.events.step_one_get', $event) }}" class="btn btn-primary shadow-md mr-2">Update Application Details</a>
                                        <a class="btn btn-outline-pending shadow-md mr-2" disabled>Application Submitted. Pending Payment</a>
                                    @endif
                                @endif

                            </td>

                        </tr>
                    @empty
                        <tr>No Events Yet!!</tr>
                    @endforelse

                    </tbody>
                </table>
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