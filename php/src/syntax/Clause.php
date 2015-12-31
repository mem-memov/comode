<?php
namespace Comode\syntax;

final class Clause implements IClause
{
    private $complimentFactory;
    private $complimentSequence;
    private $node;

    public function __construct(
        IComplimentFactory $complimentFactory,
        node\sequence\ISequence $complimentSequence,
        node\IClause $node
    )
    {
        $this->complimentFactory = $complimentFactory;
        $this->complimentSequence = $complimentSequence;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }

    public function addCompliment(ICompliment $compliment)
    {
        $compliment->addClause($this->complimentSequence);
    }
    
    public function provideFirstCompliment()
    {
        return $this->complimentFactory->provideFirstComplimentInClause($this->complimentSequence);
    }

    public function provideLastCompliment()
    {
        return $this->complimentFactory->provideLastComplimentInClause($this->complimentSequence);
    }
    
    public function provideNextCompliment(ICompliment $compliment)
    {
        return $compliment->provideNextInClause($this->complimentSequence, $this->complimentFactory);
    }

    public function providePreviousCompliment(ICompliment $compliment)
    {
        return $compliment->providePreviousInClause($this->complimentSequence, $this->complimentFactory);
    }

    public function provideCompliments()
    {
        $arguments = $this->complimentFactory->provideComplimentsByClause($this->node);
        
        return $arguments;
    }
}