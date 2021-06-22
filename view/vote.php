<?php

if (!$_SESSION) {
  header("Location: /");
}

use \model\tables\Novella;
use \model\tables\Jury;
use \model\tables\Prejury;

$novella = new Novella;
$id = $_GET['id'];
$novellas = $novella->listNovellas($id);

$pre = "";
if (isset($_GET['pre'])) {
  $pre = "&pre";
  $juryAccess = new Prejury;
} else {
  $juryAccess = new Jury;
}
$jury = $juryAccess->getCompetition($_GET['id'], $_SESSION["email"]);
$remainingPoints = mysqli_fetch_array($jury)[2];


?>
<html>

<head>
  <title>Novella</title>
</head>

<body>
  <h1>Vote</h1>
  <div>
    <?php
    while ($data = mysqli_fetch_array($novellas)) {
    ?><li><a href="?action=readAndVote<?php echo $pre; ?>&id=<?php echo $data[0] ?>"><?php echo $data[1]; ?></a></li><?php
                                                                                                                          }
                                                                                                                            ?>
  </div>
  <h3>points restants = <?php echo $remainingPoints ?></h3>

</body>

</html>