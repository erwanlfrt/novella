<?php
namespace model\tables;

use \model\DatabaseConnection;

class Jury {
  private $db;

  public function __construct() {
    $this->db = DatabaseConnection::getDatabaseConnection();
  }

  /**
   * add a competition
   */
  public function addJury() {
    if(isset($_POST['competition']) && isset($_POST['mail'])) {
      $competition =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['competition']));
      $mail =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['mail']));

      if($competition !== "" && $mail !== "") {
        $query = "INSERT INTO Jury (competition, mailUser, points) VALUES ($competition, '$mail', 1000);";

        $execRequest = mysqli_query($this->db, $query);
        if ($execRequest) {
            header('Location: ?action=pageOrganisateur');
        } else {
            header('Location: ?action=pageOrganisateur&erreur=1'); // requete pas passée
        }
        
      }
    }
  }

  /**
   * delete a competition.
   */
  public function deleteJury() {
    $mail =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['mail']));
    $queryCheck = "SELECT COUNT(*) FROM Jury WHERE mailUser=$mail";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $result = mysqli_fetch_array($execCheck);
    if($result['COUNT(*)'] !== 0){
      $query = "DELETE FROM Jury WHERE mail=$mail";
      $execRequest = mysqli_query($this->db, $query);
      header('Location: ?action=pageOrganisateur');
    }
  }

  /**
   * list all existing competitions
   */
   public function listJurors() {
      $query = "SELECT theme, mailUser, points FROM Jury INNER JOIN Competition ON jury.competition = competition.id ";
      $exec = mysqli_query($this->db, $query);
      return $exec;
   }

}



?>