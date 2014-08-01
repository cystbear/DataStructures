<?php

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

    public function getItem($number)
    {
        $this->reset();
        $i = 1;
        while ($number !== $i) {
            if (!$this->next()) {
                throw new \RuntimeException('End of List');
            }
            $i++;
        }
        return $this->current;
    }

    private function getTail()
    {
        while ($this->next()){}
        return $this->prev;
    }

    private function next()
    {
        $this->prev = $this->current;
        return $this->current = $this->current->next();
    }

    private function init($start)
    {
        $this->start = $start;
        $this->prev = null;
        $this->current = $this->start;
    }
}
