<h1 align="center">twoFactorAuth</h1>
<p align="center">Laravel Two-Factor Authenticated For <b>Laravel/Ui</b></p>


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

- Detect the channel
- change the route prefix
- Change the expiration time
- Change the number of digits in the code

<h3>Next step</h3>

Create channel file and then put it in the config file (notificationsChannels)

<b>For example</b> : 

create SmsVerifyCodeChannel.php in app/channels then enter your desired code as below

```php

class SmsVerifyCodeChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification , 'toSendVerifyCode')) {
            throw new \Exception('toSendVerifyCode not found');
        }

        $data = $notification->toSendVerifyCode($notifiable);

        $message = $data['message'];
        $phone = $data['number'];

        try{
            $lineNumber = 1111111;
            $api = new \Ghasedak\GhasedakApi('token');
            $api->SendSimple($phone, $message, $lineNumber);
        }
        catch(ApiException $e){
            echo $e->errorMessage();
        }
        catch(HttpException $e){
            echo $e->errorMessage();
        }
    }
}

```

Next, enter the config/twofactor.php file and in the <b>notificationsChannels</b> section, enter the created channel as follows:

```php

'notificationsChannels' => \App\channels\SmsVerifyCodeChannel::class,

```

<h3>Last step</h3>

Go to the link below : 

`
localhost:8000/home/security
`

<h3 align="center">Good luck</h3>
