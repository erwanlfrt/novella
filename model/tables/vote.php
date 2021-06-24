<?php 

 namespace model\tables;

 use \model\DatabaseConnection;

 class Vote {
   private $db;

  public function __construct(){
  $this->db = DatabaseConnection::getDatabaseConnection();
  }

  public function addVote($competition, $user, $novella, $points, $isPrejury) {
    $safeCompetition = mysqli_real_escape_string($this->db, htmlspecialchars($competition));
    $safeUser = mysqli_real_escape_string($this->db, htmlspecialchars($user));
    $safeNovella = mysqli_real_escape_string($this->db, htmlspecialchars($novella));
    $safePoints = mysqli_real_escape_string($this->db, htmlspecialchars($points));
    $safeIsPrejury = mysqli_real_escape_string($this->db, htmlspecialchars(var_export($isPrejury, true)));

    $query = "INSERT INTO Vote (competition, userMail, idNovella, points, prejury) VALUES ($safeCompetition,'$safeUser',$safeNovella,$safePoints, $safeIsPrejury);";
    $exec = mysqli_query($this->db, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($this->db), E_USER_ERROR);
  }
  
  public function editVote($competition, $user, $novella, $points, $isPrejury) {
    $safeCompetition = mysqli_real_escape_string($this->db, htmlspecialchars($competition));
    $safeUser = mysqli_real_escape_string($this->db, htmlspecialchars($user));
    $safeNovella = mysqli_real_escape_string($this->db, htmlspecialchars($novella));
    $safePoints = mysqli_real_escape_string($this->db, htmlspecialchars($points));
    $safeIsPrejury = mysqli_real_escape_string($this->db, htmlspecialchars(var_export($isPrejury, true)));

    $query = "UPDATE Vote SET points=$safePoints WHERE competition=$safeCompetition AND userMail='$safeUser' AND idNovella=$safeNovella AND prejury=$safeIsPrejury;";
    $exec = mysqli_query($this->db, $query);
  }

  public function getVote($competition, $user, $novella, $isPrejury) {
    $safeCompetition = mysqli_real_escape_string($this->db, htmlspecialchars($competition));
    $safeUser = mysqli_real_escape_string($this->db, htmlspecialchars($user));
    $safeNovella = mysqli_real_escape_string($this->db, htmlspecialchars($novella));
    $safeIsPrejury = mysqli_real_escape_string($this->db, htmlspecialchars(var_export($isPrejury, true)));
    
    $query = "SELECT points FROM Vote WHERE $competition=$safeCompetition AND userMail='$safeUser' AND idNovella=$safeNovella AND prejury=$safeIsPrejury;";
    $exec = mysqli_query($this->db, $query);
    return $exec;
  }

 }


?>