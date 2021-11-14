<?php

namespace Mawuekom\Repository\Traits;

trait CallsModelMethods
{
    /**
     * Calls static method from the model
     *
     * When the called method doesn't exists on the Repository,
     * Call it on the model
     * 
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([new static(), $method], $arguments);
    }

    /**
     * Calls method from the model
     * 
     * When the called method doesn't exists on the Repository,
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        //$this->applyCriteria();
        //$this->applyScope();
        
        return call_user_func_array([$this->model, $method], $arguments);
    }
}