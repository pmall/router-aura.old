<?php declare(strict_types=1);

namespace Ellipse\Router\Aura;

use Aura\Router\Map;

use Ellipse\Router\Handler;

class MapperAdapter
{
    /**
     * The aura map.
     *
     * @var \Aura\Router\Map
     */
    private $map;

    /**
     * Set up the mapper adapter with the given aura map.
     *
     * @param \Aura\Router\Map
     */
    public function __construct(Map $map)
    {
        $this->map = $map;
    }

    /**
     * @inheritdoc
     */
    public function register(string $name, array $method, string $pattern, Handler $handler): void
    {
        $this->map->route($name, $pattern, $handler)->allows($method);
    }
}
