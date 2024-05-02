@extends('layouts.main')

@section('title')
    Register
@endsection

@section('content')
Musisz potwierdzić e-maila! Aby wysłać wiadomość z linkiem kliknij przycisk poniżej! <br>
@if (Session::has('emailStatus'))
<div id="notification">
    <br>
    Wiadomość została wysłana! <button id="close" onclick="document.getElementById('notification').remove()">zamknij</button>
</div>
@endif
<br>
<form action="{{ route("email.send") }}" method="get">
    @csrf
    <button>Wyślij wiadomość</button>
</form>
@endsection