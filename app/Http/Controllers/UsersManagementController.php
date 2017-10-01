<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Traits\CaptureIpTrait;
use Auth;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;

class UsersManagementController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        return View('usersmanagement.show-users', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        $data = [
            'roles' => $roles,
        ];

        return view('usersmanagement.create-user')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'scoutname'             => 'required|max:255',
                'first_name'            => 'required|max:255',
                'last_name'             => 'required|max:255',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required',
            ],
            [
                'scoutname.required'    => trans('auth.scoutNameRequired'),
                'first_name.required'   => trans('auth.fNameRequired'),
                'last_name.required'    => trans('auth.lNameRequired'),
                'password.required'     => trans('auth.passwordRequired'),
                'password.min'          => trans('auth.PasswordMin'),
                'password.max'          => trans('auth.PasswordMax'),
                'role.required'         => trans('auth.roleRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ipAddress = new CaptureIpTrait();
        $profile = new Profile();

        $user = User::create([
            'scoutname'              => $request->input('scoutname'),
            'first_name'             => $request->input('first_name'),
            'last_name'              => $request->input('last_name'),
            'name_gen'               => $request->input('first_name').'_'.$request->input('scoutname').'_'.$request->input('last_name'),
            'password'               => bcrypt($request->input('password')),
            'token'                  => str_random(64),
            'admin_ip_address'       => $ipAddress->getClientIp(),
            'activated'              => 1,
        ]);

        $user->profile()->save($profile);
        $user->attachRole($request->input('role'));
        $user->save();

        return redirect('users')->with('success', trans('usersmanagement.createSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('usersmanagement.show-user')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        foreach ($user->roles as $user_role) {
            $currentRole = $user_role;
        }

        $data = [
            'user'          => $user,
            'roles'         => $roles,
            'currentRole'   => $currentRole,
        ];

        return view('usersmanagement.edit-user')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currentUser = Auth::user();
        $user = User::find($id);
        $ipAddress = new CaptureIpTrait();

        $validator = Validator::make($request->all(), [
            'scoutname'       => 'nullable|string|max:255',
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'password'        => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $name_gen = (($request->input('scoutname') != null) ? $request->input('first_name').'_'.$request->input('scoutname').'_'.$request->input('last_name') : $request->input('first_name').'_'.$request->input('last_name'));

        $user->scoutname = $request->input('scoutname');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->name_gen = $name_gen;

        if ($request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->detachAllRoles();
        $user->attachRole($request->input('role'));
        $user->updated_ip_address = $ipAddress->getClientIp();
        $user->save();

        return back()->with('success', trans('usersmanagement.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = Auth::user();
        $user = User::findOrFail($id);
        $ipAddress = new CaptureIpTrait();

        if ($user->id != $currentUser->id) {
            $user->deleted_ip_address = $ipAddress->getClientIp();
            $user->save();
            $user->delete();

            return redirect('users')->with('success', trans('usersmanagement.deleteSuccess'));
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }
}
