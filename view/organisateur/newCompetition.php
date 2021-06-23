<?php
  if (!$_SESSION['admin']) {
    header("Location: /?action=home");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novelis - Nouveau concours</title>
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
        <?php if ($_SESSION['admin']) { ?>
        <a class="header__link" href="?action=pageOrganisateur">RETOUR</a> <?php ;
        } ?>
        <a class="header__link" href="?action=myAccount">GÉRER MON COMPTE</a>
        <a class="header__link" href="?action=disconnect">DÉCONNEXION</a>
      </div>
    </header>
    <main>
      <form class="form" id="form" name="form" action="?action=addCompetition" method="POST">
        <h2 class="form__title">Ajouter un concours</h2>
        <input class="form__login__input" type="text" name="theme" placeholder="Thème"/>
        <textarea class="form__login__textarea" type="text" name="incipit" placeholder="Incipit"></textarea>
        <p class="form__label">Deadline pour les candidats</p>
        <input class="form__login__input" type="date" name="deadline" placeholder="deadline"/>
        <p class="form__label">Deadline pour les pré-jurys</p>
        <input class="form__login__input" type="date" name="prejuryDate" placeholder="deadline"/>
        <p class="form__label">Deadline pour les jurys</p>
        <input class="form__login__input" type="date" name="juryDate" placeholder="deadline"/>

        <input class="form__login__input" style="margin-top: 2rem;" type="text" id="requiredWords" name="requiredWords" placeholder="Insérer un mot de contrainte"/>
        <div class="button" onclick="addWord()">Ajouter le mot</div>
        <div class="form__sub__content" id="error"></div>
        <p class="form__label">Mots de contrainte</p>
        <div class="form__sub__error" id="words" style="margin-bottom: 2rem;"></div>

        <input class="form__login__submit" type="submit" class="submit" value="Ajouter le concours"/>
      </form>
    </main>
  </body>

  <script>
    let arrayOfWord = [];
    let inputElement = document.getElementById('requiredWords');
    let errorElement = document.getElementById('error');
    let wordsElement = document.getElementById('words');

    function addWord() {
      let word = inputElement.value;
      if (word.trim() === "") {
        errorElement.innerHTML = "Erreur : Entrée vide";
      } else {
        errorElement.innerHTML = "";
        arrayOfWord.push(word);
        document.form.requiredWords.value = arrayOfWord;
        words.innerHTML = arrayOfWord.join(' - ');
      }
      inputElement.value = "";
    }
  </script>
</html>