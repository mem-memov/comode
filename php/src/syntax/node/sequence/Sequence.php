<?php
namespace Comode\syntax\node\sequence;

use Comode\syntax\node\INode;
use Comode\syntax\node\type\ICreator;
use Comode\syntax\node\type\IFilter;

abstract class Sequence implements ISequence
{
    private static $next = 'next';
    private static $previous = 'previous';
    
    private $creator;
    private $filter;

    private $commonNode;
    private $type;
    
    public function __construct(ICreator $creator, IFilter $filter, INode $commonNode, $type)
    {
        $this->creator = $creator;
        $this->filter = $filter;

        $this->commonNode = $commonNode;
        $this->type = $type;
    }

    public function firstNodePath()
    {
        $nextNodes = $this->filter->byType($this->commonNode, self::$next);
        
        $firstNextNodes = [];
        foreach ($nextNodes as $nextNode) {
            
            $previousNodes = $this->filter->byType($nextNode, self::$previous);
            
            $previousNodeCount = count($previousNodes);
            
            if ($previousNodeCount == 0) {
                throw new exception\malformed\NextPreviousNodeMissing($this->commonNode, $this->type, $nextNode);
            }
            
            if ($previousNodeCount > 1) {
                throw new exception\malformed\NextPreviousNodeNotOne($this->commonNode, $this->type, $nextNode, $previousNodeCount);
            }
            
            $firstPreviousNode = $previousNode[0];

            $nodesBefore = $this->filter->byType($firstPreviousNode, self::$previous);
            
            if (count($nodesBefore) == 0) {
                $firstNextNodes[] = $nextNode;
            }

        }
        
        $firstNextNodeCount = count($firstNextNodes);
        
        if ($firstNextNodeCount == 0) {
            throw new exception\Missing($this->commonNode, $this->type);
        }
        
        if ($firstNextNodeCount > 1) {
            throw new exception\malformed\FirstNextNodeNotOne($this->commonNode, $this->type, $firstNextNodeCount);
        }
        
        $firstNextNode = $firstNextNodes[0];
        
        $typeNodes = $this->filter->byType($firstNextNode, $this->type);
        
        $typeNodeCount = count($typeNodes);
        
        if ($typeNodeCount == 0) {
            throw new exception\malformed\FirstTypeNodeMissing($this->commonNode, $this->type, $firstNextNode);
        }

        if ($typeNodeCount > 1) {
            throw new exception\malformed\FirstTypeNodeNotOne($this->commonNode, $this->type, $firstNextNode, $typeNodeCount);
        }
        
        $typeNode = $typeNodes[0];
        
        return [$firstPreviousNode, $firstNextNode, $typeNode];
    }
    
    public function lastNodePath()
    {
        $previousNodes = $this->filter->byType($this->commonNode, self::$previous);
        
        $lastPreviousNodes = [];
        foreach ($previousNodes as $previousNode) {
            
            $nextNodes = $this->filter->byType($previousNode, self::$next);
            
            $nextNodeCount = count($nextNodes);
            
            if ($nextNodeCount == 0) {
                throw new exception\malformed\PreviousNextNodeMissing($this->commonNode, $this->type, $previousNode);
            }
            
            if ($nextNodeCount > 1) {
                throw new exception\malformed\PreviousNextNodeNotOne($this->commonNode, $this->type, $previousNode, $nextNodeCount);
            }
            
            $lastNextNode = $nextNode[0];

            $nodesBefore = $this->filter->byType($lastNextNode, self::$next);
            
            if (count($nodesBefore) == 0) {
                $lastPreviousNodes[] = $previousNode;
            }

        }
        
        $lastPreviousNodeCount = count($lastPreviousNodes);
        
        if ($lastPreviousNodeCount == 0) {
            throw new exception\Missing($this->commonNode, $this->type);
        }
        
        if ($lastPreviousNodeCount > 1) {
            throw new exception\malformed\LastPreviousNodeNotOne($this->commonNode, $this->type, $lastPreviousNodeCount);
        }
        
        $lastPreviousNode = $lastPreviousNodes[0];
        
        $typeNodes = $this->filter->byType($lastPreviousNode, $this->type);
        
        $typeNodeCount = count($typeNodes);
        
        if ($typeNodeCount == 0) {
            throw new exception\malformed\LastTypeNodeMissing($this->commonNode, $this->type, $lastPreviousNode);
        }

        if ($typeNodeCount > 1) {
            throw new exception\malformed\LastTypeNodeNotOne($this->commonNode, $this->type, $lastPreviousNode, $typeNodeCount);
        }
        
        $typeNode = $typeNodes[0];
        
        return [$lastNextNode, $lastPreviousNode, $typeNode];
    }
    
    public function nextNodePath(INode $originNode)
    {
        $nextNodes = $this->filter->byType($this->commonNode, self::$next);
        
        $originNextNodes = [];
        foreach ($nextNodes as $nextNode) {
            if ($nextNode->has($originNode)) {
                $originNextNodes[] = $nextNode;
            }
        }
        
        $originNextNodeCount = count($originNextNodes);
        
        if ($originNextNodeCount == 0) {
            throw new exception\malformed\OriginNextNodeMissing($this->commonNode, $this->type, $originNode);
        }
        
        if ($originNextNodeCount > 1) {
            throw new exception\malformed\OriginNextNodeNotOne($this->commonNode, $this->type, $originNode);
        }
        
        $originNextNode = $originNextNodes[0];
        
        $targetNextNodes = $this->filter->byType($originNextNode, self::$next);
        
        $targetNextNodeCount = count($targetNextNodes);
        
        if ($targetNextNodeCount == 0) {
            throw new exception\NoNextNode($this->commonNode, $this->type, $originNode);
        }
        
        if ($targetNextNodeCount > 1) {
            throw new exception\malformed\TargetNextNodeNotOne($this->commonNode, $this->type, $originNode, $originNextNode, $targetNextNodeCount);
        }
        
        $targetNextNode = $targetNextNodes[0];
        
        $targetNodes = $this->filter->byType($targetNextNode, $this->type);
        
        $targetNodeCount = count($targetNodes);
        
        if ($targetNodeCount == 0) {
            throw new exception\malformed\TargetNodeMissing($this->commonNode, $this->type, $originNode, $originNextNode, $targetNextNode);
        }
        
        if ($targetNodeCount > 1) {
            throw new exception\malformed\TargetNodeNotOne($this->commonNode, $this->type, $originNode, $originNextNode, $targetNextNode);
        }
        
        $targetNode = $targetNodes[0];

        return [$originNode, $originNextNode, $targetNextNode, $targetNode];
    }

    public function previousNodePath(INode $originNode)
    {
        $previousNodes = $this->filter->byType($this->commonNode, self::$previous);
        
        $originPreviousNodes = [];
        foreach ($previousNodes as $previousNode) {
            if ($previousNode->has($originNode)) {
                $originPreviousNodes[] = $previousNode;
            }
        }
        
        $originPreviousNodeCount = count($originPreviousNodes);
        
        if ($originPreviousNodeCount == 0) {
            throw new exception\malformed\OriginPreviousNodeMissing($this->commonNode, $this->type, $originNode);
        }
        
        if ($originPreviousNodeCount > 1) {
            throw new exception\malformed\OriginPreviousNodeNotOne($this->commonNode, $this->type, $originNode);
        }
        
        $originPreviousNode = $originPreviousNodes[0];
        
        $targetPreviousNodes = $this->filter->byType($originPreviousNode, self::$previous);
        
        $targetPreviousNodeCount = count($targetPreviousNodes);
        
        if ($targetPreviousNodeCount == 0) {
            throw new exception\NoPreviousNode($this->commonNode, $this->type, $originNode);
        }
        
        if ($targetPreviousNodeCount > 1) {
            throw new exception\malformed\TargetPreviousNodeNotOne($this->commonNode, $this->type, $originNode, $originPreviousNode, $targetPreviousNodeCount);
        }
        
        $targetPreviousNode = $targetPreviousNodes[0];
        
        $targetNodes = $this->filter->byType($targetPreviousNode, $this->type);
        
        $targetNodeCount = count($targetNodes);
        
        if ($targetNodeCount == 0) {
            throw new exception\malformed\TargetNodeMissing($this->commonNode, $this->type, $originNode, $originPreviousNode, $targetPreviousNode);
        }
        
        if ($targetNodeCount > 1) {
            throw new exception\malformed\TargetNodeNotOne($this->commonNode, $this->type, $originNode, $originPreviousNode, $targetPreviousNode);
        }
        
        $targetNode = $targetNodes[0];

        return [$originNode, $originPreviousNode, $targetPreviousNode, $targetNode];
    }
    
    public function append(INode $node)
    {
        try {
            list($lastNextNode, $lastPreviousNode, $typeNode) = $this->lastNodePath();

            $nextNode = $this->creator->createNode(self::next);
            $previousNode = $this->creator->createNode(self::$previous);
            
            $lastNextNode->addNode($nextNode);
            $previousNode->addNode($lastPreviousNode);

            $nextNode->addNode($previousNode);
            $previousNode->addNode($nextNode);
            
            $this->commonNode->addNode($nextNode);
            $this->commonNode->addNode($previousNode);
            
            $nextNode->addNode($node);
            $previousNode->addNode($node);

            $node->addNode($this->commonNode);
            $this->commonNode->addNode($node);

        } catch(exception\Missing $e) {
            
            $nextNode = $this->creator->createNode(self::next);
            $previousNode = $this->creator->createNode(self::$previous);
            
            $nextNode->addNode($previousNode);
            $previousNode->addNode($nextNode);
            
            $this->commonNode->addNode($nextNode);
            $this->commonNode->addNode($previousNode);
            
            $nextNode->addNode($node);
            $previousNode->addNode($node);

            $node->addNode($this->commonNode);
            $this->commonNode->addNode($node);
        }
    }
}