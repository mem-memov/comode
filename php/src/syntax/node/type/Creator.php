<?php
namespace Comode\syntax\node\type;

use Comode\graph\IFactory as IGraphFactory;

final class Creator implements ICreator
{
    private $graphFactory;
    private $typeChecker;
    
    public function __construct(IGraphFactory $graphFactory, IChecker $typeChecker)
    {
        $this->graphFactory = $graphFactory;
        $this->typeChecker = $typeChecker;
    }
    
    public function createNode($type, $value = null)
    {
        $node = $this->graphFactory->makeNode(null, $value);

        $this->typeChecker->setType($node, $type);

        return $node;
    }
}