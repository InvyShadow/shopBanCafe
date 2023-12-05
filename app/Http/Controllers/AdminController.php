<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\once;
use App\Rules\Captcha;
use Illuminate\Support\Facades\Validator;

session_start();

class AdminController extends Controller
{
    public function auth_login()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function index()
    {
        return view('admin_login');
    }

    public function showDashboard()
    {
        $this->auth_login();
        return view('admin.dashboard');
    }

    public function Dashboard(Request $request)
    {
//        $admin_email = $request->admin_email;
//        $admin_password = md5($request->admin_password);
//
//        $result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
//
//        if($result) {
//            Session::put('admin_name', $result->admin_name);
//            Session::put('admin_id', $result->admin_id);
//            return Redirect::to('/dashboard');
//
//        } else {
//            Session::put('message', 'Mật khẩu hoặc email bị sai!');
//            return Redirect::to('/admin');
//        }

//        $data = $request->all();

        $data = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => new Captcha(),
        ]);
        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
//        $login_count = $login->count();

        if ($login) {
            Session::put('admin_name', $login->admin_name);
            Session::put('admin_id', $login->admin_id);
            return Redirect::to('/dashboard');
        } else {
            Session::put('message', 'Mật khẩu hoặc tài khoản không đúng!');
            return Redirect::to('/admin');
        }
    }

    public function Log_out()
    {
        $this->auth_login();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }

    public function login_facebook()
    {
        return Socialite::driver('facebook')->redirect();

    }

    public function callback_facebook()
    {
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider', 'facebook')->where('provider_user_id', $provider->getId())->first();

        if ($account) {
            $account_name = Login::where('admin_id', $account->user)->first();
            Session::put('admin_name', $account_name->admin_name);
            Session::put('admin_id', $account_name->admin_id);
            return Redirect::to('/dashboard')->with('message', 'Đăng nhập admin thành công');
        } else {
            $nam = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email', $provider->getEmail())->first();

            if (!$orang) {
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => '',
                    'admin_password' => '',
                    'admin_phone' => '',
                    'admin_status' => 1
                ]);
            }
            $nam->login()->associate($orang);
            $nam->save();

            $account_name = Login::where('admin_id', $account->user)->first();

            Session::put('admin_name', $account_name->admin_name);
            Session::put('admin_id', $account_name->admin_id);
            return Redirect::to('/dashboard')->with('message', 'Đăng nhập admin thành công');

        }
    }

    public function login_google() {
        return Socialite::driver('google')->redirect();
    }

    public function callback_google() {
        $user = Socialite::driver('google')->user();

        $authUser = $this->findOrCreateUser($user, 'google');
        $account_name = Login::where('admin_id', $authUser->user)->first();
        Session::put('admin_name', $account_name->admin_name);
        Session::put('admin_id', $account_name->admin_id);
        return \redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');


    }

    public function findOrCreateUser($user, $provider) {
        $authUser = Social::where('provider_user_id', $user->id)->first();

        if ($authUser) {
            return $authUser;
        }

        $nam = new Social([
            'provider_user_id' => $user->id,
            'provider' => strtoupper($provider),

        ]);

        $orang = Login::where('admin_email', $user->email)->first();

        if (!$orang) {
            $orang = Login::create([
                'admin_name' => $user->name,
                'admin_email' => $user->email,
                'admin_password' => '',
                'admin_phone' => '',
                'admin_status' => 1,
            ]);
        }

        $nam->login()->associate($orang);
        $nam->save();

        $account_name = Login::where('admin_id', $nam->user)->first();
        Session::put('admin_name', $account_name->admin_name);
        Session::put('admin_id', $account_name->admin_id);
        return \redirect('/dashboard')->with('message', 'Đăng nhập admin thành công!');

    }
}

