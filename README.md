#Goto meeting
*Goto meeting V2 api for laravel*

### Third party packages:
* *guzzle: Handle XHR requests*

###Installation
* Add This lines in your ```composer.json```

    ``` "jeylabs/goto-meeting": "dev-master" ```
    ```
    "repositories": [
           {
             "type": "vcs",
             "url": "https://github.com/jeylabs/goto-meeting"
           }
         ],
     ```

* Publish the config file. <br>

    ```php artisan vendor:publish --provider="Jeylabs\GoToMeeting\GoToMeetingServiceProvider"```

###Config
```php
return [
    'direct_user' => env("GOTO_DIRECT_USER"),
    'consumer_key' => env("GOTO_CONSUMER_KEY"),
    'consumer_secret' => env("GOTO_CONSUMER_SECRET"),
    'user_password' => env("GOTO_DIRECT_USER_PASSWORD"),
    'webinars_date_range' => env("DATE_RANGE", 1),
];
```

###Powered by - Ceymplon