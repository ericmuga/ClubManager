<?php

namespace App\Services;

use ReflectionClass;

class ModelService
{
    public function getFillableProperties($model)
    {
        $reflection = new ReflectionClass($model);
        $property = $reflection->getProperty('fillable');
        $property->setAccessible(true);
        return $property->getValue($model);
    }
}
