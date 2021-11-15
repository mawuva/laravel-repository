<?php

namespace Mawuekom\Repository\Contracts;

use Mawuekom\Repository\Contracts\Controls\RepositoryCommandContract;
use Mawuekom\Repository\Contracts\Controls\RepositoryQueryContract;

interface RepositoryContract extends RepositoryCommandContract, RepositoryQueryContract
{
    
}