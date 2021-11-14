<?php

namespace Mawuekom\Repository;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\Repository\Skeleton\SkeletonClass
 */
class RepositoryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'repository';
    }
}
