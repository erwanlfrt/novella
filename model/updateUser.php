<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();
require_once('model/tables/user.php');

use \model\tables\User;

$user = new User;


if(isset($_GET['update'])) {
  $user->editUser();
  header('Location: ?action=myAccount');
}
else if(isset($_GET['delete'])){
  $user->deleteUser();
  header('Location: ?action=login');
}


?>