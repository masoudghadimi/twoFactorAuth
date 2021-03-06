<?php


namespace Masoud\Twofactorauth\notification\channels;


use Illuminate\Notifications\Notification;

class SmsVerifyCodeChannels
{
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification , 'toSendVerifyCode')) {
            throw new \Exception('toSendVerifyCode not found');
        }

        $data = $notification->toSendVerifyCode($notifiable);

        //

    }
}
