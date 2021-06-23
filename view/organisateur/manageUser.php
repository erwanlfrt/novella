<?php
    if (!$_SESSION['admin']) {
        header("Location: /?action=home");
    }

    use \model\tables\Competition;

    $competition = new Competition;
    $listCompetition = $competition->listAvailableCompetitions();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Novelis - Ajout d'utilisateur</title>
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
            <form class="form" action="?action=setCompetitionJurors" method="POST">
                <h2 class="form__title">Ajout d'un utilisateur à un concours</h2>
                <div class="form__container">
                    <div class="form__container__radio">
                        <input class="form__radio__button" type="radio" id="Prejury" name="select" value="Prejury">
                        <label class="form__radio__label" for="Prejury">Pré-jury</label>
                    </div>
                    <div class="form__container__radio">
                        <input class="form__radio__button" type="radio" id="Jury" name="select" value="Jury">
                        <label class="form__radio__label" for="Jury">Jury</label>
                    </div>
                </div>
                <select class="form__select" id="select_theme" name="competition">
                    <!--<option value="" disabled selected>Sélectionnez un concours</option>-->
                    <?php while ($data = mysqli_fetch_array($listCompetition)) { ?>
                        <option value="<?= $data[1] ?>"><?= $data[0] ?></option>
                    <?php } ?>
                </select><br />
                <input class="form__login__input" type="text" name="mail" placeholder="Email" value="<?= $_GET['mail'] ?>" /><br />
                <input class="form__login__submit" type="submit" class="submit" value="Ajouter" />
            </form>
        </main>
    </body>
</html>