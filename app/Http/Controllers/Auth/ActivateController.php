<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Activation;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use jeremykenedy\LaravelRoles\Models\Role;

class ActivateController extends Controller
{
    use ActivationTrait;

    private static $userHomeRoute = 'public.home';
    private static $adminHomeRoute = 'public.home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getUserHomeRoute()
    {
        return self::$userHomeRoute;
    }

    public static function getAdminHomeRoute()
    {
        return self::$adminHomeRoute;
    }

    public static function activeRedirect($user, $currentRoute)
    {
        if ($user->activated) {
            Log::info('Activated user attempted to visit '.$currentRoute.'. ', [$user]);

            if ($user->isAdmin()) {
                return redirect()->route(self::getAdminHomeRoute())
                ->with('status', 'info')
                ->with('message', trans('auth.alreadyActivated'));
            }

            return redirect()->route(self::getUserHomeRoute())
                ->with('status', 'info')
                ->with('message', trans('auth.alreadyActivated'));
        }

        return false;
    }

    public function initial()
    {
        $user = Auth::user();
        $lastActivation = Activation::where('user_id', $user->id)->get()->last();
        $currentRoute = Route::currentRouteName();

        $rCheck = $this->activeRedirect($user, $currentRoute);
        if ($rCheck) {
            return $rCheck;
        }

        $data = [
            'date'  => $lastActivation->created_at->format('m/d/Y'),
        ];

        return view($this->getActivationView())->with($data);
    }
}
