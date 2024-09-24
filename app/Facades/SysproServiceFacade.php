<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SysproServiceFacade extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'syspro-service';
    }

}
