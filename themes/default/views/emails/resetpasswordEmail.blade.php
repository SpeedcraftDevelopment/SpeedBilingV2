<div>To jest e-mail do resetowania hasła</div>
<a href="{{ route("user.resetpassword.reset") . "?token=" . $token->token }}">Zresetuj hasło</a>