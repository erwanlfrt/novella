<?php

use \model\tables\User;
use \model\DatabaseConnection;

$user = new User;
$user->editUserPassword();

mysqli_close($db); // close database connection
?>