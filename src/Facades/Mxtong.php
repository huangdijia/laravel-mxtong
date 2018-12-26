<?php

namespace Huangdijia\Mxtong\Facades;

use Illuminate\Support\Facades\Facade;
use Huangdijia\Mxtong\Mxtong as Accessor;

/**
 * @method static boolean send($mobile, $message)
 * @see \Huangdijia\Mxtong\Mxtong
 */

class Mxtong extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Accessor::class;  
    }
}