<?php 
  $logged = (session_status() === PHP_SESSION_ACTIVE);
?>

<html>
  <head>
    <title>Novella</title>
  </head>
  <body>
    <p>Vous semblez perdu</p>
    <a href="<?php  echo $logged? "?action=home" : "?action=login"?>">Go back to safety</a>
  </body>
  
</html>