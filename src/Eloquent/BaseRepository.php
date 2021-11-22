<?php

namespace Mawuekom\Repository\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mawuekom\Repository\Contracts\Criteria\RepositoryCriteriaContract;
use Mawuekom\Repository\Contracts\RepositoryContract;
use Mawuekom\Repository\Controls\RepositoryCommand;
use Mawuekom\Repository\Controls\RepositoryQuery;
use Mawuekom\Repository\Criteria\RepositoryCriteria;
use Mawuekom\Repository\Exceptions\RepositoryException;
use Mawuekom\Repository\Traits\CallsModelMethods;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository implements RepositoryContract, RepositoryCriteriaContract
{
    use CallsModelMethods, RepositoryCriteria, RepositoryCommand, RepositoryQuery;

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
     * Get the columns on which the search will be done
     * 
     * @return array
     */
    abstract public function searchableFields();

    /**
     * Columns on which filterig will be done
     * 
     * @return array
     */
    abstract public function filterableFields(): array;

    /**
     * Determine by which property the results collection will be ordered
     * 
     * @return array
     */
    abstract public function sortableFields(): array;

    /**
     * Determine the relation that will be load on the resulting model
     * 
     * @return array
     */
    abstract public function includableRelations(): array;

    /**
     * Define a couple fields that will be fetch to reduce the overall size of your SQL query
     * 
     * @return array
     */
    abstract public function selectableFields(): array;

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
     * Alias of All method
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function get($columns = ['*'])
    {
        return $this ->all($columns);
    }

    /**
     * Make request to JSON API
     *
     * @return mixed
     */
    public function toAPI()
    {
        $this->applyCriteria();
        $this->applyScope();
        
        $result = QueryBuilder::for($this ->model)
                    ->allowedFilters($this ->filterableFields())
                    ->allowedSorts($this ->sortableFields())
                    ->allowedFields($this ->searchableFields())
                    ->allowedIncludes($this ->includableRelations());

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * Convert paginate to JSON
     *
     * @return mixed
     */
    public function jsonPaginate()
    {
        return $this ->jsonPaginate()
                    ->appends(request()->query());
    }

    /**
     * Check if entity has relation
     *
     * @param string $relation
     *
     * @return $this
     */
    public function has($relation)
    {
        $this->model = $this->model->has($relation);

        return $this;
    }

    /**
     * Load relations
     *
     * @param array|string $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * Add subselect queries to count the relations.
     *
     * @param mixed $relations
     *
     * @return $this
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }

    /**
     * Load relation with closure
     *
     * @param string  $relation
     * @param closure $closure
     *
     * @return $this
     */
    public function whereHas($relation, $closure)
    {
        $this->model = $this->model->whereHas($relation, $closure);

        return $this;
    }

    /**
     * Set hidden fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function hidden(array $fields)
    {
        $this->model->setHidden($fields);

        return $this;
    }

    /**
     * Set the "orderBy" value of the query.
     *
     * @param mixed  $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
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