<?php

namespace DataStructures\Lst\Strategy;

use DataStructures\Lst\LinkedList;
use DataStructures\Lst\Strategy\AbstractQueueStrategy;

class LifoQueueStrategy extends AbstractQueueStrategy
{
    public function rewind(LinkedList $list)
    {
        $this->spy->__invoke(function(){
            $this->getTail();
        }, $list);
    }

    public function next(LinkedList $list)
    {
        return $this->spy->__invoke(function(){
            return $this->getPrev();
        }, $list);
    }

}
