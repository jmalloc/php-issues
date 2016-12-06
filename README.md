# PHP Issues

This repository contains example and reproduction scripts for issues discovered
with PHP and associated tooling.

## Unresolved

- PHP 7 memory leak when altering array containing `$this` in destructor - [example](alter-array-in-destructor-memory-leak/example.php), [bug #71818](https://bugs.php.net/bug.php?id=71818)
- Stack trace of generator function is missing file and line information - [example](generator-backtrace-missing-file-and-line/example.php)
- `phpdbg_get_executable()` behaves differently when passed the `files` option - [example](phpdbg-executable-lines-stream-wrapper/example.php), [krakjoe/phpdbg#161](https://github.com/krakjoe/phpdbg/issues/161)

## Resolved

- `list()` fails to unpack yielded ArrayAccess object - [example](list-unpack-array-access/example.php), [workaround](list-unpack-array-access/workaround.php), [bug #66041](https://bugs.php.net/bug.php?id=66041)
- PHP 7 memory leak when closure has parameter named `$this` - [example](alter-array-in-destructor-memory-leak/example.php), [bug #71737](https://bugs.php.net/bug.php?id=71737)
