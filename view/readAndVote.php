<?php 
session_status() === PHP_SESSION_ACTIVE ?: session_start();
require_once('model/tables/novella.php');
require_once('model/tables/jury.php');
require_once('model/tables/vote.php');
require_once('model/tables/prejury.php');
use \model\tables\Vote;
use \model\tables\Jury;
use \model\tables\Novella;
use \model\tables\Prejury;

$novellaAccess = new Novella;
$novella = $novellaAccess->getNovella($_GET['id']);

$data = mysqli_fetch_array($novella);
$id = $data[0];
$title = $data[1];
$text = $data[2];
$verified = $data[3];
$competition = $data[4];
$mailUser = $data[5];
$anonymousID = $data[6];

$juryAccess = new Jury;
$prejuryAccess = new Prejury;

$pre="";
if(isset($_GET['pre'])) {
  $isPrejury = true;
  $pre="&pre";
  $jury = $prejuryAccess->getCompetition($competition, $_SESSION['email']);
}
else {
  $isPrejury = false;
  $jury = $juryAccess->getCompetition($competition, $_SESSION['email']);
}

$juryResult = mysqli_fetch_array($jury);
$remainingPoints = $juryResult['2'];

$voteAccess = new Vote;
$vote = $voteAccess->getVote($competition, $_SESSION['email'],$id,$isPrejury);
if($vote !== false && $vote !== null) {
  $voteResult = mysqli_fetch_array($vote);
  $givenPoints = $voteResult[0];
  if($givenPoints === null) {
    $givenPoints =  0;
  }
}
else {
  $givenPoints =  0;
}

$maxPoints = $remainingPoints + $givenPoints;



?>
<html>
  <head>
    <title>Novella</title>
  </head>
  <body>
    <h1><?php echo $title ?></h1>
    <h3>écrit par <?php echo $anonymousID ?></h3>
    <textarea readonly><?php echo $text ?></textarea>
    
    <form method="post" action="?action=verify&id=<?php echo $id; ?>">
      <input type="submit" value="<?php echo ($verified ? "signaler comme conforme" : "signaler")  ?>"/>
    </form>

    <form method="post" action="?action=juryVoted<?php echo $pre; ?>&id=<?php echo $id; ?>">
      <input name="slider" type="range" min="0" max="1000" value="<?php echo $givenPoints ?>" class="slider" id="slider">
      <p id="sliderValue"></p>
      <input id="voteSubmit" type="submit" value="voter" <?php echo ($verified ? "disabled" : "")?>/>
    </form>
  </body>
  <script>
    var slider = document.getElementById("slider");
    var output = document.getElementById("sliderValue");
    output.innerText = slider.value;
    slider.oninput = function() {
      //check if value greater than max points
      if(this.value > <?php echo $maxPoints ?>) {
        this.value = <?php echo $maxPoints ?>;
      }
      output.innerText = this.value;
    }
  </script>
</html>