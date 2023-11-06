@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Book Hotel For Event'])
        <!-- END: Top Bar -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-small mr-auto float-left">
                Book Hotel for {{$event->title}} at <em>{{ $event->location }}</em> on {{ $event->date }}
            </h2>
        </div>

        {{--<p>
            <a href="{{ route('user.events.step_one_get', $event->id) }}" class="btn btn-secondary-soft w-32">BACK</a>
        </p>--}}
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
        @php
            $res_type= "";
            if ($accommodation) {
                $res_type = !$accommodation->isPaid ? "reserve" : "pay";
            }

            $accommodation = optional($accommodation);
        @endphp
        <div class="intro-y box mt-5">
            <form method="POST" action="{{ route('user.events.book_hotel_pay', $event->id) }}" enctype="multipart/form-data" id="eventForm">
                @csrf
                @method('POST')
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-10">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div class="intro-y box p-5">
                                <div class="flex">
                                    <div class="flex-1 mt-3 ">
                                        <label for="hotel_id" class="form-label">Select Hotel</label>
                                        <select required class="tom-select w-full" name="hotel_id" id="hotel_id">
                                            <option disabled selected>Select Hotel</option>
                                            @foreach($hotels AS $hotel)
                                                <option value="{{$hotel->id}}" {{ $hotel->id ==  $accommodation->hotel_id ? 'selected' : ''}}>{{ $hotel->name }} | NGN {{$hotel->price}} |
                                                    -- Remaining {{ $hotel->no_rooms_available }} | {{$hotel->address}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 ">
                                        <label for="quantity" class="form-label">Number of Nights</label>
                                        <select required class="tom-select w-full" name="quantity" id="quantity">
                                            <option disabled>Select Number of Nights</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ ($i == $accommodation->quantity) ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>

                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mt-3 ">
                                        <label for="res_type" class="form-label">Reservation Type</label>
                                        <select required class="tom-select w-full" name="res_type" id="res_type">
                                            <option value="pay" {{ $res_type == 'pay' ? 'selected' : '' }}>Pay Now</option>
                                            <option value="reserve" {{ $res_type == 'reserve' ? 'selected' : '' }}>Reserve</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-right mt-5">
                                    <button type="submit" class="btn btn-primary w-64 mt-2">Proceed</button>
                                    <a href="{{ route('user.events.index')  }}" class="btn btn-danger-soft w-32 mt-2">Back</a>
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
@endsection

