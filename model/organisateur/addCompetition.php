<?php

use \model\tables\Competition;
use \model\DatabaseConnection;

$competition = new Competition;
$competition->addCompetition();

mysqli_close($db); // close database connection
?>