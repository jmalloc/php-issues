<?php

/**
 * This file demonstrates a memory-leak (or occasional segfault) that occurs in
 * PHP 7.0 but not in 5.
 *
 * The issue occurs when an array containing a reference to $this is altered
 * in the object's destructor.
 *
 * The leak does not occur if the array does not contain $this.
 * The leak does not occur if the array is not altered in the destructor.
 * The leak does not occur if $this is removed from the array in the destructor.
 *
 * Under PHP 5 this script runs to completion and echoes "Done" to the terminal.
 *
 * Under PHP 7 (and possibly others) this script fails with a fatal
 * error due to the allowed memory size being exceeded.
 *
 * @link https://bugs.php.net/bug.php?id=71818
 * @link https://3v4l.org/lHeRV
 */
class MemoryLeak
{
    public function __construct()
    {
        $this->things[] = $this;
    }

    public function __destruct()
    {
        $this->things[] = null;
    }

    private $things = [];
}

ini_set('memory_limit', '10M');

for ($i = 0; $i < 100000; ++$i) {
    $obj = new MemoryLeak();
}

echo "Done";

