<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();

require_once 'model/tables/competition.php';
require_once 'model/tables/requiredWord.php';
use \model\tables\Competition;
use \model\tables\RequiredWord;

$dataAccess = new Competition;
$requiredWordAccess = new RequiredWord;

if(isset($_GET['id'])) {
  $competition = $dataAccess->getCompetition($_GET['id']);
  $requiredWords = $requiredWordAccess->getRequiredWords($_GET['id']);
}


?>

<html>
  <head>
    <title>Novella</title>
  </head>
  <body>
    <h2>thème: <?php echo $competition['theme']; ?></h2>
    <p>incipit: <?php echo $competition['incipit'] ?></p>
    <p>deadline: <?php echo $competition['deadline'] ?></p>
    <div>
      <h3>Mots requis:</h3>
      <ul>
        <?php
        while($data = mysqli_fetch_array($requiredWords)){
          ?><li><?php echo $data[0]?></li><?php
         }
        ?>
      </ul>
    </div>

    <form action="?action=participate&id=<?php echo $competition['id'] ?>" method="POST">
      <input type="submit" value="Participer" />
    </form>
  </body>
</html>