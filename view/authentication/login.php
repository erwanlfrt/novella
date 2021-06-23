<?php 
session_destroy();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novella - Accueil</title>
    <link rel="stylesheet" href="view/style/globalStyle.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;500;900&display=swap');
    </style> 
  </head>
  <body>
    <main>
      <h1 id="title">Novella</h1>
      <!--<p id="logo">logo super stylé ici</p>-->
      <form class="form" action="?action=check" method="post">
        <h2 class="form__title">Connexion</h2>
        <div class="form__login">
            <input type="text" class="form__login__input" id="email" name="email" placeholder="Votre email">
            <input type="password" class="form__login__input" id="password" name="password" placeholder="Votre mot de passe">
            <input type="submit" class="form__login__submit" id='submit' value="Connexion">
        </div>
        <div class="form__sub">
          <?php
            if(isset($_GET['erreur'])){
              $err = $_GET['erreur'];
              if($err==1)
              {
                echo "<p class='form__sub__error'>Formulaire incomplet.</p>";
              }
              elseif($err==2){
                echo "<p class='form__sub__error'>Utilisateur déjà existant.</p>";
              }
              elseif($err==3)
              {
                echo "<p class='form__sub__error'>Mot de passe invalide.</p>";
              }
              elseif($err==4)
              {
                echo "<p class='form__sub__error'>Identifiant ou mot de passe invalide.</p>";
              }
            }
          ?>
        </div>
        <div class="form__sub">
          <p class="form__sub__content">Pas encore de compte ? <a class="form__sub__link" href="/?action=signup">Inscrivez-vous !</a></p>
          <p class="form__sub__content"><a class="form__sub__link" href="/?action=resetPwd">Mot de passe oublié ?</a></p>
        </div>
      </form>
    </main>
  </body>
</html>