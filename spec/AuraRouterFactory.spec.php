<?php

use Ellipse\Router\AuraRouterFactory;
use Ellipse\Router\Aura\RouterAdapter;

describe('AuraRouterFactory', function () {

    beforeEach(function () {

        $this->factory = new AuraRouterFactory;

    });

    describe('->__invoke()', function () {

        it('should return a new instance of RouterAdapter', function () {

            $test = ($this->factory)();

            expect($test)->toBeAnInstanceOf(RouterAdapter::class);

        });

    });

});
