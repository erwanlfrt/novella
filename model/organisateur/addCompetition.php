<?php

use \model\tables\Competition;
use \model\tables\RequiredWord;

$arrayInput = explode(",", $_POST['requiredWords']);
$arrayInput = array_map('strtolower', $arrayInput);
$arrayInput = array_unique ($arrayInput);

$competition = new Competition;
$id = $competition->addCompetition();



if (isset($_POST['requiredWords'])) {
    $requireWord = new RequiredWord;
    $requireWord->addAllRequiredWord($id[0], $arrayInput);
}

?>