@extends('layouts.main')

@section('title')
    Login
@endsection

@section('content')
<form action="#" method="post">
    <label for="email">E-Mail</label><br>
    <input type="email" id="email"><br><br>
    <label for="password">Password</label><br>
    <input type="password" id="password"><br><br>
    <button>Login</button>
</form>
@endsection