@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
    @include('shared.alert')
    <p>
        <a href="/admin/users/create" class="btn btn-outline-success">
            <i class="fas fa-plus-circle mr-1"></i>Create new user
        </a>
    </p>
    <form method="get" action="/admin/users" id="searchForm">
        <div class="row">
            <div class="col-sm-8 mb-2">
                <input type="text" class="form-control" name="uname" id="uname"
                       placeholder="Filter Name Or email">
            </div>
            <div class="col-sm-4 mb-2">
                <select class="form-control" name="order[]" id="order">
                    <option value="id" {{ (request()->order == 'id' ? 'selected' : '') }}>All genres</option>
                    <option value="name" {{ (request()->order == 'name' ? 'selected' : '') }}>Name A &hookrightarrow; Z</option>
                    <option value="dname" {{ (request()->order == 'dname' ? 'selected' : '') }}>Name Z &hookrightarrow; A</option>
                    <option value="email" {{ (request()->order == 'email' ? 'selected' : '') }}>Email A &hookrightarrow; Z</option>
                    <option value="demail" {{ (request()->order == 'demail' ? 'selected' : '') }}>Email Z &hookrightarrow; A</option>
                    <option value="active" {{ (request()->order == 'active' ? 'selected' : '') }}>Not Active</option>
                    <option value="admin" {{ (request()->order == 'admin' ? 'selected' : '') }}>Admin</option>
                </select>
            </div>
        </div>
    </form>
    @if ($users->count() == 0)
        <div class="alert alert-danger alert-dismissible fade show">
            Can't find any user with <b>'{{ request()->uname }}'</b>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
    {{ $users->withQueryString()->links() }}
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->active == 1)
                            <i class="fas fa-check"></i>
                        @endif
                    </td>
                    <td>
                        @if($user->admin == 1)
                            <i class="fas fa-check"></i>
                        @endif
                    </td>
                    <td>
                        <form action="/admin/users/{{ $user->id }}" method="post">
                            @method('delete')
                            @csrf
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->name }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger deleteUser"
                                        data-toggle="tooltip"
                                        data-name="{{$user->name}}"
                                        title="Delete {{ $user->name }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->withQueryString()->links() }}
    </div>
@endsection
@section('script_after')
    <script>
        $('.deleteUser').click(function () {
            const name = $(this).data('name');
            let msg = `Delete this user with name: ${name}?`;
            if (confirm(msg)) {
                $(this).closest('form').submit();
            }
        })
        $('#uname').blur(function () {
            $('#searchForm').submit();
        });
        $('#order').change(function () {
            $('#searchForm').submit();
        });
    </script>
@endsection
