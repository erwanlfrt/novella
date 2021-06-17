<?php

session_start();



//Database connection
require_once 'model/databaseConnection.php';
use \model\DatabaseConnection;

$db = DatabaseConnection::getDatabaseConnection();

/**
 * Add user to database
 * @param db - database connection
 */
function addUser($db) {

  if(isset($_POST['email'])) {
    //avoid XSS attack
    $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email']));

    if($email !== "") {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
      }
      else {
        //check if user already in database
        $queryCheck = "SELECT count(*) FROM Users WHERE mail='".$email."'";
        $execQuery  =mysqli_query($db, $queryCheck);
        $result = mysqli_fetch_array($execQuery);
        $count = $result['count(*)'];

        if($count!=0) {
          header('Location: ?action=forbidden');
        }
        else {
          //insert new author
          if(isset($_POST['password']) && isset($_POST['name']) && isset($_POST['firstname'])){
            $password = mysqli_real_escape_string($db, htmlspecialchars($_POST['password']));
            $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
            $firstname = mysqli_real_escape_string($db, htmlspecialchars($_POST['firstname']));
            $query = "INSERT INTO Users (mail, password, name, firstname) VALUES ('".$email."', MD5('".$password."', '".$name."', '".$firstname."');";
            $execRequest = mysqli_query($db, $queryCheck);
            header('Location: ?action=login');
          }
        }
      }
    }
  }
}

/**
 * edit a user
 * @param $db - database connection
 */
function editUser($db) {
  $mail = $_GET['email']; //get email through query string

  if(isset($_POST['update'])) {
    //avoid XSS attack
    $password = mysqli_real_escape_string($db, htmlspecialchars($_POST['password']));
    $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
    $firstname = mysqli_real_escape_string($db, htmlspecialchars($_POST['firstname']));
    if($name !== "" && $password !== "" && $firstname !== "") {
      mysqli_query($db, "UPDATE Users SET name='$name', password=MD5('$password'), firstname='$firstname' WHERE mail='$mail';");
      mysqli_close($db); // Close connection
      header("location: ?action=login");
    }
  }
}

/**
 * delete a user
 * @param db- database connection
 */
function deleteUser($db) {
  $email = mysqli_real_escape_string($db, htmlspecialchars($_GET['email']));

  $checkExist = mysqli_query($db,"SELECT count(*) FROM User WHERE mail='$email';");
  $count = mysqli_fetch_array($checkExist)["count(*)"];

  if($count == 0) {
    mysqli_query($db,"DELETE FROM Users WHERE mail='$email';");
  }
  header("location: ?action=login");
}

if(isset($_POST['update'])) { //if we want to edit
  editUser($db);
}
else if($_GET['action'] === "delete"){
  deleteUser($db);
}
else{ //else we want to add
  addUser($db);
}

?>