<?php
namespace Comode\syntax;

use Comode\graph\Facade as GraphFactory;

final class Facade extends Factory
{
    public function __construct(array $config)
    {
        $graphFactory = new GraphFactory($config['graph']);

        parent::__construct($config['syntax'], $graphFactory);
    }
}