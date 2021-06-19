<?php

use model\Autoloader;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);

require_once 'model\autoloader.php';
Autoloader::register();

session_status() === PHP_SESSION_ACTIVE ?: session_start();
require('controller/controller.php');

if (isset($_GET['action'])) {
    if(strpos($_GET['action'],'signup') !== false){
        signup();
    }
    else if(strpos($_GET['action'],'resetPwd') !== false) {
        resetPwd();
    }
    else if(strpos($_GET['action'],'check') !== false){
      check();
  }
  else if(strpos($_GET['action'],'register') !== false) {
      register();
  }
  else if(strpos($_GET['action'],'login') !== false) {
    login();
  }
  else if(strpos($_GET['action'],'changePwd') !== false) {
    changePwd();
  }
  else if (strpos($_GET['action'], 'home') !== false) {
    home();
  }
  else if (strpos($_GET['action'], 'showCompetition') !== false) {
    showCompetition();
  }
  else if (strpos($_GET['action'], 'participate') !== false) {
    participate();
  }
  else if (strpos($_GET['action'], 'addNovella') !== false) {
    insertNovella();
  }
  else if (strpos($_GET['action'], 'pageOrganisateur') !== false) {
    pageOrganisateur();
  }
  else if (strpos($_GET['action'], 'newCompetition') !== false) {
    newCompetition();
  }
  else if (strpos($_GET['action'], 'addCompetition') !== false) {
    addCompetition();
  }
  else if (strpos($_GET['action'], 'manageUser') !== false) {
    manageUser();
  }
  else if (strpos($_GET['action'], 'setCompetitionJurors') !== false) {
    setCompetitionJurors();
  }

  



  else if (strpos($_GET['action'], 'test') !== false) {
    test();
  }
}else {
    login();
}

// require('view/authentication/login.php');

?>