<?php

use function Eloquent\Phony\Kahlan\mock;

use Aura\Router\Map;
use Aura\Router\Route;

use Ellipse\Router\Handler;
use Ellipse\Router\Aura\MapperAdapter;

describe('MapperAdapter', function () {

    beforeEach(function () {

        $this->map = mock(Map::class);

        $this->adapter = new MapperAdapter($this->map->get());

    });

    describe('->register()', function () {

        it('should call the aura map ->route() method with the given parameters', function () {

            $route = mock(Route::class);
            $handler = mock(Handler::class)->get();

            $this->map->route->returns($route);
            $route->allows->returns($route);

            $this->adapter->register('name', ['GET'], '/pattern', $handler);

            $this->map->route->calledWith('name', '/pattern', $handler);
            $route->allows->calledWith(['GET']);

        });

    });

});
