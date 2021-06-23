<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novelis - Réinitialisation</title>
    <link rel="stylesheet" href="view/style/globalStyle.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;500;900&display=swap');
    </style> 
  </head>
  <body>
    <header>
      <a href="?action=home">
        <div class="header__left"></div>
      </a>
      <div class="header__right">
      </div>
    </header>
    <main>
      <form class="form" action="?action=changePwd" method="post">
        <h2 class="form__title">Réinitialisation</h2>
        <div class="form__login">
            <input type="text" class="form__login__input" id="email" name="email" placeholder="Votre email">
            <input type="password" class="form__login__input" id="password" name="password" placeholder="Votre mot de passe">
            <input type="password" class="form__login__input" name="password_confirm" placeholder="Confirmation de votre mot de passe"/>
            <input type="submit" class="form__login__submit" id='submit' value="Réinitialisation de votre mot de passe">
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
              elseif($err==5){
                echo "<p class='form__sub__error'>Cet utilisateur n'existe pas. Voulez-vous <a href='/?action=signup' class='form__sub__link'> vous inscrire ?</a></p>";
              }
            }
          ?>
        </div>
      </form>
    </main>
  </body>
</html>