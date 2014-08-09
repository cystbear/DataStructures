<?php

/**
 * The SPL implementation tests.
 */

class OtherSlpTest extends PHPUnit_Framework_TestCase
{
    public function testEnqueuingAndDequeuing()
    {
        $ds = new SplQueue;
        $ds->enqueue('foo');
        $this->assertEquals(1, $ds->count());
        $ds->enqueue('bar');
        $this->assertEquals(2, $ds->count());
        $ds->enqueue('joe');
        $this->assertEquals(3, $ds->count());

        $out = array();
        $out[] = $ds->dequeue();
        $this->assertEquals(2, $ds->count());
        $out[] = $ds->dequeue();
        $this->assertEquals(1, $ds->count());
        $out[] = $ds->dequeue();
        $this->assertEquals(0, $ds->count());
        $this->assertEquals(array('foo', 'bar', 'joe'), $out);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testChangingDirectionForQueueThrowsException()
    {
        $ds = new SplQueue;
        $ds->setIteratorMode(SplQueue::IT_MODE_LIFO);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testChangingDirectionForStackThrowsException()
    {
        $ds = new SplStack;
        $ds->setIteratorMode(SplQueue::IT_MODE_FIFO);
    }

    public function testChangingModeForQueueDoesNotThrowException()
    {
        $ds = new SplQueue;
        $ds->setIteratorMode(SplQueue::IT_MODE_DELETE);
    }

    public function testChangingModeForStackDoesNotThrowException()
    {
        $ds = new SplStack;
        $ds->setIteratorMode(SplQueue::IT_MODE_LIFO | SplQueue::IT_MODE_DELETE);
    }

    public function testStackIteration()
    {
        $ds = new SplStack;
        $ds->push('foo');
        $ds->push('bar');
        $ds->push('joe');

        $out = array();
        foreach ($ds as $item) {
            $out[] = $item;
        }
        $this->assertEquals(array('joe', 'bar', 'foo'), $out);
    }

    public function testQueueIteration()
    {
        $ds = new SplQueue;
        $ds->push('foo');
        $ds->push('bar');
        $ds->push('joe');

        $out = array();
        foreach ($ds as $item) {
            $out[] = $item;
        }
        $this->assertEquals(array('foo', 'bar', 'joe'), $out);
    }
}
