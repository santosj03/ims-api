<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Users\Models\UserStatus;
use Modules\Configurations\Domain\ConfigDomain;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Modules\Configurations\Services\ConfigurationService;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;

class Siteuser
{
    public function __construct()
    {
        $this->guard = 'api';
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authGuard = auth($this->guard);
        $user = \Auth::user();
        try {
            if (!$authGuard->check())
                return response()->json(['message' => 'Invalid token.'], 403);
            if ($user->status_id == UserStatus::whereName('Locked')->first()['id'])
                return response()->json(['message' => 'Account Locked. Please reset your password.'], 400);
            if ($user->blocked_at)
                return response()->json(['message' => 'Account Blocked.'], 400);
            // if (!$user->verified_at)
            //     return (new ApiResponse)->forbidden('Account Not Verified.');
            if (
                ($user->last_login != null && Carbon::parse($user->last_login)->addDays(ConfigurationService::param(ConfigDomain::ACCOUNT_INACTIVITY)) <= Carbon::now()) && 
                ($user->updated_at != null && Carbon::parse($user->updated_at)->addDays(ConfigurationService::param(ConfigDomain::ACCOUNT_INACTIVITY)) <= Carbon::now())
            ) {
                $user->lock(); // not yet working
                return response()->json(['message' => 'Account Locked due to inactivity.'], 400);
            }

            if ($user->last_login && date('Y-m-d H:i:s', auth()->getPayload()->get('iat')) < $user->last_login) {
                auth()->invalidate(); // to invalidate the concurrent user
                return response()->json(['message' => 'Multiple session is not allowed.'], 400);
            }
            \Auth::shouldUse($this->guard);
        } catch (JWTException $e) {
            if ($e instanceof TokenExpiredException)
                return response()->json(['message' => 'Token Expired'], 403);
            else
                return response()->json(['message' => 'Invalid token.'], 403);
        }

        return $next($request);
    }
}
