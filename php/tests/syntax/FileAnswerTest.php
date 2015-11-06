<?php
class FileAnswerTest extends \PHPUnit_Framework_TestCase
{
    protected $node;
    protected $complimentFactory;
    
    protected function setUp()
    {
        $this->node = $this->getMockBuilder('Comode\syntax\node\IFileAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->complimentFactory = $this->getMockBuilder('Comode\syntax\IComplimentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItConfirmsBeingAFile()
    {
        $answer = new Comode\syntax\FileAnswer($this->complimentFactory, $this->node);
        
        $this->assertEquals(true, $answer->isFile());
    }
}