<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\NotifyMailValidated;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => function($attribute,$value,$fail){
                $secretKey = config('services.recaptcha.secret');
                $response = $value;
                $userIP = $_SERVER["REMOTE_ADDR"];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIP";
                $response = \file_get_contents($url);
                $response = json_decode($response);
                if(!$response->success){
                    Session::flash('g-recaptcha-response','recaptcha-failed');
                    Session::flash('alert-class','alert-danger');
                   $fail($attribute.' Google recaptcha failed');
                }
            }
        ]);

        $credentials = $request->only('user', 'password');
        if (Auth::attempt($credentials)) {
            if(empty(Auth::user()->email_verified_at)){
                $user = User::find(Auth::user()->id);
                Mail::to(Auth::user()->email)->send(new NotifyMailValidated($user));
                Session::flush();
                Auth::logout();
                return redirect("login")->with('custom-error','auth.not_validated_email');
            }
            return redirect()->intended('panel')->with('success','auth.correct_login');

        }

        return redirect("login")->with('custom-error','auth.invalid_credential');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {
        //
        return false;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard.dashboard');
        }

        return redirect("login")->with('custom-error','auth.not_login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect::home();
    }


    public static function getUserLogin(){
        return Auth::user();
    }

    public function validate_email($id){
        try {
            $user = User::findOrFail(Crypt::decryptString($id));
            $user->email_verified_at = now();
            $user->save();
            Auth::login($user);
            return redirect()->intended('panel')->with('success','auth.correct_verify');
        } catch (DecryptException $th) {
            return Redirect::to('login')->with('custom-error', 'generic.invalid_credential');
        }
    }
}
