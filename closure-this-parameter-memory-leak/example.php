<?php

/**
 * This file demonstrates a memory leak that occurs in PHP 7.0 but not in 5.
 *
 * The issue occurs when a closure has a parameter named $this, and is called
 * with an argument that contains a reference to $this (either an array or
 * another object).
 *
 * The leak does not occur if the parameter is not named $this.
 * The leak does not occur if the argument passed _is_ $this.
 *
 * Under PHP 5 this script runs to completion and echoes "Done" to the terminal.
 *
 * Under PHP 7 (and possibly others) this script fails with a fatal
 * error due to the allowed memory size being exceeded.
 *
 * @link https://bugs.php.net/bug.php?id=71737
 * @link https://3v4l.org/lr963
 */
class MemoryLeak
{
    public function bad()
    {
        $closure = function ($this) {};
        $closure([$this]);
    }

    public function good1()
    {
        $closure = function ($param) {};
        $closure([$this]);
    }

    public function good2()
    {
        $closure = function ($this) {};
        $closure($this);
    }
}

$object = new MemoryLeak;

ini_set('memory_limit', '10M');

for ($i = 0; $i < 1000000; ++$i) {
    $object->bad();
}

echo "Done" . PHP_EOL;
