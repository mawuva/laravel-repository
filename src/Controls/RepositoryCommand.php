<?php

namespace Mawuekom\Repository\Controls;

trait RepositoryCommand
{
    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = $this->model->newInstance($attributes);
        $model ->save();
        $this ->resetModel();

        return $model;
    }

    /**
     * Update entity in repository by id
     *
     * @param array         $attributes
     * @param int|string    $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $this ->applyScope();

        $model = $this ->model ->findOrFail($id);
        $model ->fill($attributes);
        $model ->save();

        $this ->resetModel();

        return $model;
    }

    /**
     * Update data by field and value
     * 
     * @param string $field
     * @param string $value
     * @param array $attributes
     * 
     * @return mixed
     */
    public function updateByField($field, $value = null, array $attributes)
    {
        $this ->applyScope();

        $model = $this ->model ->where($field, '=', $value) ->first();
        $model ->fill($attributes);
        $model ->save();

        $this ->resetModel();

        return $model;
    }

    /**
     * Update entity in repository by various params
     * 
     * @param array $attributes
     * @param array $data
     * 
     * @return mixed
     */
    public function updateBy(array $params, array $attributes)
    {
        $this ->applyScope();

        $model = $this ->model ->where($params) ->first();
        $model ->fill($attributes);
        $model ->save();

        $this ->resetModel();

        return $model;
    }

    /**
     * Delete data by ID
     * 
     * @param int $id
     * 
     * @return mixed
     */
    public function delete($id)
    {
        $this ->applyScope();

        $model = $this ->model ->findOrFail($id);
        $deleted = $model->delete();

        $this ->resetModel();

        return $deleted;
    }

    /**
     * Delete data by field and value
     * 
     * @param string $field
     * @param string $value
     * 
     * @return mixed
     */
    public function deleteByField($field, $value = null)
    {
        $this ->applyScope();

        $model = $this ->model ->where($field, '=', $value) ->first();
        $deleted = $model->delete();

        $this ->resetModel();

        return $deleted;
    }

    /**
     * Delete data by some params
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function deleteBy(array $params)
    {
        $this ->applyScope();

        $model = $this ->model ->where($params) ->first();
        $deleted = $model ->delete();

        $this ->resetModel();

        return $deleted;
    }
}