<?php

if (!$_SESSION['admin']) {
    header("Location: /?action=home");
}

use \model\tables\Competition;

$competition = new Competition;
$listCompetition = $competition->listAvailableCompetitions();

?>

<html>

<head>
    <title>Gérer l'utilisateur</title>
</head>

<body>
    <div class="main">
        <h1 id="title">Ajouter un concour</h1>

        <form action="?action=setCompetitionJurors" method="POST">
            <input type="radio" id="Prejury" name="select" value="Prejury">
            <label for="Prejury">Prejury</label>
            <input type="radio" id="Jury" name="select" value="Jury">
            <label for="Jury">Jury</label><br />
            <select id="select_theme" name="competition">
                <?php while ($data = mysqli_fetch_array($listCompetition)) { ?>
                    <option value="<?= $data[1] ?>"><?= $data[0] ?></option>
                <?php } ?>
            </select><br />
            <input type="text" name="mail" value="<?= $_GET['mail'] ?>" /><br />
            <input type="submit" class="submit" value="Ajouter" />
        </form>
    </div>

</body>

</html>