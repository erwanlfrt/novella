<?php

if (!$_SESSION['admin']) {
    header("Location: /?action=home");
}

use \model\tables\Jury;
use \model\tables\Prejury;
use \model\tables\User;

$jury = new Jury;
$prejury = new prejury;
$user = new User;

$mail = $_GET['mail'];

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

<html>

<head>
    <title>Historique</title>
</head>

<body>
    <div class="main">
        <h2>Historique de <?= $userInfo['firstname'], " ", $userInfo['name'] ?></h2>
        <ul>
            <?php foreach ($array as $item) { ?>
                <li><a href="/?action=result&id=<?= $item['id'] ?>"><?= $item['theme'] ?></a></li>
            <?php } ?>
        </ul>
    </div>
</body>

</html>