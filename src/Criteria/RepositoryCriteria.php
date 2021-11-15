<?php

namespace Mawuekom\Repository\Criteria;

use Illuminate\Support\Collection;
use Mawuekom\Repository\Criteria\Criteria;

trait RepositoryCriteria
{
    /**
     * Skip criteria 
     * 
     * @param bool $status
     * 
     * @return $this
     */
    public function skipCriteria($status = true)
    {
        $this ->skipCriteria = $status;
        return $this;
    }

    /**
     * Get criteria
     * 
     * @return mixed
     */
    public function getCriteria()
    {
        return $this ->criteria;
    }

    /**
     * Get by criteria
     * 
     * @param \Mawuekom\Repository\Criteria\Criteria $criteria
     * 
     * @return $this
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this ->model = $criteria ->apply($this ->model, $this);
        return $this;
    }

    /**
     * Push criteria
     * 
     * @param \Mawuekom\Repository\Criteria\Criteria $criteria
     * 
     * @return $this
     */
    public function pushCriteria(Criteria $criteria)
    {
        $this ->criteria ->push($criteria);
        return $this;
    }

    /**
     * Apply criteria
     * 
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this ->skipCriteria === true)
            return $this;

        foreach ($this ->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria)
                $this ->model = $criteria ->apply($this ->model, $this);
        }

        return $this;
    }

    /**
     * Reset criteria
     * 
     * @return $this
     */
    public function resetCriteria()
    {
        $this->criteria = new Collection();
        return $this;
    }
}