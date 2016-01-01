<?php
namespace Comode\syntax\node\sequence;

use Comode\graph\IFactory as IGraphFactory;
use Comode\syntax\node\INode;
use Comode\syntax\node\type\IChecker as ITypeChecker;
use Comode\syntax\node\type\IFilter as ITypeFilter;

final class Factory implements IFactory
{
    private $graphFactory;
    private $checker;
    private $filter;
    
    public function __construct(
        IGraphFactory $graphFactory, 
        ITypeChecker $checker,
        ITypeFilter $filter
    ) {
        $this->graphFactory = $graphFactory;
        $this->checker = $checker;
        $this->filter = $filter;
    }
    
    public function getComplimentSequence(INode $node, $complimentType)
    {
        return new Compliment($this->graphFactory, $this->checker, $this->filter, $node, $complimentType);
    }
}