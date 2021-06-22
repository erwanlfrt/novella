<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novella - Inscription</title>
    <link rel="stylesheet" href="view/style/globalStyle.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;500;900&display=swap');
    </style> 
  </head>
  <body>
    <main>
      <h1 id="title">Novella</h1>
    
      <form class="form" action="?action=register" method="POST">
        <h2 class="form__title">Inscription</h2>
        <div class="form__login">
          <input tyê="firstname" class="form__login__input" name="firstname" placeholder="Votre prénom"/>
          <input type="name" class="form__login__input" name="name" placeholder="Votre nom"/>
          <input type="text" class="form__login__input" name="email" placeholder="Votre email"/>
          <input type="password" class="form__login__input" name="password" placeholder="Votre mot de passe"/>
          <input type="password" class="form__login__input" name="password_confirm" placeholder="Confirmation de votre mot de passe"/>
          <input type="submit" class="form__login__submit" value="Inscription"/>
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
      </form>
    </main>
  </body>
</html>