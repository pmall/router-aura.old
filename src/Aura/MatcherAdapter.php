<?php declare(strict_types=1);

namespace Ellipse\Router\Aura;

use Psr\Http\Message\ServerRequestInterface;

use Aura\Router\Matcher;
use Aura\Router\Rules\Allows;

use Ellipse\Router\Match;
use Ellipse\Router\Exceptions\NotFoundException;
use Ellipse\Router\Exceptions\MethodNotAllowedException;

class MatcherAdapter
{
    /**
     * The aura matcher.
     *
     * @var \Aura\Router\Matcher
     */
    private $matcher;

    /**
     * Set up the matcher adapter with the given aura matcher.
     *
     * @param \Aura\Router\Matcher
     */
    public function __construct(Matcher $matcher)
    {
        $this->matcher = $matcher;
    }

    /**
     * @inheritdoc
     */
    public function match(ServerRequestInterface $request): Match
    {
        $route = $this->matcher->match($request);

        if ($route !== false) {

            $name = $route->name;
            $handler = $route->handler;
            $attributes = $route->attributes;

            return new Match($name, $handler, $attributes);

        }

        $failed = $this->matcher->getFailedRoute();
        $uri = $request->getUri()->getPath();
        $method = $request->getMethod();

        if ($failed->failedRule == Allows::class) {

            $allowed_methods = $failed->allows;

            throw new MethodNotAllowedException($uri, $allowed_methods);

        }

        throw new NotFoundException($method, $uri);
    }
}
