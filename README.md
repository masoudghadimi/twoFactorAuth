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
     return $this->loggedIn($request , $user);
}

```

<h2>Configuration</h2>

Open configuration file - config/twoFactor.php

- change the route prefix
- Change the expiration time
- Change the number of digits in the code

<h3>Next step</h3>

Edit notification files to suit your needs (app/Notifications)

<h3 align="center">Good luck</h3>
