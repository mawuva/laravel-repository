<?php

namespace Mawuekom\Repository\Criteria;

use Mawuekom\Repository\Contracts\RepositoryContract as Repository;

abstract class Criteria
{
    /**
     * Apply criteria
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Mawuekom\Repository\Contracts\RepositoryContract $repository
     * 
     * @return mixed
     */
    abstract public function apply($model, Repository $repository);
}