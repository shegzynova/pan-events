<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="roles-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Guard</th>
                <th>Created</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $index => $role)
                <tr>
                    <td>
                        {{ $index + 1 }}
                    </td>
                    <td>{{ ucfirst(optional($role)->name) }}</td>
                    <td>{{ optional($role)->guard_name }}</td>
                    <td>
                        {!! Form::open(['route' => ['admin.settings.roles.destroy', $role->id], 'method' => 'delete']) !!}
                        <div class='flex'>
                            <a href="{{ route('admin.settings.roles.edit', [$role->id]) }}"
                               class='btn btn-default btn-xs mr-2'>
                                <i data-lucide="edit-2"></i>
                            </a>
                            {!! Form::button('<i data-lucide="trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $roles])
        </div>
    </div>
</div>
