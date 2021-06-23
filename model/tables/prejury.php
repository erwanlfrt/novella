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
   * update prejury points
   */
  public function editPrejury($competition, $email, $newPoints) {
    $safeCompetition = mysqli_real_escape_string($this->db, htmlspecialchars($competition));
    $safeMail = mysqli_real_escape_string($this->db, htmlspecialchars($email));
    $safePoints = mysqli_real_escape_string($this->db, htmlspecialchars($newPoints));

    $query = "UPDATE Prejury SET points=$safePoints WHERE competition=$safeCompetition AND mailUser='$email';";
    $exec = mysqli_query($this->db, $query);
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
      $query = "SELECT theme, name, firstname, mail, points FROM Prejury, Competition, Users WHERE Prejury.competition = Competition.id AND Prejury.mailUser = Users.mail ORDER BY Prejury.competition";
      $exec = mysqli_query($this->db, $query);
      return $exec;
   }

   /**
  * list competitions for a specific jury
  */
  public function listCompetitions($mail) {
    $email =  mysqli_real_escape_string($this->db, htmlspecialchars($mail));
    // header('Location: ?action='.$email);
    $query = "SELECT competition, theme, points FROM Prejury, Competition WHERE Prejury.competition = Competition.id  AND deadline < curdate()  AND curdate() < prejuryDate AND mailUser='$email'";
    $exec = mysqli_query($this->db, $query);
    return $exec;
  }

  /**
   * get a specific competiton for a specific jury.
   */
  public function getCompetition($competition,$mail) {
    $safeCompetition =  mysqli_real_escape_string($this->db, htmlspecialchars($competition));
    $safeMail =  mysqli_real_escape_string($this->db, htmlspecialchars($mail));
    $query = "SELECT competition, theme, points FROM Prejury, Competition WHERE Prejury.competition = Competition.id AND Competition.id = $safeCompetition AND deadline < curdate() AND mailUser='$safeMail'";
    $exec = mysqli_query($this->db, $query);
    return $exec;
  }

}



?>