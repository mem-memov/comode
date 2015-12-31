<?php
namespace Comode\syntax\node\sequence;

use Comode\syntax\node\INode;
use Comode\syntax\node\type\ICreator as ITypeCreator;
use Comode\syntax\node\type\IFilter as ITypeFilter;

final class Factory implements IFactory
{
    private $creator;
    private $filter;
    
    public function __construct(ITypeCreator $creator, ITypeFilter $filter)
    {
        $this->creator = $creator;
        $this->filter = $filter;
    }
    
    public function getComplimentSequence(INode $node)
    {
        return new Compliment($this->creator, $this->filter, $node, $complimentType);
    }
}