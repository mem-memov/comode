<?php
namespace Comode\graph\store\fileSystem;

use Comode\graph\store\Value as StoreValue;

class NodeStore implements INodeStore
{
    private $nodeRoot;
    private $valueIndex;
    private $id;
 
    public function __construct(
        directory\IDirectory $nodeRoot,
        directory\IDirectory $valueIndex,
        IId $id
    ) {
        $this->nodeRoot = $nodeRoot;
        $this->valueIndex = $valueIndex;
        $this->id = $id;
    }
    
    public function create()
    {
        $nodeId = $this->id->next();

        $this->nodeRoot->directory($nodeId)->create();

        return $nodeId;
    }
    
    public function directory($nodeId)
    {
        return $this->nodeRoot->directory($nodeId);
    }
    
    public function bindValue($nodeId, IDirectory $valueDirectory)
    {
        $this->valueIndex
            ->directory($nodeId)
            ->link($valueDirectory->name())
            ->create($valueDirectory->path());
    }
    
    public function getValue($nodeId)
    {
        $nodeIndexDirectory = $this->nodeRoot->directory($nodeId);

        $links = $nodeIndexDirectory->links();

        if (empty($links)) {
            throw new ValueNotFound();
        }

        $valueDirectory = $links[0]->directory();

        $valueFiles = $valueDirectory->files();

        $valueFile = $valueFiles[0];

        if ($valueFile->name() == $valueDirectory->name()) {
            return new StoreValue(false, $valueFile->read());
        } else {
            return new StoreValue(true, $valueFile->path());
        }
    }
}