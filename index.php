<?php
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