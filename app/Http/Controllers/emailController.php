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
    public function accountVeryficationPage(){
        if(!Auth::check()){
            return redirect()->route("user.login");
        }
        if(Auth::user()->email_verified_at){
            return redirect()->route("user.login");
        }
        return view("auth.emailVeryfication");
    }

    public function accountVeryficationEmailSend(Request $request){
        if(!Auth::check()){
            return redirect()->route("user.login");
        }
        if(Auth::user()->email_verified_at){
            return redirect()->route("main");
        }

        $user = User::find(Auth::user()->id);

        if($user->email_verified_at!==null){
            return back();
        }

        $token = EmailTokenVeryfication::where("user_id", $user->id)->first();
        if(!$token || Carbon::now()->subMinutes(30)->timestamp > $token->created_at->timestamp){

            EmailTokenVeryfication::where("user_id", $user->id)->delete();

            $token = new EmailTokenVeryfication();

            $token->user_id = $user->id;
            $token->token = $this->RandomString();

            $token->save();
        }
        
        $mail = new AccountVerificationMail($token);
        Mail::to(Auth::user())->queue($mail);

        return redirect(route("email.veryfication-page"))->with("emailStatus", "sended");
    }

    private function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randstring = "";
        for ($i = 0; $i < 20; $i++) {
            $randstring .= $characters[rand(0, strlen($characters)-1)];
        }
        return $randstring;
    }

    public function accountVeryficationVerify(Request $request){
        if(!$request->has("token")){
            return view("auth.emailVeryficationResult", ["user" => null, "token" => null, "success"=>false, "message"=>"noToken"]);
        }
        $URLtoken = $request->token;
        $token = EmailTokenVeryfication::where("token", $URLtoken)->first();

        if(!$token){
            return view("auth.emailVeryficationResult", ["user" => null, "token" => null, "success"=>false, "message"=>"tokenNotFound"]);
        }

        $user = User::where("id", $token->user_id)->first();

        if(!$user){
            return view("auth.emailVeryficationResult", ["user" => null, "token" => null, "success"=>false, "message"=>"userNotFound"]);
        }

        if(Carbon::now()->subMinutes(30)->timestamp > $token->created_at->timestamp){
            return view("auth.emailVeryficationResult", ["user" => $user, "token" => null, "success"=>false, "message"=>"tokenTimeOut"]);
        }

        $user -> email_verified_at = Carbon::now()->timestamp;

        $user->save();


        return view("auth.emailVeryficationResult", ["user" => $user, "token" => $URLtoken, "success"=>true, "message"=>"success"]);

    }
}
