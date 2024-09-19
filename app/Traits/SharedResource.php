<?php
namespace App\Traits;

trait SharedResource
{
    public function getActionRoute($prefix = '', $routeModels = [], $action = 'update')
    {
        $route = $prefix . $this->getBaseRoute();
        $routeModels = is_array($routeModels) ? $routeModels : [$routeModels];

        if ($this->exists) {
            $routeModels[] = $this;
            return route($route . ".$action", $routeModels);
        } else {
            return route($route . '.store', $routeModels);
        }
    }

    public function getBaseRoute()
    {
        return property_exists($this, 'baseRoute') ? $this->baseRoute : $this->getTable();
    }

}
