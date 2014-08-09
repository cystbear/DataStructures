<?php

namespace DataStructures;

class IndexedNode
{
    private $next;
    private $index;
    private $data;

    public function __construct($index, $data)
    {
        if (!is_int($index)) throw new \InvalidArgumentException('Index should be Integer but '.gettype($index).' provided');
        $this->index = $index;
        $this->data = $data;
        $this->next = null;
    }

    public function next()
    {
        return $this->next;
    }
    public function clearNext()
    {
        $this->next = null;
    }

    public function add(IndexedNode $node)
    {
        return $this->next = $node;
    }

    public function getData()
    {
        return $this->data;
    }
    public function setData($data)
    {
        $this->data = $data;
    }

    public function getIndex()
    {
        return $this->index;
    }
    public function setIndex($index)
    {
        $this->index = $index;
    }

//    public function __clone()
//    {
//
//    }
}
