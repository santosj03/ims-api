<?php

namespace Modules\Users\Services;

use Carbon\Carbon;
use App\Domain\GenericDomain;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Modules\Users\Exceptions\LoginException;
use Modules\Users\Repositories\UserRepository;
use Modules\Configurations\Domain\ConfigDomain;
use Modules\Configurations\Services\ConfigurationService;
 
class AuthService 
{
    private $userRepository;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function register($payload){
        $user = $this->userRepository->createNewUser($payload);

        return response()->json([
            'data' => $user,
            'message' => 'User created successfully'
        ]);
    }

    public function login($payload)
    {
        try {
            JWTAuth::factory()->setTTL(ConfigurationService::param(ConfigDomain::SESSION_TIMEOUT));
            if (!$token = JWTAuth::attempt($payload)) {
                $this->userRepository->handleAttemps($payload['username']);

                throw new LoginException(GenericDomain::ERR_LOGIN_CRED);
            }
        } catch (JWTException $e) {
            throw new LoginException(GenericDomain::ERR_LOGIN_TOKEN);
        }

        $user = $this->userRepository->findUser(Auth::id());
        $user->update([
            'failed_login' => 0, 
            'last_login' => Carbon::now()->toDateTimeString()
        ]);

        $ttl = JWTAuth::factory()->getTTL();

        return response()->json([
            'data' => [
                'token' => $token,
                'expires_in' => $ttl * 60,
                'expires_at' => Carbon::now()->addMinutes($ttl)->toDateTimeString(),
                'user' => $user
            ]
        ]);
    }
}