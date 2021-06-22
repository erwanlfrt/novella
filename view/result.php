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

?>

<html>

<head>
  <title>Novella</title>
</head>

<body>
  <h1>Résultat du concours <?php echo $competition['theme'] ?> </h1>
  <h3>Classement :</h3>
  <div>
    <ul>
      <?php
      $place = 1;
      foreach (array_keys($scores) as $score) {
        $novella = mysqli_fetch_array($novellaAccess->getNovella($score));
        $title = $novella['title'];
        $mailWritter = $novella['mailUser'];
        $user = $userAccess->getUser($mailWritter);
        $data = mysqli_fetch_array($user);
        $name = $data['name'];
        $firstname = $data['firstname'];
      ?><li><?php echo $place . " " . $firstname . " " . $name ?> avec un score de <?php echo $scores[$score] ?> pour sa nouvelle intitulé <?php echo $title ?></li><?php
                                                                                                                                                              $place++;
                                                                                                                                                            } ?>
    </ul>
  </div>
</body>

</html>