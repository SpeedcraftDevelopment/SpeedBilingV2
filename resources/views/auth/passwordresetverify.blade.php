@extends('layouts.main')

@section('title')
    Register
@endsection

@section('content')
<h1>Resetowanie hasła</h1>
<form action="{{ route("user.resetpassword.submit") . "?token=" . $token }}" method="POST">
    @csrf
    <label for="newPass1">Podaj nowe hasło</label>
    <input type="password" name="newPass" id="newPass1">
    <label for="newPass2">Podaj nowe hasło ponownie</label>
    <input type="password" id="newPass2">
    <button>Zresetuj hasło</button>
</form>
@endsection