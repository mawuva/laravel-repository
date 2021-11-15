<?php

namespace Mawuekom\Repository\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mawuekom\Repository\Contracts\Criteria\RepositoryCriteriaContract;
use Mawuekom\Repository\Contracts\RepositoryContract;
use Mawuekom\Repository\Criteria\RepositoryCriteria;
use Mawuekom\Repository\Exceptions\RepositoryException;
use Mawuekom\Repository\Traits\CallsModelMethods;

abstract class BaseRepository implements RepositoryContract, RepositoryCriteriaContract
{
    use CallsModelMethods, RepositoryCriteria;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @var \Closure
     */
    protected $scopeQuery = null;

    /**
     * Create new repository instance
     * 
     * @param \Illuminate\Support\Collection $collection
     * 
     * @return void
     */
    public function __construct(Collection $collection)
    {
        $this ->criteria = $collection;
        $this ->makeModel();
    }

    /**
     * Get the model on which works
     * 
     * @return Model|string
     */
    abstract public function model();

    /**
     * Create model instance
     * 
     * @throws \Mawuekom\Repository\Exceptions\RepositoryException
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function makeModel(): Model
    {
        $model = (gettype($this ->model()) === 'object')
                    ? $this ->model()
                    : app($this ->model());

        if (!$model instanceof Model)
                throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

    /**
     * Returns the current Model instance
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel(): Model
    {
        return $this ->model;
    }

    /**
     * Reset model instance
     * 
     * @throws @throws \Mawuekom\Repository\Exceptions\RepositoryException
     */
    public function resetModel()
    {
        $this ->makeModel();
    }

    /**
     * Query Scope
     *
     * @param \Closure $scope
     *
     * @return $this
     */
    public function scopeQuery(\Closure $scope)
    {
        $this ->scopeQuery = $scope;

        return $this;
    }

    /**
     * Reset Query Scope
     *
     * @return $this
     */
    public function resetScope()
    {
        $this ->scopeQuery = null;

        return $this;
    }

    /**
     * Apply scope in current Query
     *
     * @return $this
     */
    protected function applyScope()
    {
        if (isset($this ->scopeQuery) && is_callable($this ->scopeQuery)) {
            $callback = $this ->scopeQuery;
            $this ->model = $callback($this ->model);
        }

        return $this;
    }
}