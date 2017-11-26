<?php

use function Eloquent\Phony\Kahlan\mock;

use Aura\Router\Generator;

use Ellipse\Router\Aura\UrlGeneratorAdapter;

describe('UrlGeneratorAdapter', function () {

    beforeEach(function () {

        $this->generator = mock(Generator::class);

        $this->adapter = new UrlGeneratorAdapter($this->generator->get());

    });

    describe('->generate()', function () {

        it('should proxy the underlying url generator ->generate() method', function () {

            $this->generator->generate->returns('/path');

            $test = $this->adapter->generate('name', ['parameter']);

            expect($test)->toEqual('/path');

            $this->generator->generate->calledWith('name', ['parameter']);

        });

    });

});
