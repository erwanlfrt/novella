<?php

session_status() === PHP_SESSION_ACTIVE ?: session_start();
require_once 'model/tables/competition.php';
use \model\tables\Competition;

$dataAccess = new Competition;

if(isset($_GET['id'])) {
  $competition = $dataAccess->getCompetition($_GET['id']);
}


?>

<html>
  <head>
    <title>Novella</title>
  </head>
  <body>
    <h1>Concours: <?php echo $competition['theme']?></p>
    <form style="display: flex; flex-direction: column; align-items: flex-start;" action="?action=addNovella&id=<?php echo $competition['id']?>">
      <input type="text" name="title" placeholder="titre">
      <input type="file" name="file">
      <textarea rows="10" cols="150" name="text" placeholder="<?php echo $competition['incipit']?>..."></textarea>
      <input type="submit" value="submit">
    </form>
  </body>
</html>