<?php 

/**
 * Load login webpage.
 */
function login(){
    require('view/authentication/login.php');
}

function signup() {
    require('view/authentication/signup.php');
}

function resetPwd() {
    require('view/authentication/resetPwd.php');
}
?>