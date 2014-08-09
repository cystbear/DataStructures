<?php

namespace DataStructures\Lst\Strategy;

use DataStructures\Lst\LinkedList;
use DataStructures\Lst\Strategy\AbstractQueueStrategy;

class FifoQueueStrategy extends AbstractQueueStrategy
{
    public function rewind(LinkedList $list)
    {
        $this->spy->__invoke(function(){
            $this->reset();
        }, $list);
    }

    public function next(LinkedList $list)
    {
        return $this->spy->__invoke(function(){
            return $this->getNext();
        }, $list);
    }

}
