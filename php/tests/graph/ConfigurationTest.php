<?php
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected $storeFactory;
    
    protected function setUp()
    {
        $this->storeFactory = $this->getMockBuilder('Comode\graph\store\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItMakesFileSystemStore()
    {
        $options = [
            'store' => [
                'type' => 'fileSystem'
            ]
        ];
        
        $configuration = new Comode\graph\Configuration($this->storeFactory, $options);
        
        $fileSystemStore = $this->getMockBuilder('Comode\graph\store\fileSystem\Store')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->storeFactory->expects($this->any())
                            ->method('makeFileSystem')
                            ->willReturn($fileSystemStore);
        
        $store = $configuration->makeStore();
        
        $this->assertEquals($fileSystemStore, $store);
    }
    
    /**
     * @expectedException Comode\graph\exception\OptionMissing
     */
    public function testItPanicsNoStoreTypeOption()
    {
        $options = [
            'store' => []
        ];
        
        $configuration = new Comode\graph\Configuration($this->storeFactory, $options);
        
        $store = $configuration->makeStore();
    }

    /**
     * @expectedException Comode\graph\exception\OptionUnknown
     */
    public function testItPanicsWhenUnknownStoreType()
    {
        $options = [
            'store' => [
                'type' => 'unknownStoreType'
            ]
        ];
        
        $configuration = new Comode\graph\Configuration($this->storeFactory, $options);
        
        $store = $configuration->makeStore();
    }
}