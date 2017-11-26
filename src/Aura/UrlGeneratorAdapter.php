<?php declare(strict_types=1);

namespace Ellipse\Router\Aura;

use Aura\Router\Generator;

class UrlGeneratorAdapter
{
    /**
     * The aura generator.
     *
     * @var \Aura\Router\Generator
     */
    private $generator;

    /**
     * Set up the generator adapter with the given aura generator.
     *
     * @param \Aura\Router\Generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @inheritdoc
     */
    public function generate(string $name, array $parameters = []): string
    {
        return $this->generator->generate($name, $parameters);
    }
}
