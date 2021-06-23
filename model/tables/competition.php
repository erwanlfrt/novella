<?php
namespace model\tables;

use \model\DatabaseConnection;

class Competition {
  private $db;

  public function __construct() {
    $this->db = DatabaseConnection::getDatabaseConnection();
  }

  /**
   * add a competition
   */
  public function addCompetition() {
    if(isset($_POST['theme']) && isset($_POST['incipit']) && isset($_POST['deadline'])) {
      $theme =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['theme']));
      $incipit =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['incipit']));
      $deadline =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['deadline']));
      $prejuryDate =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['prejuryDate']));
      $juryDate =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['juryDate']));

      if($theme !== "" && $incipit !== "" && $deadline !== "") {
        $query = "INSERT INTO Competition (theme, incipit, creationDate, deadline) VALUES ('$theme', '$incipit', curdate(), '$deadline');";
        
        $execRequest = mysqli_query($this->db, $query);
        
        $query = "SELECT id FROM Competition ORDER BY ID DESC LIMIT 1";
        $exec = mysqli_query($this->db,$query);
        return mysqli_fetch_array($exec);
      }
    }
  }

  /**
   * edit a competition
   * @param id - id of the competition to edit
   */
  public function editCompetition($id) {
    $queryCheck = "SELECT COUNT(*) FROM Competition WHERE id=$id";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $result = mysqli_fetch_array($execCheck);
    if($result['count(*)'] !== 0){
      if(isset($_POST['theme']) && isset($_POST['incipit']) && isset($_POST['deadline'])) {
        $theme =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['theme']));
        $incipit =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['incipit']));
        $deadline =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['deadline']));
  
        if($theme !== "" && $incipit !== "" && $deadline !== "") {
          $query = "UPDATE Competition SET theme='$theme', incipit='$incipit', deadline='$deadline' WHERE id=$id";
          $execRequest = mysqli_query($this->db, $query);
          header('Location: ?action=home');
        }
      }
    }
  }

  /**
   * delete a competition.
   */
  public function deleteCompetition($id) {
    $queryCheck = "SELECT COUNT(*) FROM Competition WHERE id=$id";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $result = mysqli_fetch_array($execCheck);
    if($result['COUNT(*)'] !== 0){
      $query = "DELETE FROM Competiton WHERE id=$id";
      $execRequest = mysqli_query($this->db, $query);
      header('Location: ?action=home');
    }
  }

  /**
   * list all existing competitions
   */
   public function listCompetitions() {
      $query = "SELECT theme, id FROM Competition";
      $exec = mysqli_query($this->db, $query);
      return $exec;
   }

   /**
    * list candidate competitions
    */
    public function listCandidateCompetitions() {
      $query = "SELECT theme, id date  FROM Competition WHERE curdate() <= deadline;";
      $exec = mysqli_query($this->db, $query);
      return $exec;
    }

    /**
    * list prejury competitions
    */
    public function listPrejuryCompetitions() {
      $query = "SELECT theme, id date  FROM Competition WHERE deadline < curdate() AND curdate() <= prejuryDate;";
      $exec = mysqli_query($this->db, $query);
      return $exec;
    }

    /**
    * list jury competitions
    */
    public function listJuryCompetitions() {
      $query = "SELECT theme, id FROM Competition WHERE prejuryDate < curdate() AND curdate() <= juryDate;";
      $exec = mysqli_query($this->db, $query);
      return $exec;
    }

    /**
    * list competitions over
    */
    public function listOverCompetitions() {
      $query = "SELECT theme, id date  FROM Competition WHERE curdate() > juryDate;";
      $exec = mysqli_query($this->db, $query);
      return $exec;
    }


   /**
    * list available competitions
    */
    public function listAvailableCompetitions() {
      $query = "SELECT theme, id FROM Competition WHERE deadline >= curdate();";
      $exec = mysqli_query($this->db, $query);
      return $exec;
    }
    
    /**
     * get a competition
     * @param id - id of the competition
     */
    public function getCompetition($id) {
      $query = "SELECT * FROM Competition WHERE id=$id ";
      $exec = mysqli_query($this->db,$query);
      return mysqli_fetch_array($exec);
    }

    public function listJurorsMails($id) {
      $query = "SELECT mailUser FROM (SELECT * FROM Jury UNION SELECT * FROM Prejury) AS JurorsMails WHERE competition = '$id';";
      $exec = mysqli_query($this->db,$query);
      $mailArray = array();
      while ($data = mysqli_fetch_array($exec)) {
        $mailArray[] = $data[0];
      } 

      return implode(",", $mailArray);
    }

}



?>