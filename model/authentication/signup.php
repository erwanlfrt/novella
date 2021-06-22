<?php

use \model\tables\User;
use \model\DatabaseConnection;

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['firstname']) && isset($_POST['name'])) //if form is valid
{
    $db = DatabaseConnection::getDatabaseConnection(); 
    //prevent XSS attack
    $email = mysqli_real_escape_string($db,htmlspecialchars($_POST['email'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    $confirmPassword = mysqli_real_escape_string($db,htmlspecialchars($_POST['password_confirm']));
    $name = mysqli_real_escape_string($db,htmlspecialchars($_POST['name']));
    $firstname = mysqli_real_escape_string($db,htmlspecialchars($_POST['firstname']));

    if($email !== "" && $password !== "" && $confirmPassword !== "" && $name !== "" && $firstname !== ""){   //if inputs are not empty

        $user = new User;
        $user->addUser();
    }
    else{
       header('Location: ?action=signup&erreur=1'); //invalid form
    }
}
else{
   header('Location: ?action=signup&erreur=1'); //invalid form
}
mysqli_close($db); //close database connection
?>