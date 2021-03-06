<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use App\Notifications\SendGoodbyeEmail;
use App\Traits\CaptureIpTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use jeremykenedy\Uuid\Uuid;
use Validator;
use View;

class ProfilesController extends Controller
{
    protected $idMultiKey = '618423'; //int
    protected $seperationKey = '****';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function profile_validator(array $data)
    {
        return Validator::make($data, [
            'theme_id'         => '',
        ]);
    }

    /**
     * Fetch user
     * (You can extract this to repository method).
     *
     * @param $username
     *
     * @return mixed
     */
    public function getUserByUsername($name_gen)
    {
        return User::with('profile')->where('name_gen', $name_gen)->firstOrFail();
    }

    /**
     * Display the specified resource.
     *
     * @param string $username
     *
     * @return Response
     */
    public function show($name_gen)
    {
        try {
            $user = $this->getUserByUsername($name_gen);
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }

        $currentTheme = Theme::find($user->profile->theme_id);

        $data = [
            'user'         => $user,
            'currentTheme' => $currentTheme,
        ];

        return view('profiles.show')->with($data);
    }

    /**
     * /profiles/username/edit.
     *
     * @param $name_gen
     *
     * @return mixed
     */
    public function edit($name_gen)
    {
        try {
            $user = $this->getUserByUsername($name_gen);
        } catch (ModelNotFoundException $exception) {
            return view('pages.status')
                ->with('error', trans('profile.notYourProfile'))
                ->with('error_title', trans('profile.notYourProfileTitle'));
        }

        $themes = Theme::where('status', 1)
                        ->orderBy('name', 'asc')
                        ->get();

        $currentTheme = Theme::find($user->profile->theme_id);

        $data = [
            'user'         => $user,
            'themes'       => $themes,
            'currentTheme' => $currentTheme,

        ];

        return view('profiles.edit')->with($data);
    }

    /**
     * Update a user's profile.
     *
     * @param $name_gen
     * @param Request $request
     *
     * @return mixed
     */
    public function update($name_gen, Request $request)
    {
        $user = $this->getUserByUsername($name_gen);

        $ipAddress = new CaptureIpTrait();

        $profile_validator = $this->profile_validator($request->all());

        if ($profile_validator->fails()) {
            return back()->withErrors($profile_validator)->withInput();
        }

        $profile = new Profile();
        $user->profile()->save($profile);

        $user->updated_ip_address = $ipAddress->getClientIp();

        $user->save();

        return redirect('profile/'.$user->name_gen.'/edit')->with('success', trans('profile.updateSuccess'));
    }

    /**
     * Get a validator for an incoming update user request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'scoutn_name' => 'max:255',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateUserAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $ipAddress = new CaptureIpTrait();
        $name_gen = (($request->input('scout_name') != null) ? $request->input('first_name').'_'.$request->input('scout_name').'_'.$request->input('last_name') : $request->input('first_name').'_'.$request->input('last_name'));

        $validator = Validator::make($request->all(), [
            'scout_name' => 'max:255',
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
        ]);

        $rules = [];

        $validator = $this->validator($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->scout_name = $request->input('scout_name');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->name_gen = $name_gen;

        $user->updated_ip_address = $ipAddress->getClientIp();

        $user->save();

        return redirect('profile/'.$user->name_gen.'/edit')->with('success', trans('profile.updateAccountSuccess'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateUserPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $ipAddress = new CaptureIpTrait();

        $validator = Validator::make($request->all(),
            [
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
            ],
            [
                'password.required' => trans('auth.passwordRequired'),
                'password.min'      => trans('auth.PasswordMin'),
                'password.max'      => trans('auth.PasswordMax'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        $user->save();

        return redirect('profile/'.$user->name_gen.'/edit')->with('success', trans('profile.updatePWSuccess'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUserAccount(Request $request, $id)
    {
        $currentUser = \Auth::user();
        $user = User::findOrFail($id);
        $ipAddress = new CaptureIpTrait();

        $validator = Validator::make($request->all(),
            [
                'checkConfirmDelete' => 'required',
            ],
            [
                'checkConfirmDelete.required' => trans('profile.confirmDeleteRequired'),
            ]
        );

        if ($user->id != $currentUser->id) {
            return redirect('profile/'.$user->name_gen.'/edit')->with('error', trans('profile.errorDeleteNotYour'));
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create and encrypt user account restore token
        $sepKey = $this->getSeperationKey();
        $userIdKey = $this->getIdMultiKey();
        $restoreKey = config('settings.restoreKey');
        $encrypter = config('settings.restoreUserEncType');
        $level1 = $user->id * $userIdKey;
        $level2 = urlencode(Uuid::generate(4).$sepKey.$level1);
        $level3 = base64_encode($level2);
        $level4 = openssl_encrypt($level3, $encrypter, $restoreKey);
        $level5 = base64_encode($level4);

        // Save Restore Token and Ip Address
        $user->token = $level5;
        $user->deleted_ip_address = $ipAddress->getClientIp();
        $user->save();

        // Soft Delete User
        $user->delete();

        // Clear out the session
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/login/')->with('success', trans('profile.successUserAccountDeleted'));
    }

    /**
     * Send GoodBye Email Function via Notify.
     *
     * @param array  $user
     * @param string $token
     *
     * @return void
     */
    public static function sendGoodbyEmail(User $user, $token)
    {
        $user->notify(new SendGoodbyeEmail($token));
    }

    /**
     * Get User Restore ID Multiplication Key.
     *
     * @return string
     */
    public function getIdMultiKey()
    {
        return $this->idMultiKey;
    }

    /**
     * Get User Restore Seperation Key.
     *
     * @return string
     */
    public function getSeperationKey()
    {
        return $this->seperationKey;
    }
}
