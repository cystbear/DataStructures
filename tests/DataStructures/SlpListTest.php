<?php

/**
 * The SPL implementation tests.
 */

use DataStructures\Lst\LinkedList;

class SlpListTest extends PHPUnit_Framework_TestCase
{
    public function testLinkedListIteration()
    {
        $ds = new LinkedList();
        $ds->push('foo');
        $ds->push('bar');
        $ds->push('joe');

        $out = array();
        foreach ($ds as $item) {
            $out[] = $item;
        }
        $this->assertEquals(array('foo', 'bar', 'joe'), $out);
    }

    public function testLinkedListIterationInDifferentMode()
    {
        $ds = new LinkedList();
        $ds->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO | SplDoublyLinkedList::IT_MODE_KEEP);
        $ds->push('foo');
        $ds->push('bar');
        $ds->push('joe');

        $out = array();
        foreach ($ds as $item) {
            $out[] = $item;
        }
        $this->assertEquals(array('joe', 'bar', 'foo'), $out);
    }

    public function testPushingAndPopping()
    {
        $ds = new LinkedList();
        $ds->push('foo');
        $ds->push('bar');
        $ds->push('joe');

        $out = array();
        $out[] = $ds->pop();
        $out[] = $ds->pop();
        $out[] = $ds->pop();
        $this->assertEquals(array('joe', 'bar', 'foo'), $out);
    }

    public function testShiftingAndUnshifting()
    {
        $ds = new LinkedList();
        $ds->unshift('foo');
        $ds->unshift('bar');
        $ds->unshift('joe');

        $out = array();
        $out[] = $ds->shift();
        $out[] = $ds->shift();
        $out[] = $ds->shift();
        $this->assertEquals(array('joe', 'bar', 'foo'), $out);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testEmptyPoppingThrowsException()
    {
        $ds = new LinkedList();
        $ds->pop();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testEmptyToppingThrowsException()
    {
        $ds = new LinkedList();
        $ds->top();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testEmptyBottomingThrowsException()
    {
        $ds = new LinkedList();
        $ds->bottom();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testEmptyShiftingThrowsException()
    {
        $ds = new LinkedList();
        $ds->shift();
    }

    public function testIsEmptyShowsTheCorrectStatus()
    {
        $ds = new LinkedList();
        $this->assertTrue($ds->isEmpty());
        $ds->push('foo');
        $this->assertFalse($ds->isEmpty());
    }

    public function testCountShowsTheNumberOfElements()
    {
        $ds = new LinkedList();
        $this->assertEquals(0, $ds->count());
        $ds->push('foo');
        $this->assertEquals(1, $ds->count());
        $ds->push('foo');
        $this->assertEquals(2, $ds->count());
        $ds->push('foo');
        $this->assertEquals(3, $ds->count());
        $ds->pop();
        $this->assertEquals(2, $ds->count());
    }

    public function testLinkedListIterationWithDeleting()
    {
        $ds = new LinkedList();
        $ds->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_DELETE);
        $ds->push('foo');
        $ds->push('bar');
        $ds->push('joe');

        $out = array();
        foreach ($ds as $item) {
            $out[] = $item;
        }
        $this->assertEquals(array('foo', 'bar', 'joe'), $out);
        $this->assertTrue($ds->isEmpty());
    }

    public function testLinkedListIterationInDifferentModeWithDeleting()
    {
        $ds = new LinkedList();
        $ds->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO | SplDoublyLinkedList::IT_MODE_DELETE);
        $ds->push('foo');
        $ds->push('bar');
        $ds->push('joe');

        $out = array();
        foreach ($ds as $item) {
            $out[] = $item;
        }
        $this->assertEquals(array('joe', 'bar', 'foo'), $out);
        $this->assertTrue($ds->isEmpty());
    }

    public function testGettingIteratorMode()
    {
        $ds = new LinkedList();
        $this->assertEquals(0, $ds->getIteratorMode());
        $ds->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
        $this->assertEquals(2, $ds->getIteratorMode());
        $ds->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO | SplDoublyLinkedList::IT_MODE_DELETE);
        $this->assertEquals(3, $ds->getIteratorMode());
        $ds->setIteratorMode(SplDoublyLinkedList::IT_MODE_DELETE);
        $this->assertEquals(1, $ds->getIteratorMode());
    }
}
