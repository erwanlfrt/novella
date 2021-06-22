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
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novella - Concours</title>
    <link rel="stylesheet" href="view/style/globalStyle.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;500;900&display=swap');
    </style> 
  </head>
  <body>
    <main>
      <h1 id="title"><?php echo $competition['theme']; ?></h1>
      <div class="infos">
        <h2 class="infos__title">Incipit :</h2>
        <p class="infos__contenu"><?php echo $competition['incipit'] ?></p>
        <h2 class="infos__title">Deadline :</h2>
        <p class="infos__contenu"><?php echo $competition['deadline'] ?></p>
        <h2 class="infos__title">Mots requis :</h2>
        <p class="infos__contenu" id="motsRequis"><?php 
          while($data = mysqli_fetch_array($requiredWords)) {
            echo $data[0] ?>, <?php
          } ?></p>
      </div>

      <form class="form" action="?action=participate&id=<?php echo $competition['id'] ?>" method="POST">
        <input class="form__login__submit" type="submit" value="Participer" />
      </form>
    </main>
  </body>

  <script>
    document.body.querySelector("#motsRequis").textContent = document.body.querySelector("#motsRequis").textContent.slice(0, -2)
  </script>
</html>