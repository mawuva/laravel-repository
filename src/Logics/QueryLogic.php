<?php

namespace Mawuekom\Repository\Logics;

trait QueryLogic
{
    /**
     * Get all records with trashed
     * 
     * @param boolean       $paginate
     * @param boolean       $toAPI
     * @param string|null   $sortableColumn
     * @param array         $columns
     * @param array         $relations
     * 
     * @return mixed
     */
    public function getRecordsWithTrashed($paginate = true, $toAPI = false, $sortableColumn = null, $columns = ['*'], $relations = [])
    {
        $data = $this->getDatasQueryBuilder($toAPI, $sortableColumn, $relations)
                    ->withTrashed();

        $results = $this ->resolveAndGetDatas($data, $paginate, $toAPI, $columns);

        return $this ->validateRecords($results);
    }

    /**
     * Get all records without trashed
     * 
     * @param boolean       $paginate
     * @param boolean       $toAPI
     * @param string|null   $sortableColumn
     * @param array         $columns
     * @param array         $relations
     * 
     * @return mixed
     */
    public function getRecordsWithoutTrashed($paginate = true, $toAPI = false, $sortableColumn = null, $columns = ['*'], $relations = [])
    {
        $data = $this->getDatasQueryBuilder($toAPI, $sortableColumn, $relations);

        $results = $this ->resolveAndGetDatas($data, $paginate, $toAPI, $columns);

        return $this ->validateRecords($results);
    }

    /**
     * Get only trashed records
     * 
     * @param boolean       $paginate
     * @param boolean       $toAPI
     * @param string|null   $sortableColumn
     * @param array         $columns
     * @param array         $relations
     * 
     * @return mixed
     */
    public function getOnlyTrashedRecords($paginate = true, $toAPI = false, $sortableColumn = null, $columns = ['*'], $relations = [])
    {
        $data = $this->getDatasQueryBuilder($toAPI, $sortableColumn, $relations)
                    ->onlyTrashed();

        $results = $this ->resolveAndGetDatas($data, $paginate, $toAPI, $columns);

        return $this ->validateRecords($results);
    }

    /**
     * Get results of searched records.
     *
     * @param string        $searchTerm
     * @param bool          $paginate
     * @param bool          $toAPI
     * @param string|null   $sortableColumn
     * @param array         $columns
     * @param array         $relations
     *
     * @return mixed
     */
    public function getResultsOfSearchedRecords(string $searchTerm, $paginate = true, $toAPI = false, $sortableColumn = null, $columns = ['*'], $relations = [])
    {
        $data = $this->getDatasQueryBuilder($toAPI, $sortableColumn, $relations)
                    ->whereLike($this ->searchableFields(), $searchTerm);

        $results = $this ->resolveAndGetDatas($data, $paginate, $toAPI, $columns);

        return $this ->validateRecords($results);
    }

    /**
     * Get data row by field's value
     *
     * @param string        $field
     * @param string|null   $value
     * @param bool          $inTrashed
     * @param bool          $toAPI
     * @param array         $columns
     * @param array         $relations
     *
     * @return void
     */
    public function getDataRowByFieldValue(string $field, string $value = null, $inTrashed = false, $toAPI = false, $columns = ['*'], $relations = [])
    {
        $data = $this->getDatasQueryBuilder($toAPI, null, $relations)
                    ->where($field, '=', $value);
        
        $result = ($inTrashed)
                    ? $data ->withTrashed() ->first($columns)
                    : $data ->first($columns);

        return $this ->validateDataRow($result);
    }

    /**
     * Get Records Query Builder
     *
     * @param boolean       $toAPI
     * @param string|null   $sortableColumn
     * @param array         $relations
     *
     * @return mixed
     */
    public function getDatasQueryBuilder($toAPI = false, $sortableColumn = null, $relations = [])
    {
        $result = ($toAPI) ? $this ->toAPI() : $this ->applyModelMethods();

        if ($sortableColumn !== null) {
            if (str_starts_with($sortableColumn, '-')) {
                $column = substr($sortableColumn, strlen('-')).'';
                $result = $result->orderBy($column, 'ASC');
            }
            
            else {
                $result = $result->orderBy($sortableColumn, 'ASC');
            }
        }

        $result = $result ->with($relations);

        return $result;
    }

    /**
     * Apply model's methods
     *
     * @return mixed
     */
    public function applyModelMethods()
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this ->model;

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * Resolve and get datas
     *
     * @param mixed $data
     * @param bool $paginate
     * @param bool $toAPI
     * @param array $columns
     *
     * @return mixed
     */
    public function resolveAndGetDatas($data, $paginate = true, $toAPI = false, $columns = ['*'])
    {
        if ($paginate) {
            $results = ($toAPI) 
                        ? $data ->jsonPaginate() ->get($columns)
                        : $data ->paginate(null, $columns);
        }

        else {
            $results = $data ->get($columns);
        }

        return $results;
    }

    /**
     * Validate gotten records
     *
     * @param mixed $recordsCollection
     *
     * @return array
     */
    public function validateRecords($recordsCollection): array
    {
        if ($recordsCollection ->count() > 0) {
            return success_response($recordsCollection);
        }

        else {
            return failure_response();
        }
    }

    /**
     * Validate gotten data row
     *
     * @param mixed $dataRow
     *
     * @return array
     */
    public function validateDataRow($dataRow)
    {
        if ($dataRow !== null) {
            return success_response($dataRow);
        }

        else {
            return failure_response();
        }
    }
}