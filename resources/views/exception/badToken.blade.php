@if($message==="noToken")
Nie podano tokenu!
@elseif($message==="tokenNotFound")
Taki token nie widnieje w bazie!
@elseif($message==="userNotFound")
Nie znaleziono użytkownika z którym jest powiązany token!
@elseif($message==="tokenNotForThisUser")
Ten token jest przypisany do innego użytkownika!
@elseif($message==="tokenTimeOut")
Podany token wygasł! Jeżeli chcesz zrestartować swoje hasło musisz wygenerować kolejny.
@endif