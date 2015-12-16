<?php
namespace Comode\syntax\node;

use Comode\graph\IFactory as IGraphFactory;

final class Facade extends Factory
{
    public function __construct(IGraphFactory $graphFactory, $spaceDirectory)
    {
        $typeSpace = new TypeSpace($graphFactory, $spaceDirectory.'/syntaxSpace.php');
        $typeChecker = new Typechecker($typeSpace);
        $creator = new Creator($this->graphFactory, $this->typeChecker);
        $filter = new Filter($this->typeChecker);
        
        parent::__construct($creator, $filter);
    }
    
}