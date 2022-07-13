<?php

namespace Tests;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Session\Store;
use Illuminate\Support\ViewErrorBag;

abstract class FeatureTestCase extends TestCase
{
    protected function getSession(): Store
    {
        return resolve('session.store');
    }

    protected function getSessionErrors(): ?ViewErrorBag
    {
        return $this->getSession()->get('errors');
    }
    protected function getRouteMethod(string $routeName): string
    {
        $route = resolve(Router::class)
            ->getRoutes()
            ->getByName($routeName);

        $this->assertInstanceOf(Route::class, $route, "Route [$routeName] not defined.");
        $methods = $route->methods();
        $this->assertArrayHasKey(0, $methods);

        return $methods[0];
    }
}
