<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

use Aura\Router\Matcher;
use Aura\Router\Route;
use Aura\Router\Rules\Allows;

use Ellipse\Router\Handler;
use Ellipse\Router\Match;
use Ellipse\Router\Aura\MatcherAdapter;
use Ellipse\Router\Exceptions\NotFoundException;
use Ellipse\Router\Exceptions\MethodNotAllowedException;

describe('MatcherAdapter', function () {

    beforeEach(function () {

        $this->matcher = mock(Matcher::class);

        $this->adapter = new MatcherAdapter($this->matcher->get());

    });

    describe('->match()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class);

        });

        context('when a route is matched', function () {

            it('should return a match for the given request', function () {

                $handler = mock(Handler::class)->get();

                $route = new Route;
                $route->name('name');
                $route->handler($handler);
                $route->attributes(['attribute']);

                $this->matcher->match->returns($route);

                $test = $this->adapter->match($this->request->get());

                expect($test)->toBeAnInstanceOf(Match::class);
                expect((string) $test)->toEqual('name');

            });

        });

        context('when no route is matched', function () {

            beforeEach(function () {

                $uri = mock(UriInterface::class);

                $this->request->getUri->returns($uri);
                $uri->getPath->returns('/path');
                $this->request->getMethod->returns('GET');

                $this->route = new Route;
                $this->matcher->match->returns(false);
                $this->matcher->getFailedRoute->returns($this->route);

            });

            it('should fail when no route match the given request path', function () {

                $this->route->failedRule(Path::class);

                $test = function () {

                    $this->adapter->match($this->request->get());

                };

                $exception = new NotFoundException('GET', '/path');

                expect($test)->toThrow($exception);

            });

            it('should fail when the given request method is not accepted for its path', function () {

                $this->route->allows(['POST'])->failedRule(Allows::class);

                $test = function () {

                    $this->adapter->match($this->request->get());

                };

                $exception = new MethodNotAllowedException('/path', ['POST']);

                expect($test)->toThrow($exception);

            });

        });

    });

});
