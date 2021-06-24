<?php
  
  if (!$_SESSION) {
    header("Location: /");
  }

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
    <title>Novelis - Accueil</title>
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
      <h1 id="title">Bonjour <?php echo $_SESSION["firstname"]?> !</h1>
      <div class="container">
        <h2 class="container__title">Concours actifs</h2>
        <?php if($listCompetition->num_rows > 0) { ?>
          <ul class="container__list">
            <?php
              while($data = mysqli_fetch_array($listCompetition)) { ?>
                <a href="?action=showCompetition&id=<?php echo $data[1] ?>">
                  <li class="container__element">
                    <p class="container__link"><?php echo $data[0]; ?></p>
                  </li>
                </a> <?php
              }
            ?>
          </ul>
        <?php } else { ?>
          <p class="container__empty">Aucun concours actif ne vous est disponible.</p>
        <?php } ?>
      </div>

      <div class="container">
        <h2 class="container__title">Jury</h2>
        <?php if($listJuryCompetition->num_rows > 0) { ?>
        <ul class="container__list">
          <?php      
            while($data = mysqli_fetch_array($listJuryCompetition)) { ?>
              <a href="?action=vote&id=<?php echo $data[0] ?>">
                <li class="container__element">
                  <p class="container__link"><?php echo $data[1]; ?></p>
                </li>
              </a> <?php
            } 
          ?>
        </ul>
        <?php } else { ?>
          <p class="container__empty">Aucun concours en phase de Jury ne vous est disponible.</p>
        <?php } ?>
      </div>
        
      <div class="container">
        <h2 class="container__title">Pré-jury</h2>
        <?php if($listPrejuryCompetition->num_rows > 0) { ?>
        <ul class="container__list">
          <?php      
            while($data = mysqli_fetch_array($listPrejuryCompetition)) { ?>
              <a href="?action=vote&pre&id=<?php echo $data[0] ?>">
                <li class="container__element">
                  <p class="container__link"><?php echo $data[1]; ?></p>
                </li>
              </a> <?php
            } 
          ?>
        </ul>
        <?php } else { ?>
          <p class="container__empty">Aucun concours en phase de Pré-Jury ne vous est disponible.</p>
        <?php } ?>
      </div>
      
      <div class="container">
        <h2 class="container__title">Résultats</h2>
        <?php if($listOverCompetitions->num_rows > 0 || $listShowCandidateCompetitions->num_rows > 0 || $listShowPrejuryCompetitions->num_rows > 0 || $listShowJuryCompetitions->num_rows > 0) { ?>
        <ul class="container__list">
          <?php      
            while($data = mysqli_fetch_array($listOverCompetitions)) { ?>
              <a href="?action=result&id=<?php echo $data[1] ?>">
                <li class="container__element">
                  <p class="container__tag">Terminé</p>
                  <p class="container__link"><?php echo $data[0]; ?></p>
                </li>
              </a> <?php
            }
            if($_SESSION['admin']) {
              while($data = mysqli_fetch_array($listShowCandidateCompetitions)) { ?>
                <a href="?action=result&id=<?php echo $data[1] ?>">
                  <li class="container__element">
                    <p class="container__tag">En cours</p>
                    <p class="container__link"><?php echo $data[0]; ?></p>
                  </li>
                </a> <?php
              }
              while($data = mysqli_fetch_array($listShowPrejuryCompetitions)) { ?>
                <a href="?action=result&id=<?php echo $data[1] ?>">
                  <li class="container__element">
                    <p class="container__tag">Pré-jury</p>
                    <p class="container__link"><?php echo $data[0]; ?></p>
                  </li>
                </a> <?php
              }

              while($data = mysqli_fetch_array($listShowJuryCompetitions)) { ?>
                <a href="?action=result&id=<?php echo $data[1] ?>">
                  <li class="container__element">
                    <p class="container__tag">Jury</p>
                    <p class="container__link"><?php echo $data[0]; ?></p>
                  </li>
                </a> <?php
              }
            }
          ?>
        </ul>
        <?php } else { ?>
          <p class="container__empty">Aucun concours en phase de Résultat ne vous est disponible.</p>
        <?php } ?>
      </div>
    </main>
  </body>
</html>