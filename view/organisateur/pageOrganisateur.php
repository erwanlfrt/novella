<?php

if (!$_SESSION['admin']) {
  header("Location: /?action=home");
}

use \model\tables\User;
use \model\tables\Prejury;
use \model\tables\Jury;
use \model\tables\Competition;

$user = new User;
$prejury = new Prejury;
$jury = new Jury;
$competition = new Competition;

$listUsers = $user->listUsers();
$listPrejurors = $prejury->listPrejurors();
$listJurors = $jury->listJurors();
$listCompetition = $competition->listCompetitions();
$listMailByCompetition = $competition->listJurorsMails(3);

?>
<html>

<head>
  <title>Novella - Espace organisateur</title>
</head>

<body>
  <h1>Espace organisateur</h1>
  <p>Bonjour <?php echo $_SESSION["firstname"] ?></p>
  <div>
    <a href="?action=newCompetition">Ajouter concour</a>
    <h2>Gérer utilisateurs</h2>
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Mail</th>
          <th colspan="3">options</th>
        </tr>
      </thead>
      <?php
      while ($data = mysqli_fetch_array($listUsers)) {
      ?>
        <tr>
          <td><?= $data[0] ?></td>
          <td><?= $data[1] ?></td>
          <td><?= $data[2] ?></td>
          <td><a href="?action=manageUser&mail=<?= $data[2] ?>">Ajouter a un concour</a></td>
          <td><a href="?action=userHistory&mail=<?= $data[2] ?>">Historique des concours</a></td>
          <td><a href="?action=updateUser&delete&mail=<?= $data[2] ?>">Supprimer</a></a></td>
        </tr>
      <?php
      }
      ?>
    </table>

    <h2>Concours</h2>
    <table>
      <thead>
        <tr>
          <th>Competition</th>
          <th>Envoyer un mail à tous</th>
        </tr>
      </thead>
      <?php
      while ($data = mysqli_fetch_array($listCompetition)) {
      ?>
        <tr>
          <td><?= $data[0] ?></td>
          <td><a href="mailto:<?= $competition->listJurorsMails($data[1]) ?>">mail</a></td>
        </tr>
      <?php
      }
      ?>
    </table>

    <h2>Catalogue prejury</h2>
    <table>
      <thead>
        <tr>
          <th>Competition</th>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Mail</th>
          <th>Points</th>
          <th>Option</th>
        </tr>
      </thead>
      <?php
      while ($data = mysqli_fetch_array($listPrejurors)) {
      ?>
        <tr>
          <td><?= $data['theme'] ?></td>
          <td><?= $data['name'] ?></td>
          <td><?= $data['firstname'] ?></td>
          <td><?= $data['mail'] ?></td>
          <td><?= $data['points'] ?></td>
          <td><a href="#">Supprimer</a></a></td>
        </tr>
      <?php
      }
      ?>
    </table>


    <h2>Catalogue jury</h2>
    <table>
      <thead>
        <tr>
          <th>Competition</th>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Mail</th>
          <th>Points</th>
          <th>Option</th>
        </tr>
      </thead>
      <?php
      while ($data = mysqli_fetch_array($listJurors)) {
      ?>

        <tr>
          <td><?= $data['theme'] ?></td>
          <td><?= $data['name'] ?></td>
          <td><?= $data['firstname'] ?></td>
          <td><?= $data['mail'] ?></td>
          <td><?= $data['points'] ?></td>
          <td><a href="#">Supprimer</a></a></td>
        </tr>
      <?php
      }
      ?>
    </table>
  </div>
</body>

</html>