<?php
  if (!$_SESSION) {
    header("Location: /");
  }

  use \model\tables\Competition;
  use \model\tables\RequiredWord;
  use \model\tables\Jury;
  use \model\tables\Prejury;
  use \model\tables\Novella;

  $dataAccess = new Competition;
  $requiredWordAccess = new RequiredWord;
  $juryAccess = new Jury;
  $prejuryAccess = new Prejury;
  $novellaAccess = new Novella;

  if (isset($_GET['id']) && isset($_SESSION['email'])) {
    $competition = $dataAccess->getCompetition($_GET['id']);
    $requiredWords = $requiredWordAccess->getRequiredWords($_GET['id']);
    $isJury = mysqli_fetch_array($juryAccess->getCompetition($_GET['id'], $_SESSION['email']))["points"] != null;
    $isPrejury = mysqli_fetch_array($prejuryAccess->getCompetition($_GET['id'], $_SESSION['email']))["points"] != null;

    $origin = new DateTime("now");
    $target = new DateTime($competition['deadline']);
    $interval = $origin->diff($target);
    $isCompetitionOver = $interval->invert > 0;
    if($isCompetitionOver) {
      $remainingTime = $interval->format('(Terminé depuis %a jours)');
    }
    else {
      $remainingTime = $interval->format('(%a jours restants)');
    }
    $properDate = $target->format("d/m/Y");

    $hasParticipate = $novellaAccess->hasParticipate($_GET['id'],$_SESSION['email'] );
    
  }
  else {
    header("Location: ?action=forbidden");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novelis - Concours</title>
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
      <h1 id="title"><?php echo $competition['theme']; ?></h1>
      <div class="infos">
        <h2 class="infos__title">Incipit :</h2>
        <p class="infos__contenu"><?php echo $competition['incipit'] ?></p>
        <h2 class="infos__title">Deadline :</h2>
        <p class="infos__contenu"><?php echo $properDate." ".$remainingTime ?></p>
        <h2 class="infos__title">Mots requis :</h2>
        <p class="infos__contenu" id="motsRequis">
          <?php if(mysqli_fetch_array($requiredWords) != null) {
            while ($data = mysqli_fetch_array($requiredWords)) {
              echo $data[0] ?>, <?php
            }
          } else { ?>Aucun mot requis.<?php
          } ?>
          </p>
      </div>

    <form class="form" action="?action=participate&id=<?php echo $competition['id'] ?>" method="POST">
      <p class="infos__error">
      <?php 
        if($isJury || $isPrejury) {
          echo "En tant que membre du ".($isPrejury? "pré-" : "")."jury, vous n'êtes pas autorisé à participer à ce concours.";
        }
        if($isCompetitionOver) {
          echo "Concours terminé, vous ne pouvez plus y participer.";
        }
        if($hasParticipate) {
          echo "Vous avez déjà participé à ce concours";
        }
      ?> </p>
      <input class='form__login__submit <?= ($isPrejury || $isJury || $isCompetitionOver || $hasParticipate) ? "hide" : ""?>' type="submit" value="Participer" />
    </form>
  </main>
</body>

<script>
  document.body.querySelector("#motsRequis").textContent = document.body.querySelector("#motsRequis").textContent.slice(0, -2)
</script>

</html>