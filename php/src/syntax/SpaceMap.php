<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class SpaceMap implements ISpaceMap
{
    private $map;
    
    public function __construct(IGraphFactory $graphFactory, $spaceDirectory)
    {
        $this->setMap($graphFactory, $spaceDirectory);
    }
    
    public function getQuestionNode()
    {
        return $this->map['question'];
    }
    
    public function getAnswerNode()
    {
        return $this->map['answer'];
    }
    
    public function getFactNode()
    {
        return $this->map['fact'];
    }
    
    public function getStatementNode()
    {
        return $this->map['statement'];
    }
    
    private function setMap(IGraphFactory $graphFactory, $spaceDirectory)
    {
        if (!file_exists($spaceDirectory)) {
            mkdir($spaceDirectory, 0777, true);
        }
        
        $mappingPath = $spaceDirectory . '/spaceMap.php';
        
        if (!file_exists($mappingPath)) {
            $map = [
                'question' => $graphFactory->createNode()->getId(),
                'answer' => $graphFactory->createNode()->getId(),
                'fact' => $graphFactory->createNode()->getId(),
                'statement' => $graphFactory->createNode()->getId()
            ];
            $fileContent = '<?php return ' . var_export($map, true) . ';';
            file_put_contents($mappingPath, $fileContent);
        }
        
        $map = require($mappingPath);
        
        foreach ($map as $space => $nodeId) {
            $map[$space] = $graphFactory->readNode($nodeId);
        }
        
        $this->map = $map;
    }
}