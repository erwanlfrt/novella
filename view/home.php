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
$listCompetition2 = $competition->listCompetitions();

$jury = new Jury;
$listJuryCompetition = $jury->listCompetitions($_SESSION['email']);


$prejury = new Prejury;
$listPrejuryCompetition = $prejury->listCompetitions($_SESSION['email']);

?>
<html>
  <head>
    <title>Novella</title>
  </head>
  <body>
    <h1>Home</h1>
    <p>Bonjour <?php echo $_SESSION["firstname"]?></p>
    <p><?php if ($_SESSION['admin']) {
      ?><a href="?action=pageOrganisateur">Espace organisateur</a><?php ;
    } ?></p>
    <a href="?action=myAccount"><p>Gérer mon compte</p></a>
    <div>
      <h2>Concours</h2>
      <ul>
        <?php
        while($data = mysqli_fetch_array($listCompetition)){
          ?><li><a href="?action=showCompetition&id=<?php echo $data[1] ?>"><?php echo $data[0]; ?> </a></li><?php
         }
        ?>
      </ul>
    </div>

    <div>
      <h2>Jury</h2>
      <?php      
        while($data = mysqli_fetch_array($listJuryCompetition)){
          ?><li><a href="?action=vote&id=<?php echo $data[0] ?>"><?php echo $data[1]; ?></a></li><?php
         } 
        ?>
    </div>
    
    <?php if($listPrejuryCompetition !== false && $listPrejuryCompetition !== null) {
    ?>        
      <div>
        <h2>Prejury</h2>
        <?php      
          
          while($data = mysqli_fetch_array($listPrejuryCompetition)){
            ?><li><a href="?action=vote&pre&id=<?php echo $data[0] ?>"><?php echo $data[1]; ?></a></li><?php
          } 
          ?>
      </div>
    <?php } ?>
  
    <div>
      <h2>Résultat</h2>
      <?php      
        while($data = mysqli_fetch_array($listCompetition2)){
          ?><li><a href="?action=result&id=<?php echo $data[1] ?>"><?php echo $data[0]; ?> </a></li><?php
         }
        ?>
    </div>
  </body>

  
</html>