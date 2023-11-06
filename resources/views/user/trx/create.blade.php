@extends('admin.layouts.app')

@section('content')

<div class="content">
    <!-- BEGIN: Top Bar -->
    @include('user.layouts.topbar', ['title' => 'Create Events'])
    <!-- END: Top Bar -->
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Register for {{$event->title}}
        </h2>
    </div>
    @if( !is_null( $errors->all() ) )
    @foreach($errors->all() as $error)
    <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
        {{ $error }}
    </div>
    @endforeach
    @endif
    <form method="POST" action="{{route('user.register.event', ['event' => $event, 'event_slug' => $event->slug])}}" enctype="multipart/form-data" id="eventForm">
        @csrf
        @method('POST')
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div class="intro-y box p-5">
                        <div class="flex ">
                            @php 
                                $user = auth()->user();
                            @endphp
                            <div class="flex-1 mt-3 mr-3">
                                <label for="crud-form-2" class="form-label">Title</label>
                                <select required class="tom-select w-full" name="title" id="crud-form-2">
                                    <option disabled selected>Select Title</option>
                                    <option value="mr">Mr</option>
                                    <option value="mrs">Mrs</option>
                                    <option value="dr">Dr</option>
                                    <option value="miss">Miss</option>
                                </select>
                            </div> 
                            <div class="flex-1 mt-3">
                                <label for="crud-form-3" class="form-label">First Name</label>
                                <div class="input-group">
                                    <input id="crud-form-3" required name="first_name" type="text" class="form-control" placeholder="John Doe" aria-describedby="input-group-1" value="{{$user->first_name}}">
                                </div>
                            </div>
                        </div>
                        <div class="flex  ">
                            <div class="flex-1 mt-3  mr-3">
                                <label for="crud-form-3" class="form-label">Surname</label>
                                <div class="input-group">
                                <input id="crud-form-3" required name="surname" type="text" class="form-control" placeholder="John Doe" aria-describedby="input-group-1" value="{{$user->surname}}">
                                </div>
                            </div>
                            <div class="flex-1 mt-3">
                                <label for="crud-form-3" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <input id="crud-form-3" required name="phone_number" type="text" class="form-control" placeholder="+234877646983" aria-describedby="input-group-1" value="{{$user->phone}}">
                                </div>
                            </div>
                        </div>
                        <div class="flex ">
                            <div class="flex-1 mt-3  mr-3">
                                <label for="crud-form-3" class="form-label">Email</label>
                                <div class="input-group">
                                    <input id="crud-form-3" required name="email" type="text" class="form-control" placeholder="john_doe@mail.com" aria-describedby="input-group-1" value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="flex-1 mt-3">
                                <label for="crud-form-2" class="form-label">Gender</label>
                                <select  class="tom-select w-full" name="gender" id="crud-form-2" required>
                                    <option disabled selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="not_say">Rather Not Say</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex ">
                            <div class="flex-1 mt-3 mr-3">
                                <label for="crud-form-2" class="form-label">Nature of Practice</label>
                                <select required class="tom-select w-full" name="nature_practice" id="crud-form-2">
                                    <option disabled selected>Select Nature of Practice</option>
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                            <div class="flex-1 mt-3">
                                <label for="crud-form-2" class="form-label">Center/Institution</label>
                                <div class="input-group">
                                <input id="crud-form-3" required name="institution" type="text" class="form-control" placeholder="ICC Intitute" aria-describedby="input-group-1" value="">
                                </div>
                            </div>
                        </div>
                        <div class="flex ">
                            <div class="flex-1 mt-3 mr-3">
                                <label for="crud-form-3" class="form-label">City</label>
                                <div class="input-group">
                                    <input id="crud-form-3" required name="city" type="text" class="form-control" placeholder="Ikeja" aria-describedby="input-group-1" value="">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="crud-form-3" class="form-label">State of Practice/Residence <em>(if Nigeria)</em></label>
                                @php
                                $states = App\Models\State::all();
                                @endphp
                                <select required class="tom-select w-full" name="state" id="crud-form-2">
                                    <option disabled selected>Select State</option>
                                    @foreach ($states as $state)
                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
{{--                        <div class="mt-3">--}}
{{--                            <label for="crud-form-3" class="form-label">Nationailty</em></label>--}}
{{--                            @php--}}
{{--                            $countries = App\Models\Country::all();--}}
{{--                            @endphp--}}
{{--                            <select required class="tom-select w-full" name="nationality" id="crud-form-2">--}}
{{--                                <option disabled selected>Select Nationality</option>--}}
{{--                                @foreach ($countries as $country)--}}
{{--                                <option value="{{$country->id}}">{{$country->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="text-right mt-5">
                            <button class="btn btn-lg btn-primary w-64">Submit Registration</button>
                        </div>

                    </div>
                </div>
                <!-- END: Form Layout -->
            </div>

        </div>
    </form>
</div>
@endsection