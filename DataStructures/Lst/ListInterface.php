<?php

namespace DataStructures\Lst;

/**
 * Interface ListInterface
 * @package DataStructures\Lst
 */
interface ListInterface
{
    const IT_MODE_LIFO   = 2;
    const IT_MODE_FIFO   = 0;
    const IT_MODE_DELETE = 1;
    const IT_MODE_KEEP   = 0;

    /**
     * Constructs a new linked list
     */
    public function __construct ();

    /**
     * Insert the value newval at the specified index,
     * shuffling the previous value at that index (and all subsequent values) up through the list.
     *
     * @param mixed $index The index where the new value is to be inserted.
     * @param mixed $newval The new value for the index.
     * @return void
     * @throws \OutOfRangeException when index is out of bounds or when index cannot be parsed as an integer.
     */
    public function add($index, $newval);

    /**
     * Peeks at the node from the beginning of the linked list
     *
     * @return mixed The value of the first node.
     * @throws \RuntimeException when the data-structure is empty
     */
    public function bottom();

    /**
     * Counts the number of elements in the linked list.
     *
     * @return int Returns the number of elements in the linked list.
     */
    public function count();

    /**
     * Get the current list node.
     *
     * @return mixed The current node value.
     */
    public function current();

    /**
     * Returns the mode of iteration
     *
     * @return int different modes and flags that affect the iteration.
     */
    public function getIteratorMode();

    /**
     * Checks whether the linked list is empty.
     *
     * @return bool whether the linked list is empty.
     */
    public function isEmpty();

    /**
     * Returns the current node index
     *
     * @return mixed The current node index.
     */
    public function key();

    /**
     * Move the iterator to the next node.
     *
     * @return void
     */
    public function next();

    /**
     * Returns whether the requested $index exists
     *
     * @param mixed $index The index being checked.
     * @return bool TRUE if the requested index exists, otherwise FALSE
     */
    public function offsetExists($index);

    /**
     * Returns the value at the specified $index
     *
     * @param mixed $index The index with the value.
     * @return mixed The value at the specified index.
     * @throws \OutOfRangeException when index is out of bounds or when index cannot be parsed as an integer.
     */
    public function offsetGet($index);

    /**
     * Sets the value at the specified $index to $newval
     *
     * @param mixed $index The index being set.
     * @param mixed $newval The new value for the index.
     * @return void
     * @throws \OutOfRangeException when index is out of bounds or when index cannot be parsed as an integer.
     */
    public function offsetSet($index, $newval);

    /**
     * Unsets the value at the specified $index
     *
     * @param mixed $index The index being unset.
     * @return void
     * @throws \OutOfRangeException when index is out of bounds or when index cannot be parsed as an integer.
     */
    public function offsetUnset($index);

    /**
     * Pops a node from the end of the linked list
     *
     * @return mixed The value of the popped node.
     * @throws \RuntimeException when the data-structure is empty.
     */
    public function pop();

    /**
     * Move the iterator to the previous node.
     *
     * @return void
     */
    public function prev();

    /**
     * Pushes value at the end of the linked list.
     *
     * @param mixed $value
     * @return void
     */
    public function push($value);

    /**
     * This rewinds the iterator to the beginning.
     *
     * @return void
     */
    public function rewind();

    /**
     * Serializes the storage
     *
     * @return string
     */
    public function serialize();

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
    public function setIteratorMode($mode);

    /**
     * Shifts a node from the beginning of the linked list
     *
     * @return mixed The value of the shifted node.
     * @throws \RuntimeException when the data-structure is empty.
     */
    public function shift();

    /**
     * Peeks at the node from the end of the linked list
     *
     * @return mixed The value of the last node.
     */
    public function top();

    /**
     * Unserializes the storage
     *
     * @param string $serialized
     * @return void
     */
    public function unserialize($serialized);

    /**
     * Prepends the linked list with an element
     *
     * @param mixed $value The value to unshift.
     * @return void
     */
    public function unshift($value);

    /**
     * Check whether the linked list contains more nodes
     *
     * @return bool Returns TRUE if the linked list contains any more nodes, FALSE otherwise.
     */
    public function valid();
}
