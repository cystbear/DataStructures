<?php

class Node
{
    private $next;
    private $data;

    public function __construct($data, Node $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }

    public function next()
    {
        return $this->next;
    }

    public function add(Node $node)
    {
        return $this->next = $node;
    }

    public function getData()
    {
        return $this->data;
    }
}
