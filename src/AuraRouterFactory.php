<?php declare(strict_types=1);

namespace Ellipse\Router;

use Aura\Router\RouterContainer;

use Ellipse\Router\RouterAdapterInterface;
use Ellipse\Router\Aura\RouterAdapter;
use Ellipse\Router\Aura\MapperAdapter;
use Ellipse\Router\Aura\MatcherAdapter;
use Ellipse\Router\Aura\UrlGeneratorAdapter;

class AuraRouterFactory
{
    /**
     * @inheritdoc
     */
    public function __invoke(): RouterAdapterInterface
    {
        $container = new RouterContainer;

        $mapper = new MapperAdapter($container->getMap());
        $matcher = new MatcherAdapter($container->getMatcher());
        $generator = new UrlGeneratorAdapter($container->getGenerator());

        return new RouterAdapter($mapper, $matcher, $generator);
    }
}
