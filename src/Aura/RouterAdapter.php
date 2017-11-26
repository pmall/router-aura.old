<?php declare(strict_types=1);

namespace Ellipse\Router\Aura;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Router\Handler;
use Ellipse\Router\Match;
use Ellipse\Router\RouterAdapterInterface;
use Ellipse\Router\Aura\MapperAdapter;
use Ellipse\Router\Aura\MatcherAdapter;
use Ellipse\Router\Aura\GeneratorAdapter;


class RouterAdapter implements RouterAdapterInterface
{
    /**
     * The mapper.
     *
     * @var \Ellipse\Router\Aura\MapperAdapter
     */
    private $mapper;

    /**
     * The matcher.
     *
     * @var \Ellipse\Router\Aura\MatcherAdapter
     */
    private $matcher;

    /**
     * The url generator.
     *
     * @var \Ellipse\Router\Aura\UrlGeneratorAdapter
     */
    private $generator;

    /**
     * Set up a router adapter with the given mapper, matcher and generator.
     *
     * @param \Ellipse\Router\Aura\MapperAdapter        $mapper
     * @param \Ellipse\Router\Aura\MatcherAdapter       $matcher
     * @param \Ellipse\Router\Aura\UrlGeneratorAdapter  $generator
     */
    public function __construct(
        MapperAdapter $mapper,
        MatcherAdapter $matcher,
        UrlGeneratorAdapter $generator
    ) {
        $this->mapper = $mapper;
        $this->matcher = $matcher;
        $this->generator = $generator;
    }

    /**
     * @inheritdoc
     */
    public function register(string $name, array $method, string $pattern, Handler $handler)
    {
        return $this->mapper->register($name, $method, $pattern, $handler);
    }

    /**
     * @inheritdoc
     */
    public function match(ServerRequestInterface $request): Match
    {
        return $this->matcher->match($request);
    }

    /**
     * @inheritdoc
     */
    public function generate(string $name, array $parameters = []): string
    {
        return $this->generator->generate($name, $parameters);
    }
}
