<?php
  if (!$_SESSION) {
    header("Location: /");
  }

  use \model\tables\Vote;
  use \model\tables\Jury;
  use \model\tables\Novella;
  use \model\tables\Prejury;
  use \model\tables\Competition;

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

  $competitionAccess = new Competition;
  $competitionData = $competitionAccess->getCompetition($id);

  $juryAccess = new Jury;
  $prejuryAccess = new Prejury;

  $pre = "";
  if (isset($_GET['pre'])) {
    $isPrejury = true;
    $pre = "&pre";
    $jury = $prejuryAccess->getCompetition($competition, $_SESSION['email']);
  } else {
    $isPrejury = false;
    $jury = $juryAccess->getCompetition($competition, $_SESSION['email']);
  }

  $juryResult = mysqli_fetch_array($jury);
  $remainingPoints = $juryResult['2'];

  $voteAccess = new Vote;
  $vote = $voteAccess->getVote($competition, $_SESSION['email'], $id, $isPrejury);
  if ($vote !== false && $vote !== null) {
    $voteResult = mysqli_fetch_array($vote);
    if ($voteResult === null) {
      $givenPoints =  0;
    }
    else {
      $givenPoints = $voteResult[0];
    }
  } else {
    $givenPoints =  0;
  }

  $maxPoints = $remainingPoints + $givenPoints;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novelis - Vote</title>
    <link rel="stylesheet" href="view/style/globalStyle.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;500;900&display=swap');
    </style> 
  </head>
  <body>
    <header>
      <a href="?action=home">
        <div class="header__left"></div>
      </a>
      <div class="header__right">
        <?php if ($_SESSION['admin']) { ?>
          <a class="header__link" href="?action=pageOrganisateur">ESPACE ORGANISATEUR</a> <?php ;
        } ?>
        <a class="header__link" href="?action=myAccount">GÉRER MON COMPTE</a>
        <a class="header__link" href="?action=disconnect">DÉCONNEXION</a>
      </div>
    </header>
    <main>
      <h1>Vote du concours : <?php echo $competitionData['theme'] ?></h1>
      <div class="read__container">
        <h2 class="read__title"><?php echo $title ?></br><span class="read__title__min"><?php echo $anonymousID ?></span></h2>
        <textarea class="read__textarea" readonly><?php echo $text ?></textarea>
        <form method="post" action="?action=verify&id=<?php echo $id; ?>">
          <input class="form__login__button" type="submit" value="<?php echo ($verified ? "Cette nouvelle est conforme" : "Signaler cette nouvelle")  ?>" />
        </form>
        <form class="read__note__container" method="post" action="?action=juryVoted<?php echo $pre; ?>&id=<?php echo $id; ?>">
          <input name="slider" type="range" min="0" max="1000" value="<?php echo $givenPoints ?>" class="slider" id="slider">
          <p class="read__note" id="sliderValue"></p>
          <input class="form__login__submit" id="voteSubmit" type="submit" value="Soumettre mon vote" <?php echo ($verified ? "disabled" : "") ?> />
        </form>
      </div>
    </main>
  </body>
  <script>
    var slider = document.getElementById("slider");
    var output = document.getElementById("sliderValue");
    output.innerText = slider.value;
    slider.oninput = function() {
      //check if value greater than max points
      if (this.value > <?php echo $maxPoints ?>) {
        this.value = <?php echo $maxPoints ?>;
      }
      output.innerText = this.value;
    }
  </script>
</html>