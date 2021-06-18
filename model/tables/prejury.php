<?php
namespace model\tables;

use \model\DatabaseConnection;

class Prejury {
  private $db;

  public function __construct() {
    $this->db = DatabaseConnection::getDatabaseConnection();
  }

  /**
   * add a competition
   */
  public function addPrejury() {
    if(isset($_POST['competition']) && isset($_POST['mail'])) {
      $competition =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['competition']));
      $mail =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['mail']));

      if($competition !== "" && $mail !== "") {
        $query = "INSERT INTO Prejury (competition, mailUser, points) VALUES ('$competition', '$mail', 1000);";
        
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
  public function deletePrejury() {
    $mail =  mysqli_real_escape_string($this->db, htmlspecialchars($_POST['mail']));
    $queryCheck = "SELECT COUNT(*) FROM Prejury WHERE mailUser=$mail";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $result = mysqli_fetch_array($execCheck);
    if($result['COUNT(*)'] !== 0){
      $query = "DELETE FROM Prejury WHERE mail=$mail";
      $execRequest = mysqli_query($this->db, $query);
      header('Location: ?action=pageOrganisateur');
    }
  }

  /**
   * list all existing competitions
   */
   public function listPrejurors() {
      $query = "SELECT theme, mailUser, points FROM Prejury INNER JOIN Competition ON prejury.competition = competition.id ";
      $exec = mysqli_query($this->db, $query);
      return $exec;
   }

}



?>