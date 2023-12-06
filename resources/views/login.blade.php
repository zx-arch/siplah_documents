<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('img/siplah_icon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('css/style-login.css')}}">
    <title>Siplah Document | Login</title>
    <style>
        
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" action="{{ url('login') }}" method="POST">
            @csrf
            <input type="text" class="username" placeholder="Username" name="username" id="username" required>

            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        @if (Session::has('warning'))
            <p style="color: red;">* {{Session::get('warning')}}</p>
            {{Session::forget('warning')}}
        @elseif (Session::has('info'))
            <p style="color: red;">* {{Session::get('info')}}</p>
            {{Session::forget('info')}}
        @elseif (Session::has('invalid'))
            <p style="color: red;">* {{Session::get('invalid')}}</p>
        @elseif (Session::has('logout_success'))
            <p style="color: orange; font-weight:bold;">{{Session::get('logout_success')}}</p>
            {{Session::forget('info')}}
        @endif
    </div>
</body>
</html>
