<?php

namespace Mawuekom\Repository\Controls;

use Illuminate\Database\Eloquent\Builder;

trait RepositoryQuery
{
    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = ($this->model instanceof Builder)
                    ? $this->model->get($columns)
                    : $this->model->all($columns);

        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    /**
     * Retrieve the list of data and can add some adjustments to it
     * Like model's relations...
     * 
     * @param string $orderByColumn
     * @param string $orderBy
     * @param array $with
     * @param array $columns
     * 
     * @return mixed
     */
    public function list($orderByColumn, $orderBy = 'desc', $with = [], $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this ->model 
                        ->with($with)
                        ->orderBy($orderByColumn, $orderBy)
                        ->get($columns);

        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    /**
     * Search data
     * 
     * @param string|int $searchTerm
     * 
     * @return mixed
     */
    public function search($searchTerm)
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this ->model 
                        ->whereLike($this ->searchFields(), $searchTerm) 
                        ->get();

        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function first($columns = ['*'])
    {
        $this ->applyCriteria();
        $this ->applyScope();

        $results = $this ->model ->first($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->findOrFail($id, $columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find one data row by field and value
     *
     * @param string $field
     * @param string $value
     * @param array  $columns
     *
     * @return mixed
     */
    public function findOneByField($field, $value = null, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
                        ->where($field, '=', $value)
                        ->first($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find data by field and value
     *
     * @param string $field
     * @param string $value
     * @param array  $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
                        ->where($field, '=', $value)
                        ->get($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find data by some params
     * 
     * @param array $params
     * @param array $columns
     * 
     * @return mixed
     */
    public function findBy(array $params, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
                        ->where($params)
                        ->first($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find all data by some params
     * 
     * @param array $params
     * @param array $columns
     * 
     * @return mixed
     */
    public function findAllBy(array $params, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
                        ->where($params)
                        ->get($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null|int $limit
     * @param array    $columns
     * @param string   $method
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $this->applyCriteria();
        $this->applyScope();

        $limit = is_null($limit) 
                    ? config('repository.pagination.limit', 15) 
                    : $limit;

        $results = $this ->model ->{$method}($limit, $columns);
        $results ->appends(app('request')->query());

        $this->resetModel();

        return $results;
    }
}