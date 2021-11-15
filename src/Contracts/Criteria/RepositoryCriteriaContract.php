<?php

namespace Mawuekom\Repository\Contracts\Criteria;

use Mawuekom\Repository\Criteria\Criteria;

interface RepositoryCriteriaContract
{
    /**
     * Skip criteria 
     * 
     * @param bool $status
     * 
     * @return $this
     */
    public function skipCriteria($status = true);

    /**
     * Get criteria
     * 
     * @return mixed
     */
    public function getCriteria();

    /**
     * Get by criteria
     * 
     * @param \Mawuekom\Repository\Criteria\Criteria $criteria
     * 
     * @return $this
     */
    public function getByCriteria(Criteria $criteria);

    /**
     * Push criteria
     * 
     * @param \Mawuekom\Repository\Criteria\Criteria $criteria
     * 
     * @return $this
     */
    public function pushCriteria(Criteria $criteria);

    /**
     * Apply criteria
     * 
     * @return $this
     */
    public function applyCriteria();

    /**
     * Reset criteria
     * 
     * @return $this
     */
    public function resetCriteria();
}