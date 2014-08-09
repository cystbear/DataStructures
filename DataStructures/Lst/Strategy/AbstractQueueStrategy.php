<?php

namespace DataStructures\Lst\Strategy;

use DataStructures\Lst\LinkedList;

abstract class AbstractQueueStrategy
{
    protected $spy;

    abstract public function rewind(LinkedList $list);
    abstract public function next(LinkedList $list);

    public function __construct()
    {
        $this->spy = function(\Closure $spy, LinkedList $list){
            $spy = $spy->bindTo($list, $list);
            return $spy();
        };
    }
}
