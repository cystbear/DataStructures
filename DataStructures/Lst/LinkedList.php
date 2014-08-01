<?php

namespace DataStructures\Lst;

use DataStructures\Node;

class LinkedList
{
    private $start;
    private $prev;
    private $current;

    public function __construct(Node $start = null)
    {
        $this->init($start);
    }

    public function reset()
    {
        return $this->init($this->start);
    }

    public function isEmpty()
    {
        return null === $this->start;
    }

    public function addNode(Node $node)
    {
        if ($this->isEmpty()) {
            $this->init($node);
        } else {
            $this->getTail()->add($node);
            $this->current = $node;
        }

        return $node;
    }

    public function next()
    {
        $this->prev = $this->current;
        return $this->current = $this->current->next();
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

    public function getTail()
    {
        while ($this->next()){}
        return $this->prev;
    }

    private function init($start)
    {
        $this->start = $start;
        $this->prev = null;
        $this->current = $this->start;
    }
}
