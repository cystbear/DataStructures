<?php

namespace DataStructures\Lst;

use DataStructures\Lst\ListInterface;
use DataStructures\Lst\Strategy;
use DataStructures\IndexedNode as Node;

class LinkedList implements ListInterface
{
    private $start;
    private $current;
    private $count;
    private $iteratorMode;
    private $queueStrategy;
    private $fetchStrategy;

    public function __construct()
    {
        $this->setIteratorMode(static::IT_MODE_FIFO | static::IT_MODE_KEEP);
        $this->start = null;
        $this->current = null;
        $this->count = 0;
    }

    public function getItem($number)
    {
        $itemNumber = (int) $number;
        if ($itemNumber < 1) throw new \InvalidArgumentException('Item Number should be greater than 1');
        $this->reset();
        $i = 1;
        while ($number > $i) {
            if (!$this->next()) throw new \RuntimeException('End of List');
            $i++;
        }
        return $this->current;
    }

    public function addNode(Node $node)
    {
        if ($this->isEmpty()) {
            $this->initList($node);
        } else {
            $this->getTail()->add($node);
            $this->current = $node;
        }

        return $node;
    }

    /**
     * Insert the value newval at the specified index,
     * shuffling the previous value at that index (and all subsequent values) up through the list.
     *
     * @param mixed $index The index where the new value is to be inserted.
     * @param mixed $newval The new value for the index.
     * @return void
     * @throws \OutOfRangeException when index is out of bounds or when index cannot be parsed as an integer.
     */
    public function add($index, $newval)
    {
        $this->validateIndex($index);

        if (0 === $index) {
            $this->unshift($newval);
            return;
        }

        $node = new Node($index, $newval);
        $prevNode = $this->getNodeWithIndex($index - 1);
        $targetNode = $prevNode->next();

        $prevNode->add($node);
        $node->add($targetNode);
        $this->count++;
        $this->reindexList();
    }

    /**
     * Peeks at the node from the beginning of the linked list
     *
     * @return mixed The value of the first node.
     * @throws \RuntimeException when the data-structure is empty
     */
    public function bottom()
    {
        $this->exceptionIfEmpty();
        $this->start->getData();
    }

    /**
     * Counts the number of elements in the linked list.
     *
     * @return int Returns the number of elements in the linked list.
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * Get the current list node.
     *
     * @return mixed The current node value.
     */
    public function current()
    {
        return $this->current->getData();
    }

    /**
     * Returns the mode of iteration
     *
     * @return int different modes and flags that affect the iteration.
     */
    public function getIteratorMode()
    {
        return $this->iteratorMode;
    }

    /**
     * Checks whether the linked list is empty.
     *
     * @return bool whether the linked list is empty.
     */
    public function isEmpty()
    {
        return $this->checkIsEmpty();
    }

    /**
     * Returns the current node index
     *
     * @return int The current node index.
     */
    public function key()
    {
        $this->exceptionIfEmpty();
        return $this->current->getIndex();
    }

    /**
     * Move the iterator to the next node.
     *
     * @return void
     */
    public function next()
    {
        $this->exceptionIfEmpty();
        $this->current = $this->queueStrategy->next($this);
    }

    /**
     * Returns whether the requested $index exists
     *
     * @param mixed $index The index being checked.
     * @return bool TRUE if the requested index exists, otherwise FALSE
     */
    public function offsetExists($index)
    {
        try  {
            $this->validateIndex($index);
        } catch (\OutOfBoundsException $e){
            return false;
        }

        return true;
    }

    /**
     * Returns the value at the specified $index
     *
     * @param mixed $index The index with the value.
     * @return mixed The value at the specified index.
     * @throws \OutOfRangeException when index is out of bounds or when index cannot be parsed as an integer.
     */
    public function offsetGet($index)
    {
        return $this->getNodeWithIndex($index);
    }

    /**
     * Sets the value at the specified $index to $newval
     *
     * @param mixed $index The index being set.
     * @param mixed $newval The new value for the index.
     * @return void
     * @throws \OutOfRangeException when index is out of bounds or when index cannot be parsed as an integer.
     */
    public function offsetSet($index, $newval)
    {
        $this->getNodeWithIndex($index)->setData($newval);
    }

    /**
     * Unsets the value at the specified $index
     *
     * @param mixed $index The index being unset.
     * @return void
     * @throws \OutOfRangeException when index is out of bounds or when index cannot be parsed as an integer.
     */
    public function offsetUnset($index)
    {
        $this->validateIndex($index);

        if (0 === $index) {
            $this->shift();
            return;
        }

        if ($index === $this->count - 1) {
            $this->pop();
            return;
        }

        $prevNode = $this->getNodeWithIndex($index - 1);
        $targetNode = $prevNode->next();
        $nextNode = $targetNode->next();

        $prevNode->add($nextNode);

        $this->count--;
        $this->reindexList();
    }

    /**
     * Pops a node from the end of the linked list
     *
     * @return mixed The value of the popped node.
     * @throws \RuntimeException when the data-structure is empty.
     */
    public function pop()
    {
        $this->exceptionIfEmpty();


        // TODO fix me
        $nodeToPop = $this->getTail();
        $this->prev();
        if ($this->start === $nodeToPop) {
            $this->start = null;
        } else {
            $this->current->clearNext();
        }
        $this->count--;

        return $nodeToPop->getData();
    }

    /**
     * Move the iterator to the previous node.
     *
     * @return void
     */
    public function prev()
    {
        $this->exceptionIfEmpty();
        if ($this->start === $this->current) {
            $this->current = null;
            return;
        }

        $this->current = $this->getPrev();
    }

    /**
     * Pushes value at the end of the linked list.
     *
     * @param mixed $value
     * @return void
     */
    public function push($value)
    {
        // list length it's count, starter from 0, count - 1 + 1
        $index = $this->count;
        $node = new Node($index, $value);

        if ($this->checkIsEmpty()) {
            $this->start = $node;
        } else {
            $tail = $this->getTail();
            $tail->add($node);
        }

        $this->current = $node;
        $this->count++;
    }

    /**
     * This rewinds the iterator to the beginning.
     *
     * @return void
     */
    public function rewind()
    {
        $this->queueStrategy->rewind($this);
    }

    /**
     * Serializes the storage
     *
     * @return string
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * There are two orthogonal sets of modes that can be set:
     *
     * The direction of the iteration (either one or the other):
     *   ListInterface::IT_MODE_LIFO (Stack style)
     *   ListInterface::IT_MODE_FIFO (Queue style)
     *
     * The behavior of the iterator (either one or the other):
     *   ListInterface::IT_MODE_DELETE (Elements are deleted by the iterator)
     *   ListInterface::IT_MODE_KEEP (Elements are traversed by the iterator)
     * The default mode is: ListInterface::IT_MODE_FIFO | ListInterface::IT_MODE_KEEP
     *
     * @param int $mode
     * @return void
     */
    public function setIteratorMode($mode)
    {
        $availableModes = array(
            static::IT_MODE_FIFO | static::IT_MODE_KEEP,
            static::IT_MODE_FIFO | static::IT_MODE_DELETE,
            static::IT_MODE_LIFO | static::IT_MODE_KEEP,
            static::IT_MODE_LIFO | static::IT_MODE_DELETE,
        );
        if (!in_array($mode, $availableModes)) throw new \InvalidArgumentException('Wrong Iterator Mode');

        switch ($mode) {
            case static::IT_MODE_FIFO | static::IT_MODE_KEEP:
                $this->queueStrategy = new Strategy\FifoQueueStrategy();
                $this->fetchStrategy = new Strategy\KeepFetchStrategy();
                break;
            case static::IT_MODE_FIFO | static::IT_MODE_DELETE:
                $this->queueStrategy = new Strategy\FifoQueueStrategy();
                $this->fetchStrategy = new Strategy\DeleteFetchStrategy();
                break;
            case static::IT_MODE_LIFO | static::IT_MODE_KEEP:
                $this->queueStrategy = new Strategy\LifoQueueStrategy();
                $this->fetchStrategy = new Strategy\KeepFetchStrategy();
                break;
            case static::IT_MODE_LIFO | static::IT_MODE_DELETE:
                $this->queueStrategy = new Strategy\LifoQueueStrategy();
                $this->fetchStrategy = new Strategy\DeleteFetchStrategy();
                break;
        }

        $this->iteratorMode = $mode;
    }

    /**
     * Shifts a node from the beginning of the linked list
     *
     * @return mixed The value of the shifted node.
     * @throws \RuntimeException when the data-structure is empty.
     */
    public function shift()
    {
        $this->exceptionIfEmpty();

        $this->reset();
        $next = $this->getNext();
        $result = $this->current->getData();
        $this->start = $next;
        $this->count--;
        $this->reindexList();

        return $result;
    }

    /**
     * Peeks at the node from the end of the linked list
     *
     * @return mixed The value of the last node.
     */
    public function top()
    {
        return $this->getTail()->getData();
    }

    /**
     * Unserializes the storage
     *
     * @param string $serialized
     * @return void
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    /**
     * Prepends the linked list with an element
     *
     * @param mixed $value The value to unshift.
     * @return void
     */
    public function unshift($value)
    {
        $node = new Node(0, $value);

        if ($this->checkIsEmpty()) {
            $this->start = $node;
        } else {
            $node->add($this->start);
            $this->start = $node;
            $this->reindexList();
        }

        $this->current = $node;
        $this->count++;
    }

    /**
     * Check whether the linked list contains more nodes
     *
     * @return bool Returns TRUE if the linked list contains any more nodes, FALSE otherwise.
     */
    public function valid()
    {
        if ($this->checkIsEmpty()) return false;
        return null !== $this->current;
    }

    // ====================================================================================================
    // ====================================================================================================
    // ====================================================================================================

    private function checkIsEmpty()
    {
        return null === $this->start;
    }

    private function reset()
    {
        $this->current = $this->start;
    }


    private function getCurrent()
    {
        return $this->current;
    }
    /**
     * do not forget return the next value
     * do not traverse list to next item
     */
    private function getNext()
    {
        $this->exceptionIfEmpty();
        if (null !== $this->current) {
            return $this->current->next();
        }
        return null;
    }

    /**
     * do not forget return the next value
     * do not traverse list to prev item
     */
    private function getPrev()
    {
        $this->exceptionIfEmpty();
        if ($this->start === $this->current) {
            return null;
        }
        $current = $this->current;
        $this->reset();

        while($this->current->next() !== $current) $this->current = $this->current->next();

        $prev = $this->current;
        $this->current = $current;
        return $prev;
    }

    public function getTail()
    {
        $this->exceptionIfEmpty();

        while ($this->getNext()){
            $this->current = $this->current->next();
        }
        return $this->current;
    }

    private function getNodeWithIndex($index)
    {
        $this->exceptionIfEmpty();
        $this->validateIndex($index);

        $this->reset();
        do if ($index === $this->current->getIndex()) break; while($this->next());

        return $this->current;
    }

    private function validateIndex($index)
    {
        if (!is_int($index)) throw new \InvalidArgumentException('Index should be Integer but '.gettype($index).' provided');
        if ($index < 0) throw new \OutOfBoundsException();
        if (0 !== $index && $index > $this->count - 1) throw new \OutOfBoundsException();
    }

    private function exceptionIfEmpty()
    {
        if ($this->checkIsEmpty()) throw new \RuntimeException('List is Empty');
    }

    private function reindexList()
    {
        $this->reset();
        $index = 0;
        while ($this->current) {
            $this->current->setIndex($index);
            $index++;
            $this->next();
        }
    }
}
