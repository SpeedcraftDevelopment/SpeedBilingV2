<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\ResetPasswordToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class authController extends Controller
{

    private function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randstring = "";
        for ($i = 0; $i < 20; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }


    //                                                    TWORZENIE KONTA
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'rpassword' => 'required',
        ]);

        if (!$validated) {
            return back()->withErrors([
                'data' => "Sended data is not correct",
            ]);
        }

        if (User::where('email', $request->input("email"))->first()) {
            return back()->withErrors([
                'email' => "Account with that e-mail already exists!",
            ]);
        }
        if (User::where('name', $request->input("name"))->first()) {
            return back()->withErrors([
                'name' => "Account with that name already exists!",
            ]);
        }
        if ($validated["password"] !== $validated["rpassword"]) {
            return back()->withErrors([
                'password' => "Passwords are not the same!",
            ]);
        }
        if (strlen($validated["password"]) >= 10 && preg_match('`[^0-9a-zA-Z]`', $validated["password"])) {
            return back()->withErrors([
                'password' => "Passwords need to be least 10 chearacter long, has almost one small and big letter and almost one number.",
            ]);
        }

        $user = new User();

        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->password = $validated["password"];

        $user->save();

        Auth::login($user);

        return redirect(route("main"));
    }
    public function createPage()
    {
        return view("auth.register");
    }


    //                                                                       LOGOWANIE SIĘ DO KONTA
    public function login(Request $request)
    {

        $user = User::where('email', $request->input("email"))->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $pass = $request->input("password");

        if (Hash::check($pass, $user->password)) {
            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended(route("main"));
        }
        return back()->withErrors([
            'password' => 'The provided credentials do not match our records.',
        ]);
    }

    public function loginPage()
    {
        return view("auth.login");
    }


    //                                                       WYLOGOWYWANIE SIĘ Z KONTA
    public function logout()
    {
        Auth::logout();
        return redirect(route("main"));
    }


    //                                                           RESETOWANIE HASŁA
    public function resetPasswordSendEmail()
    {
        $user = Auth::user();

        $token = ResetPasswordToken::where("user_id", $user->id)->first();
        if (!$token || Carbon::now()->subMinutes(30)->timestamp > $token->created_at->timestamp) {

            ResetPasswordToken::where("user_id", $user->id)->delete();

            $token = new ResetPasswordToken();

            $token->user_id = $user->id;
            $token->token = $this->RandomString();

            $token->save();
        }

        $mail = new ResetPasswordMail($token);
        Mail::to($user)->send($mail);

        return back()->with("emailStatus", "sended");
    }

    public function resetPasswordPage()
    {
        return view("auth.passwordreset");
    }

    public function resetPasswordPageVerify(Request $request)
    {
        return view("auth.passwordresetverify", ["token" => $request->token]);
    }

    public function resetPasswordPageSubmit(Request $request)
    {
        if (!$request->has("newPass")) {
            return view("auth.emailVeryficationResult", ["user" => null, "token" => null, "success" => false, "message" => "noNewPass"]);
        }

        $newPass = $request->newPass;
        if (
            strlen($newPass) >= 10 &&
            preg_match('`[^0-9a-zA-Z]`', $newPass)
        ) {
            return view("auth.emailVeryficationResult", ["user" => null, "token" => null, "success" => false, "message" => "newPassNotMachPatern"]);
        }

        $user = User::find(Auth::user()->id);

        $user->password = $newPass;

        $user->save();

        ResetPasswordToken::where("token", $request->token)->delete();

        return redirect(route("main"))->with(["alert" => "Change password success!"]);
    }
}
