<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use ActivationTrait;
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/activate';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => 'logout',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
            [
                'scout_name'            => 'max:255',
                'first_name'            => 'required|max:255',
                'last_name'             => 'required|max:255',
                'password'              => 'required|min:6|max:30|confirmed',
                'password_confirmation' => 'required|same:password',
                'captcha'               => 'required|min:1',
            ],
            [
                'first_name.required'           => trans('auth.fNameRequired'),
                'last_name.required'            => trans('auth.lNameRequired'),
                'password.required'             => trans('auth.passwordRequired'),
                'password.min'                  => trans('auth.PasswordMin'),
                'password.max'                  => trans('auth.PasswordMax'),
                'g-recaptcha-response.required' => trans('auth.captchaRequire'),
                'captcha.min'                   => trans('auth.CaptchaWrong'),
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $ipAddress = new CaptureIpTrait();
        $role = Role::where('slug', '=', 'user')->first();

        $name_gen = (($data['scout_name'] != null) ? $data['first_name'].'_'.$data['scout_name'].'_'.$data['last_name'] : $data['first_name'].'_'.$data['last_name']);

        $user = User::create([
                'scout_name'        => $data['scout_name'],
                'first_name'        => $data['first_name'],
                'last_name'         => $data['last_name'],
                'name_gen'          => $name_gen,
                'password'          => Hash::make($data['password']),
                'token'             => str_random(64),
                'signup_ip_address' => $ipAddress->getClientIp(),
                'activated'         => !config('settings.activation'),
            ]);

        $user->attachRole($role);
        $this->initiateEmailActivation($user);

        return $user;
    }
}
