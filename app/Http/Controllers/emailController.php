<?php

namespace App\Http\Controllers;

use App\Models\EmailTokenVeryfication;
use App\Mail\AccountVerificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class emailController extends Controller
{
    public function accountVeryficationPage()
    {
        return view("auth.emailVeryfication");
    }

    public function accountVeryficationEmailSend(Request $request)
    {

        $user = User::find(Auth::user()->id);

        if ($user->email_verified_at !== null) {
            return back();
        }

        $token = EmailTokenVeryfication::where("user_id", $user->id)->first();
        if (!$token || Carbon::now()->subMinutes(30)->timestamp > $token->created_at->timestamp) {

            EmailTokenVeryfication::where("user_id", $user->id)->delete();

            $token = new EmailTokenVeryfication();

            $token->user_id = $user->id;
            $token->token = $this->RandomString();

            $token->save();
        }

        $mail = new AccountVerificationMail($token);
        Mail::to(Auth::user())->send($mail);

        return redirect(route("email.veryfication-page"))->with("emailStatus", "sended");
    }

    private function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randstring = "";
        for ($i = 0; $i < 20; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    public function accountVeryficationVerify(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $user->email_verified_at = Carbon::now()->timestamp;

        $user->save();

        return view("auth.emailVeryficationResult", ["user" => $user, "token" => $request->token, "success" => true, "message" => "success"]);
    }
}
