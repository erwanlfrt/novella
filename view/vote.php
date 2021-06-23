<?php

if (!$_SESSION) {
  header("Location: /");
}

use \model\tables\Novella;
use \model\tables\Jury;
use \model\tables\Prejury;
use \model\tables\Competition;


if(isset($_GET['id'])) {
  $novella = new Novella;
  $id = $_GET['id'];
  $novellas = $novella->listNovellas($id);
  
  $pre = "";
  
  
  $competitionAccess = new Competition;
  $competition = $competitionAccess->getCompetition($id);
  if (isset($_GET['pre'])) {
    $pre = "&pre";
    $juryAccess = new Prejury;
    $deadline = $competition['prejuryDate'];
  } else {
    $juryAccess = new Jury;
    $deadline = $competition['juryDate'];
  }

  $origin = new DateTime("now");
  $target = new DateTime($deadline);
  $interval = $origin->diff($target);
  $isCompetitionOver = $interval->invert > 0;
  echo $isCompetitionOver;

  if($isCompetitionOver) {
    header("Location: ?action=forbidden&over");
    die();
  }
  
  $jury = $juryAccess->getCompetition($id, $_SESSION["email"]);
  $remainingPoints = mysqli_fetch_array($jury)[2];
  
  if($remainingPoints == null) {
    header("Location: ?action=forbidden");
  }
}
else {
  header("Location: ?action=forbidden");
}



?>
<html>

<head>
  <title>Novella</title>
</head>

<body>
  <h1>Vote</h1>
  <div>
    <?php
    while ($data = mysqli_fetch_array($novellas)) {
      ?><li><a href="?action=readAndVote<?php echo $pre; ?>&id=<?php echo $data[0] ?>"><?php echo $data[1]; ?></a></li><?php
    }?>
  </div>
  <h3>points restants = <?php echo $remainingPoints ?></h3>

</body>

</html>