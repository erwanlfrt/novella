<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();

require_once 'model/tables/competition.php';
use \model\tables\Competition;

$competition = new Competition;
$listCompetition = $competition->listAvailableCompetitions();

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
  </body>
</html>