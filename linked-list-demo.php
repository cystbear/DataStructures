<?php

require_once __DIR__ . '/autoload.php';

use DataStructures\Node;
use DataStructures\Lst\LinkedList;

$start = new Node(42);
$list = new LinkedList();
foreach (range(-10, 100) as $entry) {
    $list->addNode(new Node($entry));
}

var_dump($list->getItem(42)->getData());
$list->reset();
while($item = $list->next()) {
}

