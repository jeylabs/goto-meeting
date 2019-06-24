<?php

namespace Jeylabs\GoToMeeting;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class GoToMeetingServiceProvider
 * @package Jeylabs\GoToMeeting
 */
class GoToMeetingServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $source = __DIR__ . '/config/goto-meeting.php';
        $this->publishes([$source => config_path('goto-meeting.php')]);
        $this->mergeConfigFrom($source, 'goto-meeting');
    }

    /**
     *
     */
    public function register()
    {
        $this->registerBindings($this->app);
    }

    /**
     * @param Application $app
     */
    protected function registerBindings(Application $app)
    {
        $app->singleton('GoToMeeting', function ($app) {
            $config = $app['config'];
            return new GoToMeeting(
                $config->get('goto-meeting.direct_user', null),
                $config->get('goto-meeting.user_password', null),
                $config->get('goto-meeting.consumer_key', null),
                $config->get('goto-meeting.consumer_secret', null)
            );
        });
        $app->alias('GoToMeeting', GoToMeeting::class);
    }
}