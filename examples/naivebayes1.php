<?php 
require_once __DIR__.'/../vendor/autoload.php';



use Algorithms\NaiveBayes;
echo "Rofilde Hasudungan";

$data = [
    ["sunny", "working", "go-out"],
    ["rainy", "broken", "go-out"],
    ["sunny", "working", "go-out"],
    ["sunny", "working", "go-out"],
    ["sunny", "working", "go-out"],
    ["rainy", "broken", "stay-home"],
    ["rainy", "broken", "stay-home"],
    ["sunny", "working", "stay-home"],
    ["sunny", "broken", "stay-home"],
    ["rainy", "broken", "stay-home"],
];

$data_to_predict = ['sunny', 'working'];
$nb = new NaiveBayes($data, ["Weather", "Car"]);
echo $nb->run()->predict($data_to_predict);
