<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

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
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
<<<<<<< HEAD
            'scoutname' => 'string|max:255',
	        'prename' => 'required|string|max:255',
	        'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
=======
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
>>>>>>> 4198d22b911a4e33da63b0312e71fcb7bb32cb23
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
<<<<<<< HEAD
            'scoutname' => $data['scoutname'],
	        'prename' => $data['prename'],
	        'surname' => $data['surname'],
	        'name_gen' => $data['name'],
            'email' => $data['email'],
=======
            'name'     => $data['name'],
            'email'    => $data['email'],
>>>>>>> 4198d22b911a4e33da63b0312e71fcb7bb32cb23
            'password' => bcrypt($data['password']),
        ]);
    }
}
