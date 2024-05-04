@extends('layouts.main')

@section('title')
    Register
@endsection

@section('content')
Chcesz zresetować hasło? Kliknij przycisk niżej! <br>
@if (Session::has('emailStatus'))
<div id="notification">
    <br>
    Wiadomość została wysłana! <button id="close" onclick="document.getElementById('notification').remove()">zamknij</button>
</div>
@endif
<br>
<form action="{{ route("user.resetpassword.sende-mail") }}" method="get">
    @csrf
    <button>Wyślij wiadomość</button>
</form>
@endsection