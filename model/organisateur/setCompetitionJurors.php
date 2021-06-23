<?php

use \model\tables\Jury;
use \model\tables\Prejury;

$jury = new Jury;
$prejury = new Prejury;

$table = $_POST['select'];

if ($table == "Jury") {
    $jury->addJury();
} else if ($table == "Prejury") {
    $prejury->addPrejury();
} else {
    header('Status: 400 Bad Request', false, 400);
    header('Location: ?action=home'); 
}

?>
