@extends('layouts.main')

@section('title')
    Register
@endsection

@section('content')

@if($message==="noToken")
Token nie został podany!
@elseif($message==="tokenNotFound")
Podany token nie znajduje się w bazie!
@elseif($message==="userNotFound")
Do podanego tokenu nie jest przypisany żaden użydkownik!
@elseif($message==="tokenTimeOut")
Podany token stracił ważność! Musisz wygenerować nowy.
@elseif($message==="success")
Konto zostało zweryfikowane!
@endif

@endsection