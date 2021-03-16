# twoFactorAuth
Laravel Two-Factor Authenticated For <b>Laravel/Ui</b>


<h1>This package is being developed and debugged</h1>

<h2>Install</h2>

1) Install package - using composer

`composer require masoudghadimi/two-factor-auth`

2) Publish configuration file

`php artisan vendor:publish --tag=twoFactor`

3) Migration

`php artisan migrate`

4) Update User model (app/Models/User)

```php

protected $fillable = [
     'name',
     'email',
     'password',
     'phone_number',
     'two_factor_type'
];

```

5) Add this codes to the User model (app/Models/User)

```php

public function verifyCodes()
{
    return $this->hasMany(VerifyCode::class);
}

```

6) Add this codes to the LoginController (app/Http/Auth/LoginController)

```php
use TwoFactorAuthenticate;

protected function authenticated(Request $request, $user)
{
<<<<<<< HEAD
     return $this->loggedIn($request , $user);
=======
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
>>>>>>> a4a6ae7284b6e1f5b7ed3aa2e6d7f4aa108f2082
}

```

<h2>Configuration</h2>

Open configuration file - config/twoFactor.php

- Detect the channel
- change the route prefix
- Change the expiration time
- Change the number of digits in the code

<h3>Next step</h3>

Create channel file and then put it in the config file (notificationsChannels)

<h3 align="center">Good luck</h3>
