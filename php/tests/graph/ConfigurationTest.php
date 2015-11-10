<?php
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testItMakesFileSystemStore()
    {
        $options = [
            'store' => [
                'type' => 'fileSystem'
            ]
        ];
        
        $configuration = new Comode\graph\Configuration($options);
        
        $store = $configuration->makeStore();
        
        $this->assertInstanceOf('Comode\graph\store\FileSystem', $store);
    }
    
    /**
     * @expectedException Comode\graph\exception\OptionMissing
     */
    public function testItPanicsNoStoreTypeOption()
    {
        $options = [
            'store' => []
        ];
        
        $configuration = new Comode\graph\Configuration($options);
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
        
        $configuration = new Comode\graph\Configuration($options);
        
        $store = $configuration->makeStore();
    }
}