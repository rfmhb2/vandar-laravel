<?php

namespace Vandar\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static request($amount,$callback, $mobile = null, $factorNumber = null, $description = null)
 * @method static verify($token)
 * @method static redirect()
 * @method static redirectUrl()
 */
class Vandar extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Vandar';
    }
}