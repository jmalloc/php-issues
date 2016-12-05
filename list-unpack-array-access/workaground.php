<?php
function dumpFirstElementOfYield() {

    list($value) = $ASSIGN_TO_VARIABLE_INSIDE_GENERATOR = yield;

    var_dump($value);

};

$fixedArray = new SplFixedArray(1);
$fixedArray[0] = 'the element';

$generator = dumpFirstElementOfYield();
$generator->send($fixedArray);
