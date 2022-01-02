<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\AdminResetPassword;
use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordRecoverService
{
    public function __construct(private User $userModel){}


    /**
     * @param $email
     */
    public function handleResetEmail($email){
        $user = $this->userModel->where('email', $email)->first();

        if($user){
            $token = Str::random(100);
            $user->notify(new ResetPassword($token));

            DB::table('password_resets')->insert(
                [
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]
            );
        }
    }

    public function resetPassword($data){
        $lastRecord = DB::table('password_resets')
            ->where('email',$data['email'])
            ->where('token',$data['token'])
            ->first();

        if (!$lastRecord || $this->isResetPasswordExpired($lastRecord->token)){
            return null;
        }

        return $this->userModel->where('email', $lastRecord->email)
            ->update(["password" => Hash::make($data['password'])]);
    }

    /**
     * @param string $token
     * @return bool
     */
    private function isResetPasswordExpired(string $token): bool
    {
        $password_reset = DB::table('password_resets')->where('token', $token)->latest()->first();
        return Carbon::parse(Carbon::now())->diffInMinutes($password_reset->created_at) > 59;
    }
}