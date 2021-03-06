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
    
    $pre = "";
    
    $competitionAccess = new Competition;
    $competition = $competitionAccess->getCompetition($id);
    if (isset($_GET['pre'])) {
      $pre = "&pre";
      $juryAccess = new Prejury;
      $deadline = $competition['prejuryDate'];
      $novellas = $novella->listNovellas($id);
    } else {
      $juryAccess = new Jury;
      $deadline = $competition['juryDate'];
      $novellas = $novella->selectTopTen($id);
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
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novelis - Votes</title>
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
      <h1>Vote du concours : <?php echo $competition['theme'] ?></h1>
      <ul class="container__list">
        <?php while ($data = mysqli_fetch_array($novellas)) { ?>
          <a href="?action=readAndVote<?php echo $pre; ?>&id=<?php echo $data[0] ?>">
            <li class="container__element">
              <p class="container__link"><?php echo $data[1]; ?></p>
            </li>
          </a> <?php
        } ?>
      </ul>
      <h3 class="vote__points">Points restants : <?php echo $remainingPoints ?></h3>
    </main>
  </body>
</html>