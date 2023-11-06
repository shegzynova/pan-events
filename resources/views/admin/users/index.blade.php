@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Users'])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Users
        </h2>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> 
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x"
                                                                                                      class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-md mr-2">Add New User</a>
                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4"
                                                                                   data-lucide="plus"></i> </span>
                    </button>
                    @include('admin.layouts.export', ['type' => 'users'])
                </div>

                @if($users)
                    <div class="hidden md:block mx-auto text-slate-500">
                        @if ($users->count() > 0)
                            Showing {{ ($users->currentPage() - 1) * $users->perPage() + 1 }}
                            to {{ ($users->currentPage() - 1) * $users->perPage() + $users->count() }}
                            of {{ $users->total() }} entries
                        @else
                            No entries found.
                        @endif
                    </div>
                @endif

                <div class="w-full xl:w-auto mt-3 xl:mt-0  col-span-12">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center" name="searchForm">
                        <div class="w-full sm:w-auto flex items-center mb-2 sm:mb-0 xl:mr-3">
                            <div class="w-full relative text-slate-500">
                                <input type="text" name="query" class="form-control w-full box pr-10" placeholder="Search name, username, email, phone..." value="{{ $query }}">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                            </div>
                        </div>

                        <div class="w-full sm:w-auto flex items-center sm:mb-0 xl:mr-3">
                            <select name="role" class="w-full xl:w-auto form-select box mb-2 sm:mb-0">
                                <option value="" selected>All Roles</option>
                                <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="w-full sm:w-auto flex items-center sm:mb-0 xl:mb-0 xl:mr-3">
                            <button type="submit" class="btn btn-primary w-full xl:w-auto ml-0 mt-2 sm:mt-0">Search</button>
                        </div>

                        <div class="w-full sm:w-auto flex items-center xl:mb-0">
                            <button type="button" class="btn btn-dark w-full xl:w-auto ml-0 mt-2 sm:mt-0" onclick="clearSearch()">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                @include('flash::message')

                <div class="clearfix"></div>

                <div class="card">
                    @include('admin.users.table')
                </div>
            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->

            <!-- END: Pagination -->
        </div>
        <!-- END: Delete Confirmation Modal -->
    </div>

@endsection

@section('scripts')
    <script>
        function clearSearch() {
            document.querySelector('input[name="query"]').value = '';
            document.querySelector('select[name="role"]').selectedIndex = 0;
            document.querySelector('form[name="searchForm"]').submit();
        }
    </script>
@endsection
