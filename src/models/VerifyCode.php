<?php


namespace Masoud\Twofactorauth\models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VerifyCode extends Model
{
    protected $fillable = [
        'code',
        'expired_at'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $user
     * @return int
     */
    public static function getVerifyCode($user)
    {
        if (config('twoFactor.newCode')) {
            if ($code = self::getValidCodesForUser($user))
                return $code;
        }

        $user->verifyCodes()->delete();

        do {
            $code = mt_rand(config('twoFactor.min'), config('twoFactor.max'));
        } while (self::checkCodeIsUnique($user, $code));

        $user->verifyCodes()->create([
            'code' => $code,
            'expired_at' => now()->addMinutes(config('twoFactor.expired'))
        ]);

        return $code;
    }

    /**
     * @param $user
     * @param $code
     * @return bool
     */
    protected static function checkCodeIsUnique($user, $code)
    {
        return !!$user->verifyCodes()->where('code', $code)->first();
    }

    /**
     * @param $user
     * @param $code
     * @return bool
     */
    public static function checkVerifyCode($user, $code)
    {
        return !!$user->verifyCodes()->where('code', $code)->where('expired_at', '>', now())->first();
    }

    /**
     * @param $user
     * @return mixed
     */
    protected static function getValidCodesForUser($user)
    {
        return $user->verifyCodes()->where('expired_at', '>', now())->first();
    }
}
