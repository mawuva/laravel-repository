<?php

namespace Mawuekom\Repository\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Repository\Contracts\RepositoryContract;
use Mawuekom\Repository\Exceptions\RepositoryException;
use Mawuekom\Repository\Traits\CallsModelMethods;

abstract class BaseRepository implements RepositoryContract
{
    use CallsModelMethods;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /**
     * Create new repository instance
     * 
     * @param \Illuminate\Support\Collection $collection
     * 
     * @return void
     */
    public function __construct()
    {
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
}