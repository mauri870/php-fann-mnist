<?php

// Print a message and break line
function println($message) {
    echo $message.PHP_EOL;
}

// Print a message using println and exit
function quit($message, $status=1) {
    println($message);
    exit($status);
}

// Return the index of the highest value in an array
function argmax(array $output) {
    return array_keys($output, max($output))[0];
}

// Return the highest value in an array
function amax(array $output) {
    return max($output);
}