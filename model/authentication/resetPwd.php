<?php
session_start();
require_once 'model/databaseConnection.php';
require_once 'model/tables/user.php';


use \model\tables\User;
use \model\DatabaseConnection;

$user = new User;
$user->editUserPassword();

mysqli_close($db); // close database connection
?>