<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <div class="card">
        <div class="logo"><span>Task</span> Manager</div>
        <div class="subtitle">Manage your tasks with ease</div>
        <a href="{{ route('login') }}" class="btn btn-user">Login as User</a>
        <a href="{{ route('admin.login') }}" class="btn btn-admin">Login as Admin</a>
    </div>
</body>
</html>
