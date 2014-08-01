<?php

use DataStructures\Node;

class NodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getNodeData
     */
    public function testGetData($entry)
    {
        $node = new Node($entry);
        $this->assertEquals($entry, $node->getData());
    }

    public function getNodeData()
    {
        $data = array();
        foreach (range(-2, 2) as $entry) {
            $data[] = array($entry);
        }

        return $data;
    }

    public function testAdd()
    {
        $node = new Node(42);
        $nextNode = new Node(100500);
        $this->assertEquals($nextNode, $node->add($nextNode));
    }

    public function testNext()
    {
        $node = new Node(42);
        $node->add($nextNode = new Node(100500));
        $this->assertEquals($nextNode, $node->next());
        $this->assertEquals(100500, $node->next()->getData());
    }

    public function testEmptyNext()
    {
        $node = new Node(42);
        $this->assertNull($node->next());
    }

    public function testConstructorNext()
    {
        $nextNode = new Node(100500);
        $node = new Node(42, $nextNode);
        $this->assertEquals($nextNode, $node->next());
        $this->assertEquals(100500, $node->next()->getData());
    }

}
