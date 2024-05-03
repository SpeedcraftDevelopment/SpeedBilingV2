<?php

namespace App\Http\Middleware;

use App\Models\EmailTokenVeryfication;
use App\Models\ResetPasswordToken;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class tokenVerifyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->has("token")) {
            return redirect(route("exception.badToken"). "?message=noToken");
        }

        $URLtoken = $request->token;
        $resetPasswordToken = ResetPasswordToken::where("token", $URLtoken)->first();
        $emailTokenVeryfication = EmailTokenVeryfication::where("token", $URLtoken)->first();

        if (!$resetPasswordToken && !$emailTokenVeryfication) {
            return redirect(route("exception.badToken"). "?message=tokenNotFound");
        }

        $token = $resetPasswordToken ? $resetPasswordToken : $emailTokenVeryfication;

        $user = User::where("id", $token->user_id)->first();

        if (!$user) {
            return redirect(route("exception.badToken"). "?message=userNotFound");
        }

        if(Auth::check()){
            if ($user->id !== Auth::user()->id) {
                return redirect(route("exception.badToken"). "?message=tokenNotForThisUser");
            }
        }

        if (Carbon::now()->subMinutes(30)->timestamp > $token->created_at->timestamp) {
            return redirect(route("exception.badToken"). "?message=tokenTimeOut");
        }

        return $next($request);
    }
}
