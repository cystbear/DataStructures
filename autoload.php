<?php

require_once __DIR__ . '/SplClassLoader.php';

$classLoader = new SplClassLoader('DataStructures', __DIR__);
$classLoader->register();
