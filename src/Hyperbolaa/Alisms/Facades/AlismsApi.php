<?php
/**
 * 短信门面
 */
namespace Hyperbolaa\Alisms\Facades;

use Illuminate\Support\Facades\Facade;

class AlismsApi extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'alisms.api';
    }
}
