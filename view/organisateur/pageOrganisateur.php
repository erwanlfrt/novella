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
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novelis - Organisateur</title>
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
        <a class="header__link" href="?action=myAccount">GÉRER MON COMPTE</a>
        <a class="header__link" href="?action=disconnect">DÉCONNEXION</a>
      </div>
    </header>
    <main>
      <h1 id="title">Espace organisateur</h1>

      <div class="container">
        <h2 class="container__title">Liste Concours</h2>
        <a class="button" href="?action=newCompetition">Ajouter un concours</a>
        <table>
          <thead>
            <tr>
              <th>Compétition</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($data = mysqli_fetch_array($listCompetition)) { ?>
              <tr>
                <td><?= $data[0] ?></td>
                <td><a class="table__link" href="mailto:<?= $competition->listJurorsMails($data[1]) ?>">Envoyer un mail à tous les concernés</a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      
      <div class="container">
        <h2 class="container__title">Gestion utilisateurs</h2>
        <table>
          <thead>
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th colspan="3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($data = mysqli_fetch_array($listUsers)) { ?>
                <tr>
                  <td><?= $data[0] ?></td>
                  <td><?= $data[1] ?></td>
                  <td><?= $data[2] ?></td>
                  <td><a class="table__link" href="?action=manageUser&mail=<?= $data[2] ?>">Ajouter a un concours</a></td>
                  <td><a class="table__link" href="?action=userHistory&mail=<?= $data[2] ?>">Historique des concours</a></td>
                  <td><a class="table__link" href="?action=updateUser&delete&mail=<?= $data[2] ?>">Supprimer</a></a></td>
                </tr>
              <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="container">
        <h2 class="container__title">Liste Pré-Jurys</h2>
        <table>
          <thead>
            <tr>
              <th>Compétition</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th>Points</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($data = mysqli_fetch_array($listPrejurors)) { ?>
              <tr>
                <td><?= $data['theme'] ?></td>
                <td><?= $data['name'] ?></td>
                <td><?= $data['firstname'] ?></td>
                <td><?= $data['mail'] ?></td>
                <td><?= $data['points'] ?></td>
                <td><a class="table__link" href="#">Supprimer</a></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="container">
        <h2 class="container__title">Liste Jurys</h2>
        <table>
          <thead>
            <tr>
              <th>Compétiton</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th>Points</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($data = mysqli_fetch_array($listJurors)) { ?>
              <tr>
                <td><?= $data['theme'] ?></td>
                <td><?= $data['name'] ?></td>
                <td><?= $data['firstname'] ?></td>
                <td><?= $data['mail'] ?></td>
                <td><?= $data['points'] ?></td>
                <td><a class="table__link" href="#">Supprimer</a></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </main>
  </body>
</html>