<?php
namespace Comode\syntax\node;

use Comode\graph\IFactory as IGraphFactory;

final class Creator implements ICreator
{
    private $graphFactory;
    private $typeChecker;
    
    public function __construct(IGraphFactory $graphFactory, ITypeChecker $typeChecker)
    {
        $this->graphFactory = $graphFactory;
        $this->typeChecker = $typeChecker;
    }
    
    public function createNode($type, $value = null)
    {
        $node = $this->graphFactory->makeNode(null, $value);

        $this->typeChecker->addType($node, $type);

        return $node;
    }
}