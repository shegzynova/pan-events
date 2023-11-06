@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Notification'])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Notification
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
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary shadow-md mr-2">Add New Notification</a>
            </div>
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">S/N</th>
                        <th class="whitespace-nowrap">Title</th>
                        <th class="whitespace-nowrap">For</th>
                        <th class="whitespace-nowrap">Seen by</th>
                        <th class="whitespace-nowrap">Date Created</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($notifications as $index => $notification)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            <td> {{ $notification->title }} </td>
                            <td> {{ is_null($notification->for) ? 0 : count(json_decode($notification->for)) }} </td>
                            <td> {{ is_null($notification->seen) ? 0 : count(json_decode($notification->seen)) }} </td>
                            <td> {{ $notification->created_at->diffForHumans() }} </td>
                            <td>
                                <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-info shadow-md mr-2">Edit</a>
                                <a href="{{ route('admin.notifications.destroy', $notification->id) }}"
                                   class="btn btn-danger shadow-md mr-2"
                                   onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this Notification?')) { document.getElementById('delete-form').submit(); }"
                                >
                                    Delete
                                </a>
                                <form id="delete-form" action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>No Notifications Yet!!</tr>
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



        {{--function updateEventStatus() {--}}
        {{--        var isPublished = $('#post-form-5').prop('checked');--}}
        {{--        console.log(isPublished)--}}
        {{--        var eventId = {{ $notification->id }};--}}

        {{--        $.ajax({--}}
        {{--            url: '/events/' + eventId + '/publish',--}}
        {{--            type: 'PUT',--}}
        {{--            data: {--}}
        {{--                is_published: isPublished--}}
        {{--            },--}}
        {{--            success: function(response) {--}}
        {{--                Swal.Toast.fire({--}}
        {{--                    icon: 'success',--}}
        {{--                    title: 'Success'--}}
        {{--                })--}}
        {{--            },--}}
        {{--            error: function(xhr, status, error) {--}}
        {{--                Toast.fire({--}}
        {{--                    icon: 'error',--}}
        {{--                    title: 'Error'--}}
        {{--                })--}}
        {{--            }--}}
        {{--        });--}}
        {{--    }--}}
    </script>
@endsection