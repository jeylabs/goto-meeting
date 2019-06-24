<?php

namespace Jeylabs\GoToMeeting\Facades;

use Illuminate\Support\Facades\Facade;

class GoToMeeting extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GoToMeeting';
    }
}