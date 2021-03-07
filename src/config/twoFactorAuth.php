<?php


return [
    /*
     * Prefix for user panel route
     */
    'prefixForPanelRoute' => 'home',

    /*
     *  Prefix for Two-Factor authenticate route
     */
    'prefixForAuthRoute' => 'login',

    /*
     *  Redirect user when the code entered is incorrect
     */
    'redirectRouteName' => 'login',

    /*
     *  Create your channel and call it here
     */
    'notificationsChannels' => '',

    /*
     *  Generates code between min and max numbers
     */
    'min' => 1000000,
    'max' => 9999999,

    /*
     *  Generated code expiration time (minutes)
     */
    'expired' => 15,

    /*
     *  If this option is set to true, it checks to see if there is a user-specific code that has not expired in the database.
     *  If there is, a new code is not created and the previous code is returned, but if there is no code, a new code is created for the user
     */
    'newCode' => false
];
