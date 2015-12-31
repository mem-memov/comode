<?php
namespace Comode\syntax;

class ClauseFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeFactory;
    protected $complimentFactory;

    protected function setUp()
    {
        $this->nodeFactory = $this->getMockBuilder('Comode\syntax\node\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->complimentFactory = $this->getMockBuilder('Comode\syntax\IComplimentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }

    public function testItCreatesClause()
    {
        $clauseFactory = new ClauseFactory($this->nodeFactory, $this->complimentFactory);

        $clauseNode = $this->getMockBuilder('Comode\syntax\node\IClause')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->method('createClauseNode')
                        ->willReturn($clauseNode);
                        
        $complimentSequence = $this->getMockBuilder('Comode\syntax\node\sequence\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
 
        $this->nodeFactory->method('getComplimentSequence')
                        ->willReturn($complimentSequence);
 
        $compliment = $this->getMockBuilder('Comode\syntax\ICompliment')
                    ->disableOriginalConstructor()
                    ->getMock();
 
        $clause = $clauseFactory->createClause([$compliment]);
        
        $this->assertInstanceOf('Comode\syntax\IClause', $clause);
    }
    
    public function testItFetchesClausesByCompliment()
    {
        $clauseFactory = new ClauseFactory($this->nodeFactory, $this->complimentFactory);

        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                    ->disableOriginalConstructor()
                    ->getMock();
                    
        $complimentSequence = $this->getMockBuilder('Comode\syntax\node\sequence\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
 
        $this->nodeFactory->method('getComplimentSequence')
                        ->willReturn($complimentSequence);

        $clauseNode = $this->getMockBuilder('Comode\syntax\node\IClause')
                    ->disableOriginalConstructor()
                    ->getMock();
                    
        $this->nodeFactory->method('getClauseNodes')
                        ->willReturn([$clauseNode]);
        
        $clauses = $clauseFactory->fetchClausesByCompliment($complimentNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IClause', $clauses);
    }
}