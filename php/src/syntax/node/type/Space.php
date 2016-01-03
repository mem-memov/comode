<?php
namespace Comode\syntax\node\type;

use Comode\graph\IFactory as IGraphFactory;
use Comode\syntax\node\INode;

final class Space implements ISpace
{
    private $graphFactory;
    private $spaceFile;
    private $rootNode;
    private $nodes;
    
    public function __construct(IGraphFactory $graphFactory, $spaceFile)
    {
        $this->graphFactory = $graphFactory;
        $this->spaceFile = $spaceFile;
        $this->rootNode = null;
        $this->nodes = [];
    }

    public function getTypeNode($type)
    {
        // load root node and type nodes
        if (is_null($this->rootNode)) {
            
            $spaceDirectory = dirname($this->spaceFile);
            if (!file_exists($spaceDirectory)) {
                mkdir($spaceDirectory, 0777, true);
            }
            
            if (!file_exists($this->spaceFile)) {
                $this->rootNode = new Node($this->graphFactory->makeNode());
                $rootId = $this->rootNode->getId();
                $fileContent = '<?php return ' . var_export($rootId, true) . ';';
                file_put_contents($this->spaceFile, $fileContent);
            } else {
                $rootId = require($this->spaceFile);
                $this->rootNode = new Node($this->graphFactory->makeNode($rootId));
            }
            
            $typeNodes = $this->rootNode->getNodes();
            foreach ($typeNodes as $typeNode) {
                $currentType = $typeNode->getValue();
                $this->nodes[$currentType] = new Node($typeNode);
            }
            
        }

        // add new type
        if (!isset($this->nodes[$type])) {
            $newTypeNode = new Node($this->graphFactory->makeNode(null, $type));
            $newTypeNode->addNode($this->rootNode);
            $this->rootNode->addNode($newTypeNode);
            $this->nodes[$type] = $newTypeNode;
        }

        return $this->nodes[$type];
    }
    
    public function findTypeNode(INode $node)
    {
        $typeNodes = [];
        foreach ($this->nodes as $currentTypeNode) {
            if ($node->hasNode($currentTypeNode)) {
                $typeNodes[] = $currentTypeNode;
            }
        }
        
        $typeNodeCount = count($typeNodes);
        
        if ($typeNodeCount == 0) {
            throw new exception\NodeHasNoType($node);
        }
        
        if ($typeNodeCount > 1) {
            throw new exception\NodeCanNotHaveMultipleTypes($node, $typeNodeCount);
        }
        
        $typeNode = $typeNodes[0];
        
        return $typeNode;
    }
}