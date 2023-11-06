@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Event Users' ])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Event Users
        </h2>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x"
                                                                                                      class="w-4 h-4"></i>
                </button>
            </div>
        @endif


        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a href="{{ route('admin.eventUsers.create') }}" class="btn btn-primary shadow-md mr-2">Add New Event
                    Users</a>
                <div class="dropdown mr-2">
                    <button id="sendMessageButton" disabled class="dropdown-toggle btn px-2 box" aria-expanded="false"
                            data-tw-toggle="dropdown">
                        <span class=""> Send Message </span>
                    </button>

                    <div class="dropdown-menu w-60">
                        <ul class="dropdown-content">
                            <li>
                                <a href="#sms-modal" data-tw-toggle="modal" data-tw-target="#sms-modal" class="dropdown-item">SMS </a>
                            </li>
                            <li>
                                <a href="#email-modal" data-tw-toggle="modal" data-tw-target="#email-modal" class="dropdown-item">Email</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown mr-2">
                    <button id="sendCertificateButton" disabled class="dropdown-toggle btn px-2 box"
                            aria-expanded="false" data-tw-toggle="dropdown">
                        <span class=""> Send Certificate </span>
                    </button>

                    <div class="dropdown-menu w-60">
                        <ul class="dropdown-content">
                            <li>
                                <a href="{{ route('admin.send-certificate', 'coa') }}"
                                   class="dropdown-item send-certificate-link" data-certificate-type="coa">Certificate
                                    Of Attendance </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.send-certificate', 'cpd') }}"
                                   class="dropdown-item send-certificate-link" data-certificate-type="cpd">CPD
                                    Certificate </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4"
                                                                                   data-lucide="plus"></i> </span>
                    </button>
                    @include('admin.layouts.export', ['type' => 'event-users'])
                </div>

                @if($eventUsers)
                    <div class="hidden md:block mx-auto text-slate-500">
                        @if ($eventUsers->count() > 0)
                            Showing {{ ($eventUsers->currentPage() - 1) * $eventUsers->perPage() + 1 }}
                            to {{ ($eventUsers->currentPage() - 1) * $eventUsers->perPage() + $eventUsers->count() }}
                            of {{ $eventUsers->total() }} entries
                        @else
                            No entries found.
                        @endif
                    </div>
                @endif

                <div class="w-full xl:w-auto mt-3 xl:mt-0  col-span-12">
                    <form action="{{ route('admin.eventUsers.index') }}" method="GET"
                          class="flex flex-wrap items-center" name="searchForm">
                        <div class="w-full sm:w-auto flex items-center mb-2 sm:mb-0 xl:mr-3">
                            <div class="w-full relative text-slate-500">
                                <input type="text" name="query" class="form-control w-full box pr-10"
                                       placeholder="Search ref, name, email..." value="{{ $query }}">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                            </div>
                        </div>

                        <div class="w-full sm:w-auto flex items-center sm:mb-0 xl:mr-3">
                            <select name="status" class="w-full xl:w-auto form-select box mb-2 sm:mb-0">
                                <option value="" selected>All status</option>
                                <option value="1" {{ $status == '1' ? 'selected' : '' }}>Paid</option>
                                <option value="0" {{ $status == '0' ? 'selected' : '' }}>Not Paid</option>
                            </select>
                        </div>

                        <div class="w-full sm:w-auto flex items-center sm:mb-0 xl:mb-0 xl:mr-3">
                            <button type="submit" class="btn btn-primary w-full xl:w-auto ml-0 mt-2 sm:mt-0">Search
                            </button>
                        </div>

                        <div class="w-full sm:w-auto flex items-center xl:mb-0">
                            <button type="button" class="btn btn-dark w-full xl:w-auto ml-0 mt-2 sm:mt-0"
                                    onclick="clearSearch()">Clear
                            </button>
                        </div>
                    </form>
                </div>


            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                @include('flash::message')

                <div class="clearfix"></div>

                <div class="card">
                    @include('admin.event_users.table')
                </div>
            </div>

            <!-- END: Pagination -->
        </div>
        <!-- END: Delete Confirmation Modal -->
    </div>

    <div id="sms-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="sendSms">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">SMS</h4>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="message">Message:</label>
                                <p class="text-danger" id="error-sms"></p>
                                <textarea class="form-control" required id="message" name="message" rows="4"></textarea>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" id="sendSMSButton" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" value="">

    <div id="email-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">

            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Send Email</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="email-subject" name="subject">
                        </div>
                        <div class="form-group mt-3">
                            <label for="message">Message</label>
                            <textarea name="message" id="email-message" class="editor" required
                                      placeholder="Description of the event">{{ old('description') }}</textarea>
                        </div>
                    </form>
                    <div id="error-subject" class="alert alert-danger" style="display: none;"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" id="sendEmailButton" class="btn btn-primary">Send</button>
                </div>
            </div>
            <div class="modal-content">

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Bind a change event to all checkboxes with class 'event-user-checkbox'
            $('.event-user-checkbox').change(function () {
                // Check if at least one checkbox is checked
                if ($('.event-user-checkbox:checked').length > 0) {
                    // Enable the button
                    $('#sendCertificateButton').prop('disabled', false);
                    $('#sendMessageButton').prop('disabled', false);
                } else {
                    // Disable the button
                    $('#sendCertificateButton').prop('disabled', true);
                    $('#sendMessageButton').prop('disabled', true);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            })

            $('.send-certificate-link').click(function (e) {
                e.preventDefault();

                var selectedIds = $('.event-user-checkbox:checked').map(function () {
                    return this.value;
                }).get();

                var certificateType = $(this).data('certificate-type');
                var href = $(this).attr('href') + '?selectedIds=' + selectedIds.join(',') + '&certificateType=' + certificateType;

                window.location.href = href;
            });

            $('#sendSMSButton').click(function() {

                var selectedIds = $('.event-user-checkbox:checked').map(function () {
                    return this.value;
                }).get();

                var message = $('#message').val();

                // Check if the textarea is empty
                if (message.trim() === '') {
                    // Display an error message
                    $('#error-sms').text('Please enter a message.').show();
                    return; // Prevent further processing
                } else {
                    // Hide any previous error message
                    $('#error-sms').hide();
                }

                // Make the AJAX POST request to the /send-sms URL
                $.ajax({
                    url: '/send-sms',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        message: message,
                        ids: selectedIds
                    },
                    success: function(response) {
                        // Handle the response from the server
                        Toast.fire({
                            icon: 'success',
                            title: 'SMS Sent'
                        })

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors

                        Toast.fire({
                            icon: 'error',
                            title: 'Unable to Send SMS'
                        })

                        setTimeout(function() {
                            location.reload(); // Reload the page
                        }, 2000);
                    }
                });

            });

            $('#sendEmailButton').click(function() {

                var selectedIds = $('.event-user-checkbox:checked').map(function () {
                    return this.value;
                }).get();

                var subject = $('#email-subject').val();
                var message = $(".ck-content p").text();

                if (subject.trim() === '') {
                    $('#error-subject').text('Please enter a subject.').show();
                    return; // Prevent further processing
                } else {
                    $('#error-subject').hide();
                }

                if (message.trim() === '') {
                    $('#error-message').text('Please enter a message.').show();
                    return; // Prevent further processing
                } else {
                    $('#error-message').hide();
                }

                $.ajax({
                    url: '/send-email',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        message: message,
                        subject: subject,
                        ids: selectedIds
                    },
                    success: function(response) {
                        // Handle the response from the server
                        Toast.fire({
                            icon: 'success',
                            title: 'Email Sent'
                        })

                        setTimeout(function() {
                            location.reload(); // Reload the page
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors
                        Toast.fire({
                            icon: 'error',
                            title: 'Unable to Send Email'
                        })

                        setTimeout(function() {
                            location.reload(); // Reload the page
                        }, 2000);
                    }
                });

            });
        });

    </script>

    <script>
        function clearSearch() {
            document.querySelector('input[name="query"]').value = '';
            document.querySelector('select[name="status"]').selectedIndex = 0;
            document.querySelector('form[name="searchForm"]').submit();
        }
    </script>
@endsection