<?php
// session_start();
//require_once 'model/databaseConnection.php';
use model\DatabaseConnection;

if(isset($_POST['email']) && isset($_POST['password'])){ //check if we have a username and a password at least.
   
    $db = DatabaseConnection::getDatabaseConnection();      
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS

    //prevent XSS 
    $email = mysqli_real_escape_string($db,htmlspecialchars($_POST['email'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    $password_hash = md5($password);

   //prevent CSRF with a token.
   //  $token = uniqid(rand(), true); //generate a token
   //  $_SESSION['token'] = $token;  //add token to session
   //  $_SESSION['token_time'] = time(); //add the token's date of creation.

   if($email !== "" && $password !== ""){ //If email and password are not empty
        $request = "SELECT mail, name, firstname FROM Users where mail= '".$email."' and password = '".$password_hash."' ";
        $exec_request = mysqli_query($db,$request); //execution of role request.
        $result = mysqli_fetch_array($exec_request); //putting result into array
        //$checkMail = $result['mail']; 
        if(!is_null($result)){ //check if mail and password are correct
            $name = $result['name'];
            $firstname = $result['firstname'];
            $_SESSION['email'] = $email; //adding username to session
            $_SESSION['firstname'] = $firstname;
            $_SESSION['name'] = $name;
            header('Location: ?action=home'); //go to home webpage
        }
        else{
            header('Location: ?action=login&erreur=4'); //email or password incorrect
        }
    }
    else
    {
       header('Location: ?action=login&erreur=1'); //invalid form
    }
}
else
{
   header('Location: ?action=login&erreur=1'); //invalid form
}
mysqli_close($db); //close database connection
?>