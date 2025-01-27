<?php

namespace Modules\Users\Repositories;

use Carbon\Carbon;
use Modules\Users\Models\User;
use Modules\Users\Models\UserStatus;
 
class UserRepository extends User 
{
    public function createNewUser($payload)
    {
        return $this->create([
        	'username' => $payload['username'],
        	'email' => $payload['email'],
        	'password' => bcrypt($payload['password']),
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'mobile' => $payload['mobile'],
            'last_login' => Carbon::now()->format("Y-m-d H:i:s"),
        ]);
    }

    public function findUser($id)
    {
        return $this->with('status')
            ->whereId($id)
            ->first();
    }

    public function handleAttemps($username)
    {
        if($user = $this->whereUsername($username)->first()){
            ++$user->failed_login;
            $user->save();

            if($user->failed_login >= 3){
                $user->locked_until = Carbon::now()->addDays(1)->toDateTimeString();
                // $user->	user_access_status_id = UserAccessStatus::whereName('Locked')->first()->id;
                $user->save();

                // $details['email'] = $user->email;
                // SendEmailJob::dispatch($details)->onQueue('queue-notification')->delay(360);
            }
        }
    }

    public function lock()
    {
        $this->locked_at = Carbon::now();
        $this->status()->associate(UserStatus::whereName('Locked')->first()['id']);
        return $this->save();
    }
}