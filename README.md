# twoFactorAuth
Laravel Two-Factor Authenticated For <b>Laravel/Ui</b>


<h2>Install</h2>

1) Install package - using composer

`composer install`

2) Publish configuration file

`php artisan vendor:publish --tag=twoFactor`

3) Add this codes to the User model (app/Models/User)

```php

public function verifyCodes()
{
    return $this->hasMany(VerifyCode::class);
}

```

4) Add this codes to the LoginController (app/Http/Auth/LoginController)

```php

protected function authenticated(Request $request, $user)
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
              $user->notify(new SendVerifyCodeByEmailNotification($code , $user->email));
          }

          return redirect(route('send.verify.code'));
      }

      return false;
}

```

<h2>Configuration</h2>

Open configuration file - config/twoFactor.php

- change the route prefix
- Change the expiration time
- Change the number of digits in the code

<h4>Next step</h4>

Edit notification files to suit your needs (app/Notifications)

<h3 align="center">Good luck</h3>