<?php

namespace Mawuekom\LaravelRepository;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\LaravelRepository\Skeleton\SkeletonClass
 */
class LaravelRepositoryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-repository';
    }
}
