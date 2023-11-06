@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Register For Event'])
        <!-- END: Top Bar -->
        <div class="flex items-center mt-8">
            <h2 class="intro-y text-lg font-medium mr-auto">
                Register for Event
            </h2>
        </div>
        <!-- BEGIN: Wizard Layout -->
        <div class="intro-y box sm:py-20">
            <div class="px-5 sm:px-20 border-slate-200/60 dark:border-darkmode-400">
                <div class="font-medium text-base">Profile Settings</div>
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">From</label>
                        <input id="input-wizard-1" type="text" class="form-control" placeholder="example@gmail.com">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-2" class="form-label">To</label>
                        <input id="input-wizard-2" type="text" class="form-control" placeholder="example@gmail.com">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-3" class="form-label">Subject</label>
                        <input id="input-wizard-3" type="text" class="form-control" placeholder="Important Meeting">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-4" class="form-label">Has the Words</label>
                        <input id="input-wizard-4" type="text" class="form-control"
                               placeholder="Job, Work, Documentation">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Doesn't Have</label>
                        <input id="input-wizard-5" type="text" class="form-control"
                               placeholder="Job, Work, Documentation">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Size</label>
                        <select id="input-wizard-6" class="form-select">
                            <option>10</option>
                            <option>25</option>
                            <option>35</option>
                            <option>50</option>
                        </select>
                    </div>
                    <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                        <button class="btn btn-secondary w-24">Previous</button>
                        <button class="btn btn-primary w-24 ml-2">Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Wizard Layout -->
    </div>

@endsection