<?php


namespace Masoud\Twofactorauth\notification;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Masoud\Twofactorauth\notification\channels\SmsVerifyCodeChannels;

class VerifyCodeNotification extends Notification
{
    use Queueable;

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
        return [SmsVerifyCodeChannels::class];
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toSendVerifyCode($notifiable): array
    {
        return [
            'message' => "Your authentication code: {$this->code}",
            'number' => $this->phone_number
        ];
    }
}
