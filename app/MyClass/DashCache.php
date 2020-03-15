<?php

namespace App\MyClass;

use Illuminate\Cache\Repository;
use IntercaseDefault\MyClass\AbstractDefaultCache;

class DashCache extends AbstractDefaultCache
{
    public function __construct(Repository $cache)
    {
        parent::__construct($cache);
        $this->setPrefix(config('dash_'));
    }

}
