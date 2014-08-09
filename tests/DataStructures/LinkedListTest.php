<?php

use DataStructures\Node;
use DataStructures\Lst\LinkedList;

class LinkedListTest extends \PHPUnit_Framework_TestCase
{
    public function testBottom()
    {
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testEmptyListNext()
    {
        $list = new LinkedList();
        $this->assertNull($list->next());
    }

}
