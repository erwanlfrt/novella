<?php

use \model\tables\Competition;

$competition = new Competition;
$competition->addCompetition();

mysqli_close($db); // close database connection
?>