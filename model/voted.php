<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();

use \model\tables\Novella;
use \model\tables\Jury;
use \model\tables\Prejury;
use \model\tables\Vote;
use \model\DatabaseConnection;

$db = DatabaseConnection::getDatabaseConnection();

$novellaAccess = new Novella;
$juryAccess = new Jury;
$prejuryAccess = new Prejury;
$voteAccess = new Vote;

if(isset($_GET['id']) && isset($_POST['slider'])) {

  //add or edit given score into vote table
  $isPrejury = false;
  if(isset($_GET['pre'])) {
    $isPrejury = true;
  }

  $safeID = mysqli_real_escape_string($db, htmlspecialchars($_GET['id']));
  $safeScoreToAdd = mysqli_real_escape_string($db, htmlspecialchars($_POST['slider']));

  $novella = $novellaAccess->getNovella($safeID);
  $data = mysqli_fetch_array($novella);
  $id = $data[0];
  $title = $data[1];
  $text = $data[2];
  $verified = $data[3];
  $competition = $data[4];
  $mailUser = $data[5];
  $anonymousID = $data[6];

  if($isPrejury) {
    $score = $data[8];
  }
  else {
    $score = $data[7];
  }
  

  

  $vote = $voteAccess->getVote($competition, $_SESSION['email'], $id, $isPrejury);
  if($vote !== false && $vote !== null) {
    $voteResult = mysqli_fetch_array($vote);
  }
  else {
    $voteResult = null;
  }
  
  $old_points = 0;
  if($voteResult !== false && $voteResult !== null) {
    $old_points = $voteResult[0];
    $voteAccess->editVote($competition,$_SESSION['email'],$id, $safeScoreToAdd, $isPrejury);
  }
  else {
    if($isPrejury) {
      $voteAccess->addVote($competition,$_SESSION['email'],$id, $safeScoreToAdd, true);
    }
    else {
      $voteAccess->addVote($competition,$_SESSION['email'],$id, $safeScoreToAdd, false);
    }
    
  }

  //add score to novella
  $newScore = $score - ($old_points - $safeScoreToAdd);

  $novellaAccess->editNovella($id,$title,$text,$verified,$competition,$mailUser,$anonymousID,$newScore, $isPrejury);

  

  // substract points to jury
  if($isPrejury) {
    $jury = $prejuryAccess->getCompetition($competition, $_SESSION['email']);
  }
  else{
    $jury = $juryAccess->getCompetition($competition, $_SESSION['email']);
  }
  $data = mysqli_fetch_array($jury);
  $points = $data[2];

  $newPoints = $points + ($old_points - $safeScoreToAdd);

  if($newPoints < 0) $newPoints = 0;

  if($isPrejury) {
    $prejuryAccess->editPrejury($competition, $_SESSION['email'], $newPoints);
  }
  else {
    $juryAccess->editJury($competition, $_SESSION['email'], $newPoints);
  }
  
  header('Location: ?action=vote&id='.$competition); 
}

?>