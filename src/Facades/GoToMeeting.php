<?php

namespace Jeylabs\GoToMeeting\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GoToMeeting
 * @package Jeylabs\GoToMeeting\Facades
 */
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