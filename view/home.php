<?php
  session_status() === PHP_SESSION_ACTIVE ?: session_start();

  require_once 'model/tables/competition.php';
  require_once 'model/tables/jury.php';
  require_once 'model/tables/prejury.php';
  use \model\tables\Competition;
  use \model\tables\Jury;
  use \model\tables\Prejury;

  $competition = new Competition;
  $listCompetition = $competition->listAvailableCompetitions();
  $listOverCompetitions = $competition->listOverCompetitions();
  $listShowCandidateCompetitions = $competition->listCandidateCompetitions();
  $listShowPrejuryCompetitions = $competition->listPrejuryCompetitions();
  $listShowJuryCompetitions = $competition->listJuryCompetitions();

  $jury = new Jury;
  $listJuryCompetition = $jury->listCompetitions($_SESSION['email']);

  $prejury = new Prejury;
  $listPrejuryCompetition = $prejury->listCompetitions($_SESSION['email']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novella - Accueil</title>
    <link rel="stylesheet" href="view/style/globalStyle.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;500;900&display=swap');
    </style> 
  </head>
  <body>
    <main>
      <h1 id="title">Bonjour <?php echo $_SESSION["firstname"]?> !</h1>
      <div class="home__access">
        <?php 
          if ($_SESSION['admin']) { ?>
            <a class="home__access__link" href="?action=pageOrganisateur">Espace organisateur</a> <?php ;
          }
        ?>
        <a class="home__access__link" href="?action=myAccount"><p>Gérer mon compte</p></a>
      </div>
      <div class="container">
        <h2 class="container__title">Concours</h2>
        <ul class="container__list">
          <?php
            while($data = mysqli_fetch_array($listCompetition)) { ?>
              <li class="container__element">
                <a class="container__link" href="?action=showCompetition&id=<?php echo $data[1] ?>"><?php echo $data[0]; ?></a>
              </li> <?php
            }
          ?>
        </ul>
      </div>
      <div class="container">
        <h2 class="container__title">Jury</h2>
        <ul class="container__list">
          <?php      
            while($data = mysqli_fetch_array($listJuryCompetition)) { ?>
              <li class="container__element">
                <a class="container__link" href="?action=vote&id=<?php echo $data[0] ?>"><?php echo $data[1]; ?></a>
              </li> <?php
            } 
          ?>
        </ul>
      </div>
      
      <?php if($listPrejuryCompetition !== false && $listPrejuryCompetition !== null) { ?>        
        <div class="container">
          <h2 class="container__title">Pré-jury</h2>
          <ul class="container__list">
            <?php      
              while($data = mysqli_fetch_array($listPrejuryCompetition)) { ?>
                <li class="container__element">
                  <a class="container__link" href="?action=vote&pre&id=<?php echo $data[0] ?>"><?php echo $data[1]; ?></a>
                </li> <?php
              } 
            ?>
          </ul> 
        </div>
      <?php } ?>
      <div class="container">
        <h2 class="container__title">Résultats</h2>
        <ul class="container__list">
          <?php      
            while($data = mysqli_fetch_array($listOverCompetitions)) { ?>
              <li class="container__element">
                <a class="container__link" href="?action=result&id=<?php echo $data[1] ?>"><?php echo $data[0]; ?> </a>
              </li> <?php
            }
            if($_SESSION['admin']) {
              while($data = mysqli_fetch_array($listShowPrejuryCompetitions)) { ?>
                <li class="container__element" style="background-color : green">
                  <a class="container__link" href="?action=result&id=<?php echo $data[1] ?>"><?php echo $data[0]; ?> </a>
                </li> <?php
              }

              while($data = mysqli_fetch_array($listShowJuryCompetitions)) { ?>
                <li class="container__element" style="background-color : blue">
                  <a class="container__link" href="?action=result&id=<?php echo $data[1] ?>"><?php echo $data[0]; ?> </a>
                </li> <?php
              }
            }
          ?>
        </ul>
      </div>
    </main>
  </body>
</html>