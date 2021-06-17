<?php

use model\Autoloader;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);

require_once 'model\autoloader.php';
Autoloader::register();

session_start();
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
}else {
    login();
}

// require('view/authentication/login.php');

?>