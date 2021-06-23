<?php

if (!$_SESSION) {
  header("Location: /");
}

use \model\tables\Competition;
use \model\tables\RequiredWord;
use \model\tables\Jury;
use \model\tables\Prejury;

$dataAccess = new Competition;
$requiredWordAccess = new RequiredWord;
$juryAccess = new Jury;
$prejuryAccess = new Prejury;

if (isset($_GET['id'])) {
  $competition = $dataAccess->getCompetition($_GET['id']);
  $requiredWords = $requiredWordAccess->getRequiredWords($_GET['id']);
  $isJury = mysqli_fetch_array($juryAccess->getCompetition($_GET['id'], $_SESSION['email']))["points"] != null;
  $isPrejury = mysqli_fetch_array($prejuryAccess->getCompetition($_GET['id'], $_SESSION['email']))["points"] != null;

  $origin = new DateTime("now");
  $target = new DateTime($competition['deadline']);
  $interval = $origin->diff($target);
  $isCompetitionOver = $interval->invert > 0;
  if($isCompetitionOver) {
    $remainingTime = $interval->format('(terminé depuis %a jours)');
  }
  else {
    $remainingTime = $interval->format('(%a jours restants)');
  }
  
  $properDate = $target->format("d / m / Y");

}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Novella - Concours</title>
  <link rel="stylesheet" href="view/style/globalStyle.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;500;900&display=swap');
  </style>
</head>

<body>
  <main>
    <h1 id="title"><?php echo $competition['theme']; ?></h1>
    <div class="infos">
      <h2 class="infos__title">Incipit :</h2>
      <p class="infos__contenu"><?php echo $competition['incipit'] ?></p>
      <h2 class="infos__title">Deadline :</h2>
      <p class="infos__contenu"><?php echo $properDate." ".$remainingTime ?></p>
      <h2 class="infos__title">Mots requis :</h2>
      <p class="infos__contenu" id="motsRequis"><?php
          $count = 0;
          while ($data = mysqli_fetch_array($requiredWords)) {
            $count++;
            echo $data[0] ?>, <?php
          }
          ?></p>
          <?= $count == 0 ? "aucun mot requis" : "" ?>
    </div>

    <form class="form" action="?action=participate&id=<?php echo $competition['id'] ?>" method="POST">
      <p style="color: red">
      <?php 
        if($isJury || $isPrejury) {
          echo "En tant que membre du ".($isPrejury? "pre" : "")."jury vous n'êtes pas autorisé à participer à ce concours<br>";
        }
        if($isCompetitionOver) {
          echo "concours terminé, vous ne pouvez plus y participer";
        }
      ?> </p>
      <input class="form__login__submit" type="submit" value="Participer" <?= ($isPrejury || $isJury || $isCompetitionOver) ? "disabled" : ""?> />
    </form>
  </main>
</body>

<script>
  document.body.querySelector("#motsRequis").textContent = document.body.querySelector("#motsRequis").textContent.slice(0, -2)
</script>

</html>