@extends('layouts.main')

@section('title')
    Register
@endsection

@section('content')
<form action="{{ route("user.register") }}" method="post">
    @csrf
    <label for="name">Name</label><br>
    <input type="text" name="name" id="name" required><br><br>
    <label for="email">E-Mail</label><br>
    <input type="email" name="email" id="email" required><br><br>
    <label for="password">Password</label><br>
    <input type="password" name="password" id="password" required><br><br>
    <label for="rpassword">Repeat password</label><br>
    <input type="password" name="rpassword" id="rpassword" required><br><br>
    <button>Login</button>
</form>
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection