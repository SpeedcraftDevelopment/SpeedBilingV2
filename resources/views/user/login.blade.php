@extends('layouts.main')

@section('title')
    Login
@endsection

@section('content')
<form action="{{ route("user.login") }}" method="post">
    @csrf
    <label for="email">E-Mail</label><br>
    <input type="email" name="email" id="email" required><br><br>
    <label for="password">Password</label><br>
    <input type="password" name="password" id="password" required><br><br>
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