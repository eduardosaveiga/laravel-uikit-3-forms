<?php

namespace EduardoVeiga\Uikit3Forms;

use \Illuminate\Support\Facades\Facade;

class Uikit3FormsFacade extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'uikit-3-forms';
    }
}
