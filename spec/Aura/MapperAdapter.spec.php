<?php

use function Eloquent\Phony\Kahlan\stub;
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

        beforeEach(function () {

            $this->route = mock(Route::class);
            $this->handler = mock(Handler::class)->get();

            $this->map->route->returns($this->route);
            $this->route->allows->returns($this->route);

        });

        it('should call the aura map ->route() method with the given parameters', function () {

            $this->adapter->register('name', ['GET'], '/pattern', $this->handler);

            $this->map->route->calledWith('name', '/pattern', $this->handler);

        });

        it('should call the produced route ->allows() method with the given array of methods', function () {

            $this->adapter->register('name', ['GET'], '/pattern', $this->handler);

            $this->route->allows->calledWith(['GET']);

        });

        it('should call the optional setup callable with the produced route as parameter', function () {

            $setup = stub();;

            $this->adapter->register('name', ['GET'], '/pattern', $this->handler, $setup);

            $setup->calledWith($this->route);

        });

    });

});
