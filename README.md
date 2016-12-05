# PHP Issues

This repository contains example and reproduction scripts for issues discovered
with PHP and associated tooling.

- PHP 7 memory leak when altering array containing `$this` in destructor
  ([example](alter-array-in-destructor-memory-leak.php) | [PHP Bug #71818](https://bugs.php.net/bug.php?id=71818))

- Stack trace of generator function is missing file and line information
  ([example](generator-backtrace-missing-file-and-line.php))
