<?php


namespace Masoud\Twofactorauth\http\twoFactorAuth;


use Illuminate\Http\Request;
use Masoud\Twofactorauth\models\VerifyCode;
use Masoud\Twofactorauth\Notifications\VerifyCodeByEmailNotification;
use Masoud\Twofactorauth\Notifications\VerifyCodeNotification;

trait TwoFactorAuthenticate
{
    public function loggedIn(Request $request , $user)
    {
        if ($type = $user->two_factor_type != 'off') {
            auth()->logout();

            $request->session()->flash('auth' , [
                'user_id' => $user->id,
                'remember' => $request->has('remember'),
                'type' => $user->two_factor_type
            ]);

            $code = VerifyCode::getVerifyCode($user);

            if ($type == 'sms') {
                $user->notify(new VerifyCodeNotification($code , $user->phone_number));
            }
            elseif ($type == 'email') {
                $user->notify(new VerifyCodeByEmailNotification($code , $user->email));
            }

            return redirect(route('send.verify.code'));
        }

        return false;
    }
}
