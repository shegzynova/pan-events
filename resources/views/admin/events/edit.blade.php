@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Edit Events'])
        <!-- END: Top Bar -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Edit Event
            </h2>
        </div>
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                    {{ $error }} </div>
            @endforeach
        @endif
        <form method="POST" action="{{ route('admin.events.update', $event->id) }}" enctype="multipart/form-data" id="eventForm">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-8">
                    <!-- BEGIN: Form Layout -->
                    <div class="intro-y box p-5">
                        <div class="intro-y box p-5">
                            <div>
                                <label for="crud-form-1" class="form-label">Event Title</label>
                                <input id="crud-form-1" required name="title" type="text" class="form-control w-full"
                                       placeholder="Event Title" value="{{ old('title', $event->title) }}">
                            </div>
                            <div class="mt-3">
                                <label for="crud-form-3" class="form-label">Location</label>
                                <div class="input-group">
                                    <input id="crud-form-3" required name="location" type="text" class="form-control"
                                           placeholder="Location" aria-describedby="input-group-1"
                                           value="{{ old('location', $event->location) }}">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Price</label>
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input-group">
                                        <div id="input-group-3" class="input-group-text">Ordinary</div>
                                        <input type="text" class="form-control" name="ordinary_member_price" placeholder="0.00"
                                               aria-describedby="input-group-3"
                                               value="{{ old('ordinary_member_price', $event->ordinary_member_price) }}">
                                    </div>
                                    <div class="input-group mt-2 sm:mt-0">
                                        <div id="input-group-4" class="input-group-text">Trainee</div>
                                        <input type="text" class="form-control" name="trainee_member_price" placeholder="0.00"
                                               aria-describedby="input-group-4"
                                               value="{{ old('trainee_member_price', $event->trainee_member_price) }}">
                                    </div>
                                    <div class="input-group mt-2 sm:mt-0">
                                        <div id="input-group-5" class="input-group-text">Associate</div>
                                        <input type="text" class="form-control" name="associate_member_price" placeholder="0.00"
                                               aria-describedby="input-group-5"
                                               value="{{ old('associate_member_price', $event->associate_member_price) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="descId">Description</label>
                                <div class="mt-2">
                            <textarea name="description" id="descId" class="editor"
                                      placeholder="Description of the event">{{ old('description', $event->description) }}</textarea>
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
                <div class="col-span-12 lg:col-span-4">
                    <div class="intro-y box p-5">
                        <div class="mt-3">
                            <label for="post-form-2" class="form-label">Date</label>
                            <input type="text" required class="datepicker form-control" id="post-form-2"
                                   data-single-mode="true" name="date" readonly value="{{ old('date', $event->date) }}">
                        </div>
                        <div class="mt-3">
                            <label for="crud-form-2" class="form-label">Category</label>
                            <select required data-placeholder="Select Category" class="tom-select w-full" name="category"
                                    id="crud-form-2">
                                <option disabled selected>Select Category</option>
                                <option value="c" {{ old('category', $event->category) === 'c' ? 'selected' : '' }}>Conference</option>
                                <option value="w" {{ old('category', $event->category) === 'w' ? 'selected' : '' }}>Webinar</option>
                            </select>
                        </div>
                        <div class="mt-5">
                            <input name="image" id="fileInput" type="file" value="{{ old('image') }}" />
                        </div>
                        <div class="form-check form-switch flex flex-col items-start mt-4">
                            <label for="post-form-5" class="form-check-label ml-0 mb-2">Published</label>
                            <input name="is_published" id="post-form-5" class="form-check-input" type="checkbox"
                                    {{ old('is_published', $event->is_published) ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

