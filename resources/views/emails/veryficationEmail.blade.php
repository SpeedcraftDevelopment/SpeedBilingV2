<div>To jest e-mail do potwierdzenia konta</div>
<a href="{{ route("email.veryfication.link") . "?token=" . $token->token }}">Zweryfikuj</a>