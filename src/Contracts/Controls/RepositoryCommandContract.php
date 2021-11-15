<?php

namespace Mawuekom\Repository\Contracts\Controls;

interface RepositoryCommandContract
{
    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update entity in repository by id
     *
     * @param array         $attributes
     * @param int|string    $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id);

    /**
     * Update data by field and value
     * 
     * @param string $field
     * @param string $value
     * @param array $attributes
     * 
     * @return mixed
     */
    public function updateByField($field, $value = null, array $attributes);

    /**
     * Update entity in repository by various params
     * 
     * @param array $attributes
     * @param array $attributes
     * 
     * @return mixed
     */
    public function updateBy(array $params, array $attributes);

    /**
     * Delete data by ID
     * 
     * @param int $id
     * 
     * @return mixed
     */
    public function delete($id);

    /**
     * Delete data by field and value
     * 
     * @param string $field
     * @param string $value
     * 
     * @return mixed
     */
    public function deleteByField($field, $value = null);

    /**
     * Delete data by some params
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function deleteBy(array $params);
}