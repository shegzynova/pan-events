@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Edit notifications'])
        <!-- END: Top Bar -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Edit notification
            </h2>
        </div>
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                    {{ $error }} </div>
            @endforeach
        @endif
        <form method="POST" action="{{ route('admin.notifications.update', $notification->id) }}" enctype="multipart/form-data" id="notificationForm">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Form Layout -->
                    <div class="intro-y box p-5">
                        <div class="intro-y box p-5">
                            <div>
                                <label for="crud-form-1" class="form-label">Notification Title</label>
                                <input id="crud-form-1" required name="title" type="text" class="form-control w-full"
                                       placeholder="Notification Title" value="{{ old('title', $notification->title) }}">
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-2" class="form-label">For</label>
                                <select multiple data-placeholder="Users" class="tom-select w-full" name="for[]"
                                        id="crud-form-2">
                                    <option disabled>Select Users</option>
                                    @foreach($users AS $userId => $user)
                                        <option value="{{ $userId }}">{{$user}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="descId">Body</label>
                                <div class="mt-2">
                            <textarea name="body" id="descId" class="editor"
                                      placeholder="Description of the Notification">{{ old('body', $notification->body) }}</textarea>
                                </div>
                            </div>
                            <div class="text-right mt-5">
                                <button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                <button class="btn btn-primary w-24">Save</button>
                            </div>
                        </div>
                    </div>
                    <!-- END: Form Layout -->
                </div>
            </div>
        </form>

    </div>
@endsection

