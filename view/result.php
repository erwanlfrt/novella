<?php
  if (!$_SESSION) {
    header("Location: /");
  }

  use \model\tables\Competition;
  use \model\tables\Novella;
  use \model\tables\User;

  if (isset($_GET['id'])) {
    $novellaAccess = new Novella;
    $competitionAccess = new Competition;
    $userAccess = new User;


    $competition = $competitionAccess->getCompetition($_GET['id']);

    $scores = [];

    $novellas = $novellaAccess->listNovellas($_GET['id']);
    while ($datas = mysqli_fetch_array($novellas)) {
      $scores[$datas[0]] = $datas[2];
    }
    arsort($scores);
  }

  $counter = 0;
  foreach (array_keys($scores) as $score) {
    if($scores[$score] > 0) {
      $counter++;
    }
  } 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novelis - Résultats</title>
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
      <h1>Résultats du concours : <?php echo $competition['theme'] ?></h1>
      <?php if(count(array_keys($scores)) > 0 && $counter != 0) { ?>
      <ul class="results__container">
        <?php
          $place = 1;
          foreach (array_keys($scores) as $score) {
            if($scores[$score] > 0) {
            $novella = mysqli_fetch_array($novellaAccess->getNovella($score));
            $title = $novella['title'];
            $mailWritter = $novella['mailUser'];
            $user = $userAccess->getUser($mailWritter);
            $name = $user['name'];
            $firstname = $user['firstname']; ?>
            
            <li class="results__element">
              <p class="results__place"><?php echo $place ?></p>
                <p class="results__infos"><?php echo $title . " - "; echo $firstname . " ("; echo $scores[$score] . ")";?></p>
            </li>
            <?php $place++; 
            }
          } 
        ?>
      </ul>
      <?php } else { ?>
        <p class="container__empty">Aucun résultat n'est disponible.</p>
      <?php } ?>
    </main>
  </body>
</html>