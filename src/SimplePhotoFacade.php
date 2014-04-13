<?php

namespace Morrelinko\LaravelSimplePhoto;

use Closure;
use Illuminate\Support\Facades\Facade;

/**
 * @author Laju Morrison <morrelinko@gmail.com>
 */
class SimplePhotoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'simple-photo';
    }

    public static function push(&$haystack, array $keys = array(), Closure $callback = null, array $options = array())
    {
        return self::getFacadeRoot()->push($haystack, $keys, $callback, $options);
    }
}
