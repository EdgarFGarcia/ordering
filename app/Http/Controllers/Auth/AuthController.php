<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\PublicController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Teepluss\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AuthController extends PublicController
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
    public function postLogin(Request $request)
    {

        $max_attempts = 3;

        $session_attempts = $request->session()->get('throttle_attempts');
        $ctr = (string) ($session_attempts + 1);
        $request->session()->set('throttle_attempts', (string)$ctr);
        $session_attempts = $request->session()->get('throttle_attempts');

        if($session_attempts <= $max_attempts) {
            // get our login input
            $login = $request->username;

            // check login field
            $login_type = filter_var( $login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
            // merge our login field into the request with either email or username as key
            $request->merge([ $login_type => $login ]);
            // let's validate and set our credentials

            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);

            $credentials = $request->only( 'username', 'password' );

            $credentials = array(
                "username" => array(
                    "value"=> Input::get("username"),
                    "operator"=> "=",
                ),
                "password" => array(
                    "value"=> Input::get("password"),
                    "operator"=> "=",
                ),
                "is_active" => array(
                    "value"=> "1",
                    "operator"=> "=",
                )
            );
//            $credentials['status'] = array("value"=>"Inactive","operator"=>"<>");
            if (Auth::attempt($credentials, $request->has('remember')))
            {
                $request->session()->forget('throttle_attempts');
                $request->session()->forget('login_locked_out_expiration');
//                $this->recoredHistory("LOGIN","USERNAME: ".$login.", NAME: ".Auth::user()->fname." ".Auth::user()->lname);
                if(Auth::user()->role_id=="3"){
                    return redirect()->intended('dashboard');
                } else {
                    $inc = DB::select(DB::raw("SELECT MD5(CONCAT('victoriacourt','".Auth::user()->username."')) as bcruser"));
                    $use = "";
                    foreach ($inc as $aRow) {
                        $use = $aRow->bcruser;
                    }
                    return redirect()->intended('room/employee');
                }
            }

//            dd(Auth::check());
            return redirect('/')->withErrors('These credentials do not match our records.');

        } else {
            $request->session()->put('login_locked_out_expiration', strtotime("+5 minutes"));
            $request->session()->set('throttle_attempts', "0");
            return redirect()->away('tryAgain');
        }
    }
    public function recoredHistory($module,$desc)
    {
        DB::table("vc_acctlog")
            ->insert(array(
                "log_type" => $module,
                "log_desc" => $desc,
                "createdby" => Auth::user()->fname." ".Auth::user()->lname,
            ));
    }
    public function tryAgain(){
        return view('errors.login');
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
