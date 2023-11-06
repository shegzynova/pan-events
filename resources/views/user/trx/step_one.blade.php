@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Register For Events'])
        <!-- END: Top Bar -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-small mr-auto float-left">
                Register for {{$event->title}} at <em>{{ $event->location }}</em> on {{ $event->date }}
            </h2>
            <h2 class="text-lg font-small float-right">
                ₦ <span id="event-price">{{ number_format($event->price) }}</span>
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
            <div class="relative before:hidden before:lg:block before:absolute before:w-[69%] before:h-[3px] before:top-0 before:bottom-0 before:mt-4 before:bg-slate-100 before:dark:bg-darkmode-400 flex flex-col lg:flex-row justify-center px-5 sm:px-20">
                <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                    <button class="w-10 h-10 rounded-full btn btn-primary">1</button>
                    <div class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto">Setup User Details</div>
                </div>
                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">2</button>
                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Accommodation</div>
                </div>
                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">3</button>
                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Details Page</div>
                </div>
                <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                    <button class="w-10 h-10 rounded-full btn text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400">4</button>
                    <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-slate-600 dark:text-slate-400">Finalize and Pay</div>
                </div>
            </div>
            <form method="POST" action="{{ route('user.events.step_one_post', $event->id) }}" enctype="multipart/form-data" id="eventForm">
                @csrf
                @method('POST')
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-10">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div class="intro-y box p-5">
                                <div class="flex ">
                                    @php
                                        $user = auth()->user();
                                    @endphp
                                    <div class="flex-1 mt-3 mr-3">
                                        <label for="title" class="form-label">Title</label>
                                        <select required class="tom-select w-full" name="title" id="title">
                                            <option disabled selected>Select Title</option>
                                            <option value="mr" {{ old('title') === 'mr' || (isset($userData['title']) && $userData['title'] === 'mr') ? 'selected' : '' }}>Mr</option>
                                            <option value="mrs" {{ old('title') === 'mrs' || (isset($userData['title']) && $userData['title'] === 'mrs') ? 'selected' : '' }}>Mrs</option>
                                            <option value="dr" {{ old('title') === 'dr' || (isset($userData['title']) && $userData['title'] === 'dr') ? 'selected' : '' }}>Dr</option>
                                            <option value="miss" {{ old('title') === 'miss' || (isset($userData['title']) && $userData['title'] === 'miss') ? 'selected' : '' }}>Miss</option>
                                        </select>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">First Name</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="first_name" type="text" class="form-control" placeholder="John Doe" aria-describedby="input-group-1" value="{{ old('first_name', isset($userData['first_name']) ? $userData['first_name'] : $user->first_name) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-3">
                                        <label for="crud-form-3" class="form-label">Surname</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="surname" type="text" class="form-control" placeholder="John Doe" aria-describedby="input-group-1" value="{{ isset($userData['surname']) ? $userData['surname'] : $user->surname }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="phone_number" type="text" class="form-control" placeholder="+234877646983" aria-describedby="input-group-1" value="{{ isset($userData['phone_number']) ? $userData['phone_number'] : $user->phone }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-3">
                                        <label for="crud-form-3" class="form-label">Email</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" readonly disabled name="email" type="text" class="form-control" placeholder="john_doe@mail.com" aria-describedby="input-group-1" value="{{ isset($userData['email']) ? $userData['email'] : $user->email }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="reg_type" class="form-label">Register AS</label>
                                        <select class="tom-select w-full" name="register_as" id="reg_type" required>
                                            <option disabled selected>Select Registration Type</option>
                                            <option value="regular" {{ old('register_as', isset($userData['type']) ? $userData['type'] : '') === 'regular' ? 'selected' : '' }}>Regular</option>
                                            <option value="exhibition" {{ old('register_as', isset($userData['type']) ? $userData['type'] : '') === 'exhibition' ? 'selected' : '' }}>Exhibition</option>
                                            <option value="speaker" {{ old('register_as', isset($userData['type']) ? $userData['type'] : '') === 'speaker' ? 'selected' : '' }}>Speaker</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-3">
                                        <label for="crud-form-2" class="form-label">Gender</label>
                                        <select class="tom-select w-full" name="gender" id="crud-form-2" required>
                                            <option disabled selected>Select Gender</option>
                                            <option value="male" {{ old('gender', isset($userData['gender']) ? $userData['gender'] : '') === 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', isset($userData['gender']) ? $userData['gender'] : '') === 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="not_say" {{ old('gender', isset($userData['gender']) ? $userData['gender'] : '') === 'not_say' ? 'selected' : '' }}>Rather Not Say</option>
                                        </select>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-2" class="form-label">Nature of Practice</label>
                                        <select required class="tom-select w-full" name="nature_practice" id="crud-form-2">
                                            <option disabled selected>Select Nature of Practice</option>
                                            <option value="public" {{ old('nature_practice', isset($userData['nature_of_practice']) ? $userData['nature_of_practice'] : '') === 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="private" {{ old('nature_practice', isset($userData['nature_of_practice']) ? $userData['nature_of_practice'] : '') === 'private' ? 'selected' : '' }}>Private</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Additional Fields -->
                                <div class="flex">
                                    <div class="flex-1 mt-3 mr-3">
                                        <label for="education_level" class="form-label">Education Level</label>
                                        <input id="education_level" required name="education_level" type="text" class="form-control" placeholder="Master's Degree" aria-describedby="input-group-1" value="{{ isset($userData['education_level']) ? $userData['education_level'] : $user->education_level }}">
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="employment_status" class="form-label">Employment Status</label>
                                        <select class="tom-select w-full" name="employment_status" id="employment_status" required>
                                            <option disabled selected>Select Employment Status</option>
                                            <option value="employed" {{ old('employment_status', isset($userData['employment_status']) ? $userData['employment_status'] : '') === 'employed' ? 'selected' : '' }}>Employed</option>
                                            <option value="unemployed" {{ old('employment_status', isset($userData['employment_status']) ? $userData['employment_status'] : '') === 'unemployed' ? 'selected' : '' }}>Unemployed</option>
                                            <option value="self_employed" {{ old('employment_status', isset($userData['employment_status']) ? $userData['employment_status'] : '') === 'self_employed' ? 'selected' : '' }}>Self-employed</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex ">
                                    <div class="flex-1 mt-3 mr-3">
                                        <label for="crud-form-2" class="form-label">Center/Institution</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="institution" type="text" class="form-control" placeholder="ICC Intitute" aria-describedby="input-group-1" value="{{ isset($userData['institution']) ? $userData['institution'] : old('institution') }}">
                                        </div>
                                    </div>
                                    <div class="flex-1 mt-3">
                                        <label for="crud-form-3" class="form-label">City</label>
                                        <div class="input-group">
                                            <input id="crud-form-3" required name="city" type="text" class="form-control" placeholder="Ikeja" aria-describedby="input-group-1" value="{{ isset($userData['city']) ? $userData['city'] : old('city') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="flex-1">
                                        <div class="mt-3 mt-3 mr-3">
                                            <label for="crud-form-3" class="form-label">State of Practice/Residence <em>(if Nigeria)</em></label>
                                            @php
                                                $states = App\Models\State::all();
                                            @endphp
                                            <select required class="tom-select w-full" name="state" id="crud-form-2">
                                                <option disabled selected>Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}"
                                                            {{ old('state', isset($userData['state']) ? $userData['state'] : '') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex-1">
                                        <div class="mt-3">
                                            <label for="crud-form-3" class="form-label">Nationality</label>
                                            @php
                                                $countries = App\Models\Country::all();
                                            @endphp
                                            <select required class="tom-select w-full" name="country" id="crud-form-2">
                                                <option disabled selected>Select Nationality</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                            {{ old('country', isset($userData['country']) ? $userData['country'] : '') == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
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
@endsection

