<?php
namespace Comode\graph\store\fileSystem;

use Comode\graph\store\Value as StoreValue;

class NodeStore implements INodeStore
{
    private $nodes;
    private $values;
    private $id;
 
    public function __construct(
        IDirectory $nodes,
        IDirectory $values,
        IId $id
    ) {
        $this->nodes = $nodes;
        $this->values = $values;
        $this->id = $id;
    }
    
    public function create()
    {
        $nodeId = $this->id->next();

        $this->nodes->directory($nodeId)->create();

        return $nodeId;
    }
    
    public function directory($nodeId)
    {
        return $this->nodes->directory($nodeId);
    }
    
    public function bindValue($nodeId, IDirectory $valueDirectory)
    {
        $this->values
            ->directory($nodeId)
            ->link($valueDirectory->name())
            ->create($valueDirectory->path());
    }
    
    public function getValue($nodeId)
    {
        $nodeIndexDirectory = $this->nodes->directory($nodeId);

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