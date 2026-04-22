@extends('layouts.admin')

@section('title', 'Admins')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admins</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- Add Admin Form --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Admin</h3>
            </div>
            <div class="card-body">
                <form id="addAdminForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-4">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Add Admin</button>
                </form>
            </div>
        </div>

        {{-- Admins Table --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Admins</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="adminsTable">
                        @foreach($admins as $admin)
                        <tr id="admin-{{ $admin->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $admin->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $admins->links() }}
                </div>

            </div>
        </div>
        {{-- Add User Form --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New User</h3>
    </div>
    <div class="card-body">
        <form id="addUserForm">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>
                <div class="col-md-4">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-4">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-success">Add User</button>
        </form>
    </div>
</div>

{{-- Users Table --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Users</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="usersTable">
                @foreach($users as $user)
                <tr id="user-{{ $user->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-user-btn" data-id="{{ $user->id }}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>

    </div>
</section>

@endsection

@section('scripts')
<script>
    // Add Admin
    $('#addAdminForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admins.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire({
                    icon: res.icon,
                    title: res.title,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            },
            error: function(err) {
                let errors = err.responseJSON.errors;
                let msg = Object.values(errors).flat().join('\n');
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // Delete Admin
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/dashboard/admins/' + id,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: res.icon,
                            title: res.title,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#admin-' + id).remove();
                        });
                    }
                });
            }
        });
    });
    // Add User
$('#addUserForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: '{{ route("users.store") }}',
        method: 'POST',
        data: $(this).serialize(),
        success: function(res) {
            Swal.fire({
                icon: res.icon,
                title: res.title,
                showConfirmButton: false,
                timer: 1500
            }).then(() => { location.reload(); });
        },
        error: function(err) {
            let errors = err.responseJSON.errors;
            let msg = Object.values(errors).flat().join('\n');
            Swal.fire('Error', msg, 'error');
        }
    });
});

// Delete User
$(document).on('click', '.delete-user-btn', function() {
    let id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/dashboard/users/' + id,
                method: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(res) {
                    Swal.fire({
                        icon: res.icon,
                        title: res.title,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => { $('#user-' + id).remove(); });
                }
            });
        }
    });
});

</script>
@endsection
