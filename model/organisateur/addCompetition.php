<?php

use \model\tables\Competition;
use \model\tables\RequiredWord;

$array = explode(",", $_POST['requiredWords']);


$competition = new Competition;
$id = $competition->addCompetition();

if (isset($_POST['requiredWords'])) {
    $requireWord = new RequiredWord;
    $requireWord->addAllRequiredWord($id[0], $array);
}

header('Location: ?action=pageOrganisateur');

?>