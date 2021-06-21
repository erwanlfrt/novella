<?php
namespace model\tables;

// session_start();


//Database connection
require_once 'model/databaseConnection.php';
use \model\DatabaseConnection;



class User {
 private $db;
  
 public function __construct(){
    $this->db = DatabaseConnection::getDatabaseConnection();
  }
  /**
   * Add user to database
   */
  public function addUser() {

    if(isset($_POST['email'])) {
      //avoid XSS attack
      $email = mysqli_real_escape_string($this->db, htmlspecialchars($_POST['email']));

      if($email !== "") {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
        }
        else {
          //check if user already in database
          $queryCheck = "SELECT count(*) FROM Users WHERE mail='".$email."'";
          $execQuery  =mysqli_query($this->db, $queryCheck);
          $result = mysqli_fetch_array($execQuery);
          $count = $result['count(*)'];

          if($count!=0) {
            header('Location: ?action=forbidden');
          }
          else {
            //insert new user
            if(isset($_POST['password']) && isset($_POST['name']) && isset($_POST['firstname'])){
              $password = mysqli_real_escape_string($this->db, htmlspecialchars($_POST['password']));
              $name = mysqli_real_escape_string($this->db, htmlspecialchars($_POST['name']));
              $firstname = mysqli_real_escape_string($this->db, htmlspecialchars($_POST['firstname']));
              $query = "INSERT INTO Users (mail, password, name, firstname) VALUES ('".$email."', MD5('".$password."'), '".$name."', '".$firstname."');";
              $execRequest = mysqli_query($this->db, $query);
              header('Location: ?action=login');
            }
          }
        }
      }
    }
  }

  /**
   * edit a user
   */
  public function editUser() {

    if(isset($_SESSION['email'])) {
      //avoid XSS attack
      $email = mysqli_real_escape_string($this->db, htmlspecialchars($_SESSION['email']));

      if($email !== "") {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
        }
        else {
          //check if user already in database
          $queryCheck = "SELECT count(*) FROM Users WHERE mail='".$email."'";
          $execQuery  =mysqli_query($this->db, $queryCheck);
          $result = mysqli_fetch_array($execQuery);
          $count = $result['count(*)'];

          if($count == 0) {
            header('Location: ?action=forbidden');
          }
          else {
            //insert new user
            if(isset($_POST['password']) && isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['confirmPassword'])){
              $password = mysqli_real_escape_string($this->db, htmlspecialchars($_POST['password']));
              $confirmPassword = mysqli_real_escape_string($this->db, htmlspecialchars($_POST['confirmPassword']));
              $name = mysqli_real_escape_string($this->db, htmlspecialchars($_POST['name']));
              $firstname = mysqli_real_escape_string($this->db, htmlspecialchars($_POST['firstname']));
              if($password === $confirmPassword) {
                $query = "UPDATE Users SET name='$name', firstname='$firstname', password=MD5('$password') WHERE mail='$email';";
                $execRequest = mysqli_query($this->db, $query);
                $_SESSION['name'] = $name;
                $_SESSION['firstname'] = $firstname;
              }
            }
          }
        }
      }
    }
  }

  /**
   * edit a user
   */
  public function editUserPassword() {

    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm'])){ //If form is valid
      //avoid XSS attack
      $email = mysqli_real_escape_string($this->db,htmlspecialchars($_POST['email'])); 
      $password = mysqli_real_escape_string($this->db,htmlspecialchars($_POST['password']));
      $confirmPassword = mysqli_real_escape_string($this->db,htmlspecialchars($_POST['password_confirm']));
  
      
      if($email !== "" && $password !== "" && $confirmPassword !== ""){    //if inputs are not empty
  
          //check if user already exist in database
          $queryCheck = "SELECT count(*) FROM Users WHERE mail= '".$email."'"; 
          $exec_request = mysqli_query($this->db,$queryCheck);
          $response = mysqli_fetch_array($exec_request);
          $count = $response['count(*)'];
  
          if($count != 0){ //User already exist in database
              if($confirmPassword === $password){ //if confirmPassword and password match
                  //update user
                  $request = "UPDATE Users SET password=MD5('$password') WHERE mail='$email';";
                  $exec_request = mysqli_query($this->db,$request);
  
                  header('Location: ?action=login'); //go back to login webpage
              }
              else{
                  header('Location: ?action=resetPwd&erreur=3'); //passwords don't matched
              }
             
          }
          else{
              header('Location: ?action=resetPwd&erreur=5'); //user doesn't exist
          }
          
      }
      else
      {
         header('Location: ?action=resetPwd&erreur=1'); //empty input
      }
  }
  else{
     header('Location: ?action=resetPwd&erreur=1'); //invalid form
  }
}

  /**
   * delete a user
   */
  public function deleteUser() {
    $email = mysqli_real_escape_string($this->db, htmlspecialchars($_SESSION['email']));

    $checkExist = mysqli_query($this->db,"SELECT count(*) FROM User WHERE mail='$email';");
    $count = mysqli_fetch_array($checkExist)["count(*)"];

    if($count == 0) {
      mysqli_query($this->db,"DELETE FROM Users WHERE mail='$email';");
    }
    header("location: ?action=login");
  }

  /**
   * list all users
   */
  public function listUsers() {
    $query = "SELECT name, firstname, mail FROM Users";
    $exec = mysqli_query($this->db, $query);
    return $exec;
 }
 
 /**
  * get user 
  */
  public function getUser($mail) {
      $safeMail = mysqli_real_escape_string($this->db, htmlspecialchars($mail));
      $query = "SELECT * FROM Users WHERE mail='$safeMail'";
      $exec = mysqli_query($this->db, $query);
      return $exec;
  }
}


?>