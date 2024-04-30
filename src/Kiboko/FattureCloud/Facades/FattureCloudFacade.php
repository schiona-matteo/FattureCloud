<?php
namespace Kiboko\FattureCloud\Facades;

use Illuminate\Support\Facades\Facade;

class FattureCloudFacade extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FattureCloud';
    }
}