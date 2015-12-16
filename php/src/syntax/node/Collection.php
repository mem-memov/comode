<?php
namespace Comode\syntax\node;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

final class Collection implements ICollection
{
    private $graphFactory;
    private $typeChecker;
    
    public function __construct(IGraphFactory $graphFactory, ITypeChecker $typeChecker)
    {
        $this->graphFactory = $graphFactory;
        $this->typeChecker = $typeChecker;
    }

    public function selectFirstNode(INode $node, array $types)
    {
        array_push($types, 'first');
        
        $linkedNodes = $this->typeChecker->selectLinkedNodes($node, $types);
        
        $count = count($linkedNodes);
        
        if ($count == 0) {
            throw new exception\NoCollection();
        }
        
        if ($count > 1) {
            throw new exception\CollectionStartsWithOneNode();
        }
        
        return $linkedNodes[0];
    }
    
    public function selectLastNode(INode $node, array $types)
    {
        array_push($types, 'last');
        
        $linkedNodes = $this->typeChecker->selectLinkedNodes($node, $types);
        
        $count = count($linkedNodes);
        
        if ($count == 0) {
            throw new exception\NoCollection();
        }
        
        if ($count > 1) {
            throw new exception\CollectionEndsWithOneNode();
        }
        
        return $linkedNodes[0];
    }
    
    public function selectNextNode(INode $node, array $types)
    {
        array_push($types, 'next');
        
        $linkedNodes = $this->typeChecker->selectLinkedNodes($node, $types);
        
        $count = count($linkedNodes);
        
        if ($count == 0) {
            throw new exception\NoCollection();
        }
        
        if ($count > 1) {
            throw new exception\CollectionContinuesWithOneNode();
        }
        
        return $linkedNodes[0];
    }

}