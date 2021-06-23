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
  if ($_SESSION['admin'] && isset($_GET['mail'])) {
    $user->deleteUser($_GET['mail']);
    header("location: ?action=pageOrganisateur");
  }
  else if (!$_SESSION['admin']) {
    $user->deleteUser($_SESSION['mail']);
    header("location: ?action=login");
  }
  
}


?>