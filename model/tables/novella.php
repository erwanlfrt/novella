<?php
namespace model\tables;

require_once 'model\databaseConnection.php';
use \model\DatabaseConnection;

class Novella {
  private $db;

  public function __construct() {
    $this->db = DatabaseConnection::getDatabaseConnection();
  }

  /**
   * add a novella
   */
  public function addNovella() {
    if(isset($_POST['title']) && isset($_POST['text']) && isset($_GET['id'])) {
      $title = mysqli_real_escape_string($this->db,htmlspecialchars($_POST['title']));
      $text = mysqli_real_escape_string($this->db,htmlspecialchars($_POST['text']));
      $verified = 0;
      $competition = mysqli_real_escape_string($this->db,htmlspecialchars($_GET['id']));
      $mailUser = mysqli_real_escape_string($this->db,htmlspecialchars($_SESSION['email']));
      $anonymousID = uniqid();

      $query = "INSERT INTO Novella (title, text, verified, competition, mailUser, anonymousID) VALUES ('$title', '$text', $verified, $competition, '$mailUser', '$anonymousID');";
      $exec = mysqli_query($this->db, $query);
      header('Location: ?action=participate');
    }
  }

  /**
   * edit a novella
   * @param id - id of the novella
   */
  public function editNovella($id) {
    $queryCheck = "SELECT COUNT(*) FROM Novella WHERE id=$id";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $resultCheck = mysqli_fetch_array($execCheck);

    if($resultCheck['count(*)'] !== 0) {
      if(isset($_POST['title']) && isset($_POST['text'])) {
        $title = mysqli_real_escape_string($this->db,htmlspecialchars($_POST['title']));
        $text = mysqli_real_escape_string($this->db,htmlspecialchars($_POST['text']));
  
        $query = "UPDATE Novella SET title='$title', text='$text' WHERE id=$id";
        $exec = mysqli_query($this->db, $query);
      }
    }
  }

  /**
   * delete a novella
   */
  public function deleteNovella($id) {
    $queryCheck = "SELECT COUNT(*) FROM Novella WHERE id=$id";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $resultCheck = mysqli_fetch_array($execCheck);

    if($resultCheck['count(*)'] !== 0) {
      $query = "DELETE FROM Novella WHERE id=$id";
      $exec = mysqli_query($this->db, $query);
    }
  }

}

?>