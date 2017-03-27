<?php

require('utils.php');

// hyperparameters
$num_input = 784;
$num_output = 10;
$num_layers = 3;
$num_neurons_hidden = 256;
$learning_rate = 0.0001;
$max_epochs = 150;
$epochs_between_reports = 1;

if (!file_exists('checkpoints'))
    mkdir('checkpoints');

$nn = fann_create_standard($num_layers, $num_input, $num_neurons_hidden, $num_output);

if ($nn) {
    println('Training on MNIST... '); 
    fann_set_activation_function_hidden($nn, FANN_SIGMOID);
    fann_set_activation_function_output($nn, FANN_SIGMOID);

    $testData = fann_read_train_from_file(dirname(__FILE__).'/test.fann');

    fann_set_callback($nn, function ($nn, $train, $max_epochs, $epochs_between_reports, $desired_error, $epoch) use ($testData) {
        println('Epoch: '.$epoch);

        println('Loss: '.fann_test_data($nn, $testData));
        return true;
    });

    $filename = dirname(__FILE__) ."/train.fann";
    if (fann_train_on_file($nn, $filename, $max_epochs, $epochs_between_reports, $learning_rate))
        fann_save($nn, dirname(__FILE__) . "/checkpoints/mnist.net");

    fann_destroy($nn);
}
?>