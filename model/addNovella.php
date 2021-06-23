<?php 
session_status() === PHP_SESSION_ACTIVE ?: session_start();
require_once 'model/tables/novella.php';

use \model\tables\Novella;

$novella = new Novella;

$novella->addNovella();
?>