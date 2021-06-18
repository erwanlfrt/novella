<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();

use \model\tables\User;

$user = new User;
$listUsers = $user->listUsers();

?>
<html>
  <head>
    <title>Novella - Espace organisateur</title>
  </head>
  <body>
    <h1>Espace organisateur</h1>
    <p>Bonjour <?php echo $_SESSION["firstname"]?></p>
    <div>
        <a href="?action=newCompetition" >Ajouter concour</a>
        <h2>Gérer utilisateurs</h2>
        <table>
        <thead>
          <tr>
              <th>Nom</th>
              <th>Prenom</th>
              <th colspan="3">options</th>
          </tr>
        </thead>
        <?php
        while($data = mysqli_fetch_array($listUsers)){
          ?>
          <tr>
            <td><?= $data[0]?></td>
            <td><?= $data[1]?></td>
            <td><a href="#">Ajouter jury</a></td>
            <td><a href="#">Ajouter prejury</a></td>
            <td><a href="#">Supprimer</a></a></td>
          </tr>
          <?php
         }
        ?>
        </table>
        <h2>Catalogue jury</h2>
    </div>
  </body>
</html>

