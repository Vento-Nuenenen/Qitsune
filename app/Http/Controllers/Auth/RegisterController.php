<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
<<<<<<< HEAD
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
=======
            'scoutname' => 'nullable|string|max:255',
            'prename'   => 'required|string|max:255',
            'surname'   => 'required|string|max:255',
            'password'  => 'required|string|min:6|confirmed',
>>>>>>> 7438213845ceba112fcc6f2cc51850bb38b0d39b
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
<<<<<<< HEAD
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
=======
        $name_gen = (($data['scoutname'] != null) ? $data['prename'].'_'.$data['scoutname'].'_'.$data['surname'] : $data['prename'].'_'.$data['surname']);

        return User::create([
            'scoutname' => $data['scoutname'],
            'prename'   => $data['prename'],
            'surname'   => $data['surname'],
            'name_gen'  => $name_gen,
            'password'  => bcrypt($data['password']),
>>>>>>> 7438213845ceba112fcc6f2cc51850bb38b0d39b
        ]);
    }
}
