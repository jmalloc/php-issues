<?php

/**
 * This file demonstates a subtle issue that occurs in both PHP 5 and PHP 7
 * whereby stack frames for generator functions are missing file and line
 * numbers when the generator is iterated using methods from the "Iterator"
 * interface.
 */

echo '-- debug_backtrace --', PHP_EOL, PHP_EOL;
function generatorWithBacktrace() {
    $trace = debug_backtrace(0, 1);
    print_r($trace[0]);
    yield;
}

echo 'Stack frame when iterating using "Iterator" interface:', PHP_EOL;
$generator = generatorWithBacktrace();
$generator->valid();
echo PHP_EOL;

echo 'Stack frame when iterating using "foreach" interface:', PHP_EOL;
$generator = generatorWithBacktrace();
foreach ($generator as $value) {
}
echo PHP_EOL;

echo '-- Exception::getTrace() --', PHP_EOL, PHP_EOL;
function generatorWithException() {
    throw new Exception('<fail>');
    yield;
}

echo 'Stack frame when iterating using "Iterator" interface:', PHP_EOL;
$generator = generatorWithException();

try {
    $generator->valid();
} catch (Exception $e) {
    $trace = $e->getTrace();
    print_r($trace[0]);
}
echo PHP_EOL;

echo 'Stack frame when iterating using "foreach" interface:', PHP_EOL;
$generator = generatorWithException();
try {
    foreach ($generator as $value) {
    }
} catch (Exception $e) {
    $trace = $e->getTrace();
    print_r($trace[0]);
}
echo PHP_EOL;
