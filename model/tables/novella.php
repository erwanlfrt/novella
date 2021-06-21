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
  public function editNovella($id, $title, $text, $verified, $competition, $mailUser, $anonymousID, $score, $isPrejury){
    $safeID = mysqli_real_escape_string($this->db,htmlspecialchars($id));
    $queryCheck = "SELECT COUNT(*) FROM Novella WHERE id=$safeID";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $resultCheck = mysqli_fetch_array($execCheck);

    if($resultCheck['COUNT(*)'] !== 0) {
      $safeTitle = mysqli_real_escape_string($this->db,htmlspecialchars($title));
      $safeText = mysqli_real_escape_string($this->db,htmlspecialchars($text));
      $safeVerified = mysqli_real_escape_string($this->db,htmlspecialchars($verified));
      $safeCompetition = mysqli_real_escape_string($this->db,htmlspecialchars($competition));
      $safeMailUser = mysqli_real_escape_string($this->db,htmlspecialchars($mailUser));
      $safeAnonymousID = mysqli_real_escape_string($this->db,htmlspecialchars($anonymousID));
      $safeScore = mysqli_real_escape_string($this->db,htmlspecialchars($score));
      
      if($isPrejury) {
        $query = "UPDATE Novella SET title='$safeTitle', text='$safeText', verified=$safeVerified, competition=$safeCompetition, mailUser='$safeMailUser', anonymousID='$safeAnonymousID', scorePrejury=$safeScore  WHERE id=$safeID";
      }
      else {
        $query = "UPDATE Novella SET title='$safeTitle', text='$safeText', verified=$safeVerified, competition=$safeCompetition, mailUser='$safeMailUser', anonymousID='$safeAnonymousID', score=$safeScore  WHERE id=$safeID";
      }

      
      $exec = mysqli_query($this->db, $query);
    }
  }

  /**
   * edit verified field of a novella
   * @param id - id of the novella
   */
  public function editVerifiedNovella($id,$verified){
    $safeID = mysqli_real_escape_string($this->db,htmlspecialchars($id));
    $queryCheck = "SELECT COUNT(*) FROM Novella WHERE id=$safeID";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $resultCheck = mysqli_fetch_array($execCheck);

    if($resultCheck['COUNT(*)'] !== 0) {
      $safeVerified = mysqli_real_escape_string($this->db,htmlspecialchars($verified));
      $query = "UPDATE Novella SET verified=$safeVerified WHERE id=$safeID"; 
      $exec = mysqli_query($this->db, $query);
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

  /**
   * list novellas related to a specific competition
   */
  public function listNovellas($competition) {
    $safeCompetition = mysqli_real_escape_string($this->db, htmlspecialchars($competition));
    $query = "SELECT id, title, score FROM Novella WHERE competition=$safeCompetition";
    $exec = mysqli_query($this->db, $query);

    return $exec;
  }

  /**
   * get novella
   */
  public function getNovella($id) {
    $safeId = mysqli_real_escape_string($this->db, htmlspecialchars($id));
    $query = "SELECT id, title, text, verified, competition, mailUser, anonymousID, score, scorePrejury FROM Novella WHERE id=$safeId";
    $exec = mysqli_query($this->db, $query);
    return $exec;
    
  }

}

?>