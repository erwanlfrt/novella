<?php 

if (!$_SESSION) {
  header("Location: /");
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novella - Mon compte</title>
    <link rel="stylesheet" href="view/style/globalStyle.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;500;900&display=swap');
    </style> 
  </head>
  <body>
    <main>
      <h1 id="title">Gestion de mon compte</h1>
      <form class="form" method="post" action="?action=updateUser&update">
        <h2 class="form__title">Modification</h2>
        <div class="form__login">
          <input type="text" class="form__login__input" name="firstname" value="<?php echo $_SESSION['firstname'] ?>" placeholder="Votre prénom"/>
          <input type="text" class="form__login__input" name="name" value="<?php echo $_SESSION['name'] ?>" placeholder="Votre nom"/>
          <input type="password" class="form__login__input" name="password" placeholder="Votre mot de passe"/>
          <input type="password" class="form__login__input" name="confirmPassword" placeholder="Confirmation de votre mot de passe"/>
          <input type="submit" class="form__login__submit" name="submit" value="Confirmer la modification">
        </div>
      </form>
      <form class="form" method="post" action="?action=updateUser&delete">
        <h2 class="form__title">Suppression</h2>
        <div class="form__login">
          <input type="submit" class="form__login__submit" name="delete" value="Confirmer la suppression"/>
        </div>
      </form>
    </main>
  </body>
</html>