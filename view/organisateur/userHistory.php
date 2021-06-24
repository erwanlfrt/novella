<?php
    if (!$_SESSION['admin']) {
        header("Location: /?action=home");
    }

    use \model\tables\Jury;
    use \model\tables\Prejury;
    use \model\tables\User;

    $jury = new Jury;
    $prejury = new Prejury;
    $user = new User;

    $mail = $_GET['mail'];
    $userInfo = $user->getUser($mail);

    $listCompetitionJury = $jury->listCompetitions($mail);
    $listCompetitionPrejury = $prejury->listCompetitions($mail);

    $userInfo = $user->getUser($mail);

    $listCompetitionJury = $jury->listCompetitions($mail);
    $listCompetitionPrejury = $prejury->listCompetitions($mail);

    $array = array();

    while ($data = mysqli_fetch_array($listCompetitionJury)) {
        $array[$data['competition']]['theme'] = $data['theme'];
        $array[$data['competition']]['id'] = $data['competition'];
    }

    while ($data = mysqli_fetch_array($listCompetitionPrejury)) {
        $array[$data['competition']]['theme'] = $data['theme'];
        $array[$data['competition']]['id'] = $data['competition'];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Novelis - Historique</title>
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
            <h1 id="title">Historique de <?= $userInfo['firstname'], " ", $userInfo['name'] ?></h1>
            <?php if($array != array()) { ?>
                <ul class="container__list">
                    <?php foreach ($array as $item) { ?>
                        <a href="/?action=result&id=<?= $item['id'] ?>">
                            <li class="container__element">
                                <p class="container__link"><?= $item['theme'] ?></p>
                            </li>
                        </a>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p class="container__empty">Aucun historique disponible pour cet utilisateur.</p>
            <?php } ?>
        </main>
    </body>
</html>