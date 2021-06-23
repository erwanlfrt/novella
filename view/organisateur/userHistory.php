<?php

if (!$_SESSION['admin']) {
    header("Location: /?action=home");
}

use \model\tables\Jury;
use \model\tables\Prejury;

$jury = new Jury;
$prejury = new prejury;

$mail = $_GET['mail'];

$listCompetitionJury = $jury->listCompetitions($mail);
$listCompetitionPrejury = $prejury->listCompetitions($mail);

$array = array();

while ($data = mysqli_fetch_array($listCompetitionJury)) {
    $array[] = $data['theme'];
}

while ($data = mysqli_fetch_array($listCompetitionPrejury)) {
    $array[] = $data['theme'];
}

?>

<html>

<head>
    <title>Historique de l'utilisateur</title>
</head>

<body>
    <div class="main">
        <h2>Historique</h2>
        <ul>
            <?php foreach ($array as $item) { ?>
                <li><?= $item ?></li>
            <?php } ?>
        </ul>
    </div>
</body>

</html>