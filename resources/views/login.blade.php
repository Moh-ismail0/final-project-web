<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container" style="max-width: 400px">
        <div class="card">
            <h2 style="text-align: center">Login</h2>

            {{-- عرض الأخطاء --}}
            @if($errors->any())
                <div style="color:red; margin-bottom:10px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <label>Email</label>
                <input type="email" name="email" placeholder="example@email.com"/>

                <label>Password</label>
                <input type="password" name="password" placeholder="********"/>

                <button style="width:100%">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
