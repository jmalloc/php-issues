<?php
function dumpFirstElementOfYield() {

    list($value) = yield;

    var_dump($value);

};

$fixedArray = new SplFixedArray(1);
$fixedArray[0] = 'the element';

$generator = dumpFirstElementOfYield();
$generator->send($fixedArray);
