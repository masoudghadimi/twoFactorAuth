<?php


namespace Masoud\Twofactorauth\Notifications;


use Illuminate\Notifications\Notification;

class VerifyCodeNotification extends Notification
{
    public $code;

    public $phone_number;

    /**
     * VerifyCodeNotification constructor.
     * @param $code
     * @param $phone_number
     */
    public function __construct($code, $phone_number)
    {
        $this->code = $code;
        $this->phone_number = $phone_number;
    }

    /**
     * @param $notifiable
     * @return string[]
     */
    public function via($notifiable): array
    {
        return [config('twoFactor.notificationsChannels')];
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toSendVerifyCode($notifiable): array
    {
        return [
            'message' => config('twoFactor.notificationMessage'),
            'number' => $this->phone_number
        ];
    }
}
