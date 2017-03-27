<?php

require('utils.php');

// Load the trained model
$modelFile = dirname(__FILE__).'/checkpoints/mnist.net';

if (!file_exists($modelFile)) {
    quit('MNIST model not found!');
}

// Recreate the network saved state
$nn = fann_create_from_file($modelFile);

if ($nn) {
    $valFile = dirname(__FILE__).'/val.fann';
    if (!file_exists($valFile)) {
        quit($valFile.' not found!');
    }

    println('Running inference on '.$valFile);

    $features = [];
    $labels = [];

    // Open the val file for inference
    if ($file = fopen($valFile, "r")) {
        while(!feof($file)) {
            $line = explode(' ', fgets($file));
            array_pop($line); // remove the last array value(line break)

            $lineSize = count($line);
            
            // If the line is an input...
            if ($lineSize == fann_get_num_input($nn)) {
                $features = $line;
            } else if ($lineSize == fann_get_num_output($nn)) { // ...if is an output
                $labels = $line;

                $output = fann_run($nn, $features);

                $pred = argmax($output);
                $true_pred = argmax($labels);
                $confidence = amax($output);

                println('I think this number is '. $pred.' with '.round($confidence*100, 2).'% confidence');
                println('REAL VALUE: '. $true_pred);
                println('');

                sleep(1);
            }
        }
        fclose($file);
    }

    fann_destroy($nn);
}
?>