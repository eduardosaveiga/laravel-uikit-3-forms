<?php

namespace EduardoVeiga\Uikit3Forms;

use Illuminate\Support\ServiceProvider;

class Uikit3FormsServiceProvider extends ServiceProvider 
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('uikit-3-forms', function() {
            return new FormService();
        });
    }

    public function provides()
    {
        return ['uikit-3-forms'];
    }
}
