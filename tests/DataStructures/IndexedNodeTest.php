<?php

use DataStructures\IndexedNode;

class IndexedNodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getNodeData
     */
    public function testGetData($index, $data)
    {
        $node = new IndexedNode($index, $data);
        $this->assertEquals($data, $node->getData());
    }

    public function getNodeData()
    {
        $data = array();
        foreach (range(-2, 2) as $entry) {
            $data[] = array($entry, $entry);
        }

        return $data;
    }

    public function testAdd()
    {
        $node = new IndexedNode(1, 42);
        $nextNode = new IndexedNode(2, 100500);
        $this->assertEquals($nextNode, $node->add($nextNode));
    }

    public function testNext()
    {
        $node = new IndexedNode(1, 42);
        $node->add($nextNode = new IndexedNode(2, 100500));
        $this->assertEquals($nextNode, $node->next());
        $this->assertEquals(100500, $node->next()->getData());
    }

    public function testEmptyNext()
    {
        $node = new IndexedNode(1, 42);
        $this->assertNull($node->next());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException()
    {
        new IndexedNode('hello', 42);
    }

}
