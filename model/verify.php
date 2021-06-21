<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();
require_once('model/tables/novella.php');

use \model\tables\Novella;

$novellaAccess = new Novella;

if(isset($_GET['id'])) {
  $novella = $novellaAccess->getNovella($_GET['id']);
  $data = mysqli_fetch_array($novella);
  $verified = $data[3];
  $verified = 1- $verified;
  $novellaAccess->editVerifiedNovella($_GET['id'],$verified);
}

header('Location: ?action=home');

?>