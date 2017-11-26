<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Router\Handler;
use Ellipse\Router\Match;
use Ellipse\Router\RouterAdapterInterface;
use Ellipse\Router\Aura\MapperAdapter;
use Ellipse\Router\Aura\MatcherAdapter;
use Ellipse\Router\Aura\UrlGeneratorAdapter;
use Ellipse\Router\Aura\RouterAdapter;

describe('RouterAdapter', function () {

    beforeEach(function () {

        $this->mapper = mock(MapperAdapter::class);
        $this->matcher = mock(MatcherAdapter::class);
        $this->generator = mock(UrlGeneratorAdapter::class);

        $this->router = new RouterAdapter(
            $this->mapper->get(),
            $this->matcher->get(),
            $this->generator->get()
        );

    });

    it('should implement RouterAdapterInterface', function () {

        expect($this->router)->toBeAnInstanceOf(RouterAdapterInterface::class);

    });

    describe('->register()', function () {

        it('should proxy the mapper ->register() method', function () {

            $handler = mock(Handler::class)->get();

            $this->router->register('name', ['GET'], '/pattern', $handler);

            $this->mapper->register->calledWith('name', ['GET'], '/pattern', $handler);

        });

    });

    describe('->match()', function () {

        it('should proxy the matcher ->match() method', function () {

            $request = mock(ServerRequestInterface::class)->get();
            $match = mock(Match::class)->get();

            $this->matcher->match->with($request)->returns($match);

            $test = $this->router->match($request);

            expect($test)->toBe($match);

        });

    });

    describe('->generate()', function () {

        it('should proxy the url generator ->generate() method', function () {

            $this->generator->generate->with('name', ['attribute'])->returns('url');

            $test = $this->router->generate('name', ['attribute']);

            expect($test)->toEqual('url');

        });

    });

});
