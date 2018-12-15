<?php

namespace sportakal\tracker\Facades;

use Illuminate\Support\Facades\Facade;

class tracker extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tracker';
    }
}
